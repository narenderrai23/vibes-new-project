<?php

namespace Tests\Feature\Commands;

use App\Services\MigrationTracker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ModuleManagerCommandsTest extends TestCase
{
    private ?string $originalModuleStatuses = null;

    private bool $moduleStatusesExisted = false;

    private bool $vendorModuleManagerExisted = false;

    protected function setUp(): void
    {
        parent::setUp();

        $statusFile = base_path('modules_statuses.json');
        $this->moduleStatusesExisted = File::exists($statusFile);
        $this->originalModuleStatuses = $this->moduleStatusesExisted ? File::get($statusFile) : null;
        $this->vendorModuleManagerExisted = File::exists(base_path('vendor/nasirkhan/module-manager'));

        FakePermission::reset();
        config()->set('permission.models.permission', FakePermission::class);
        config()->set('auth.providers.users.model', FakeUser::class);
    }

    protected function tearDown(): void
    {
        foreach ([
            'CodexBuild',
            'CodexDependency',
            'CodexDiff',
            'CodexMigrator',
            'CodexPublish',
            'CodexRemove',
            'CodexStatus',
            'CodexTest',
            'CodexTrack',
        ] as $module) {
            File::deleteDirectory(base_path("Modules/{$module}"));
            File::deleteDirectory(base_path("vendor/nasirkhan/module-manager/src/Modules/{$module}"));
        }

        File::deleteDirectory(storage_path('framework/testing/module-manager-stubs'));

        if (! $this->vendorModuleManagerExisted) {
            $this->deleteEmptyDirectory(base_path('vendor/nasirkhan/module-manager/src/Modules'));
            $this->deleteEmptyDirectory(base_path('vendor/nasirkhan/module-manager/src'));
            $this->deleteEmptyDirectory(base_path('vendor/nasirkhan/module-manager'));
            $this->deleteEmptyDirectory(base_path('vendor/nasirkhan'));
        }

        $statusFile = base_path('modules_statuses.json');
        if ($this->moduleStatusesExisted) {
            File::put($statusFile, $this->originalModuleStatuses);
        } else {
            File::delete($statusFile);
        }

        parent::tearDown();
    }

    public function test_all_module_manager_commands_are_registered(): void
    {
        $commands = collect($this->app['Illuminate\Contracts\Console\Kernel']->all());

        foreach ([
            'auth:permissions',
            'clear-all',
            'laravel-starter:insert-demo-data',
            'module:build',
            'module:check-migrations',
            'module:dependencies',
            'module:detect-updates',
            'module:diff',
            'module:disable',
            'module:enable',
            'module:help',
            'module:make-test',
            'module:publish',
            'module:remove',
            'module:status',
            'module:track-migrations',
        ] as $command) {
            $this->assertTrue($commands->has($command), "Expected [{$command}] to be registered.");
        }
    }

    public function test_auth_permissions_command_creates_and_removes_default_permissions(): void
    {
        $this->artisan('auth:permissions', ['name' => 'article'])
            ->assertSuccessful();

        $this->assertSame([
            'view_articles',
            'add_articles',
            'edit_articles',
            'delete_articles',
            'restore_articles',
        ], array_keys(FakePermission::$permissions));

        $this->artisan('auth:permissions', ['name' => 'article', '--remove' => true])
            ->assertSuccessful();

        $this->assertSame([], FakePermission::$permissions);
    }

    public function test_clear_all_command_runs_successfully(): void
    {
        $this->artisan('clear-all')
            ->assertSuccessful();
    }

    public function test_insert_demo_data_fails_when_admin_user_is_missing(): void
    {
        $this->artisan('laravel-starter:insert-demo-data')
            ->expectsOutputToContain('No user with ID 1 found')
            ->assertFailed();
    }

    public function test_module_build_generates_a_module_from_configured_stubs(): void
    {
        $this->configureMinimalBuildStubs();

        $this->artisan('module:build', ['moduleName' => 'codex-build'])
            ->assertSuccessful();

        $this->assertFileExists(base_path('Modules/CodexBuild/composer.json'));
        $this->assertFileExists(base_path('Modules/CodexBuild/module.json'));
        $this->assertSame('CodexBuild', json_decode(File::get(base_path('Modules/CodexBuild/module.json')), true)['name']);
        $this->assertTrue(json_decode(File::get(base_path('modules_statuses.json')), true)['CodexBuild']);
        $this->assertArrayHasKey('view_codexbuilds', FakePermission::$permissions);
    }

    public function test_module_enable_and_disable_update_boolean_statuses(): void
    {
        $this->writeStatuses(['CodexStatus' => true]);

        $this->artisan('module:disable', ['moduleName' => 'codex-status'])
            ->assertSuccessful();

        $this->assertFalse(json_decode(File::get(base_path('modules_statuses.json')), true)['CodexStatus']);

        $this->artisan('module:enable', ['moduleName' => 'codex-status'])
            ->assertSuccessful();

        $this->assertTrue(json_decode(File::get(base_path('modules_statuses.json')), true)['CodexStatus']);
    }

    public function test_module_enable_and_disable_update_array_statuses(): void
    {
        $this->writeStatuses(['CodexStatus' => ['enabled' => true, 'published' => true]]);

        $this->artisan('module:disable', ['moduleName' => 'codex-status'])
            ->assertSuccessful();

        $statuses = json_decode(File::get(base_path('modules_statuses.json')), true);
        $this->assertFalse($statuses['CodexStatus']['enabled']);
        $this->assertTrue($statuses['CodexStatus']['published']);

        $this->artisan('module:enable', ['moduleName' => 'codex-status'])
            ->assertSuccessful();

        $this->assertTrue(json_decode(File::get(base_path('modules_statuses.json')), true)['CodexStatus']['enabled']);
    }

    public function test_module_remove_deletes_the_module_and_status_entry_when_forced(): void
    {
        $this->writePublishedModule('CodexRemove');
        $this->writeStatuses(['CodexRemove' => true]);

        $this->artisan('module:remove', ['moduleName' => 'codex-remove', '--force' => true])
            ->assertSuccessful();

        $this->assertDirectoryDoesNotExist(base_path('Modules/CodexRemove'));
        $this->assertArrayNotHasKey('CodexRemove', json_decode(File::get(base_path('modules_statuses.json')), true));
    }

    public function test_module_make_test_generates_feature_and_unit_tests(): void
    {
        $this->writePublishedModule('CodexTest');

        $this->artisan('module:make-test', ['module' => 'CodexTest', 'name' => 'GeneratedFeatureTest'])
            ->assertSuccessful();

        $this->artisan('module:make-test', ['module' => 'CodexTest', 'name' => 'GeneratedUnitTest', '--unit' => true])
            ->assertSuccessful();

        $this->assertFileExists(base_path('Modules/CodexTest/Tests/Feature/GeneratedFeatureTest.php'));
        $this->assertFileExists(base_path('Modules/CodexTest/Tests/Unit/GeneratedUnitTest.php'));
    }

    public function test_module_status_displays_published_modules_and_reports_missing_module(): void
    {
        $this->writePublishedModule('CodexStatus');

        $this->artisan('module:status')
            ->expectsOutputToContain('CodexStatus')
            ->assertSuccessful();

        $this->artisan('module:status', ['module' => 'CodexMissing'])
            ->assertFailed();
    }

    public function test_module_dependencies_reports_satisfied_and_missing_dependencies(): void
    {
        $this->writePublishedModule('CodexDependency', ['requires' => ['CodexStatus']]);
        $this->writePublishedModule('CodexStatus');
        $this->writeStatuses(['CodexDependency' => true, 'CodexStatus' => true]);

        $this->artisan('module:dependencies', ['module' => 'CodexDependency'])
            ->assertSuccessful();

        File::deleteDirectory(base_path('Modules/CodexStatus'));

        $this->artisan('module:dependencies', ['module' => 'CodexDependency'])
            ->assertFailed();
    }

    public function test_module_check_migrations_finds_unrun_module_migrations(): void
    {
        $migration = '2026_01_01_000000_create_codex_migrators_table.php';
        $this->writePublishedModule('CodexMigrator', migrations: [$migration]);
        $this->writeStatuses(['CodexMigrator' => true]);

        $this->artisan('module:check-migrations', ['module' => 'CodexMigrator'])
            ->expectsOutputToContain($migration)
            ->assertSuccessful();
    }

    public function test_module_track_migrations_stores_current_module_state(): void
    {
        $this->writePublishedModule('CodexTrack', migrations: ['2026_01_01_000000_create_codex_tracks_table.php']);
        $this->writeStatuses(['CodexTrack' => true]);

        $this->artisan('module:track-migrations', ['module' => 'CodexTrack'])
            ->assertSuccessful();

        $this->assertSame('1.0.0', DB::table('module_migrations_tracking')->where('module', 'CodexTrack')->value('version'));
    }

    public function test_module_detect_updates_reports_untracked_and_tracked_modules(): void
    {
        $this->writePublishedModule('CodexTrack', migrations: ['2026_01_01_000000_create_codex_tracks_table.php']);

        $this->artisan('module:detect-updates', ['module' => 'CodexTrack'])
            ->assertFailed();

        app(MigrationTracker::class)->trackModuleMigrations('CodexTrack', '1.0.0');

        $this->artisan('module:detect-updates', ['module' => 'CodexTrack'])
            ->assertSuccessful();
    }

    public function test_module_diff_compares_package_and_published_modules(): void
    {
        $this->writePackageModule('CodexDiff', ['extra.txt' => 'package']);
        $this->writePublishedModule('CodexDiff');
        File::put(base_path('Modules/CodexDiff/extra.txt'), 'published');

        $this->artisan('module:diff', ['module' => 'CodexDiff'])
            ->expectsOutputToContain('Modified files')
            ->assertSuccessful();
    }

    public function test_module_publish_copies_package_module_and_updates_status(): void
    {
        $this->writePackageModule('CodexPublish', [
            'composer.json' => json_encode([
                'name' => 'nasirkhan/codex-publish',
                'version' => '2.0.0',
                'autoload' => ['psr-4' => ['Modules\\CodexPublish\\' => '']],
            ], JSON_PRETTY_PRINT),
            'src.php' => '<?php namespace Modules\\CodexPublish; class Src {}',
        ]);

        $this->artisan('module:publish', ['module' => 'CodexPublish', '--force' => true])
            ->assertSuccessful();

        $this->assertFileExists(base_path('Modules/CodexPublish/src.php'));
        $status = json_decode(File::get(base_path('modules_statuses.json')), true)['CodexPublish'];
        $this->assertTrue($status['enabled']);
        $this->assertTrue($status['published']);
        $this->assertSame('2.0.0', $status['version']);
    }

    public function test_module_help_handles_general_known_and_unknown_topics(): void
    {
        $this->artisan('module:help')
            ->assertSuccessful();

        $this->artisan('module:help', ['topic' => 'testing'])
            ->assertSuccessful();

        $this->artisan('module:help', ['topic' => 'unknown-topic'])
            ->assertFailed();
    }

    private function configureMinimalBuildStubs(): void
    {
        $stubPath = storage_path('framework/testing/module-manager-stubs');
        File::ensureDirectoryExists($stubPath);
        File::put($stubPath.'/composer.stub.php', '{"name":"{{composerVendor}}/{{moduleNameLower}}"}');
        File::put($stubPath.'/module.stub.php', '{"name":"{{moduleName}}","version":"1.0.0","requires":[]}');

        config()->set('module-manager.stubs.path', $stubPath);
        config()->set('module-manager.module.files', [
            'composer' => ['composer.stub.php', 'composer.json'],
            'json' => ['module.stub.php', 'module.json'],
        ]);
    }

    private function writeStatuses(array $statuses): void
    {
        File::put(base_path('modules_statuses.json'), json_encode($statuses, JSON_PRETTY_PRINT));
    }

    private function writePublishedModule(string $module, array $data = [], array $migrations = []): void
    {
        $path = base_path("Modules/{$module}");
        File::ensureDirectoryExists($path);
        File::put($path.'/module.json', json_encode(array_merge([
            'name' => $module,
            'version' => '1.0.0',
            'description' => "{$module} test module",
            'requires' => [],
        ], $data), JSON_PRETTY_PRINT));

        if ($migrations !== []) {
            File::ensureDirectoryExists($path.'/database/migrations');
            foreach ($migrations as $migration) {
                File::put($path.'/database/migrations/'.$migration, '<?php return new class {};');
            }
        }
    }

    private function writePackageModule(string $module, array $files = []): void
    {
        $path = base_path("vendor/nasirkhan/module-manager/src/Modules/{$module}");
        File::ensureDirectoryExists($path);
        File::put($path.'/module.json', json_encode([
            'name' => $module,
            'version' => '1.0.0',
            'description' => "{$module} package module",
            'requires' => [],
        ], JSON_PRETTY_PRINT));

        foreach ($files as $file => $contents) {
            File::ensureDirectoryExists(dirname($path.'/'.$file));
            File::put($path.'/'.$file, $contents);
        }
    }

    private function deleteEmptyDirectory(string $path): void
    {
        if (File::isDirectory($path) && count(File::allFiles($path)) === 0 && count(File::directories($path)) === 0) {
            File::deleteDirectory($path);
        }
    }
}

class FakePermission
{
    public static array $permissions = [];

    public static function reset(): void
    {
        self::$permissions = [];
    }

    public static function firstOrCreate(array $attributes): self
    {
        self::$permissions[$attributes['name']] = true;

        return new self;
    }

    public static function whereIn(string $column, array $values): FakePermissionQuery
    {
        return new FakePermissionQuery($values);
    }
}

class FakePermissionQuery
{
    public function __construct(private readonly array $values)
    {
    }

    public function delete(): int
    {
        $deleted = 0;
        foreach ($this->values as $value) {
            if (isset(FakePermission::$permissions[$value])) {
                unset(FakePermission::$permissions[$value]);
                $deleted++;
            }
        }

        return $deleted;
    }
}

class FakeUser
{
    public static function find(int $id): null
    {
        return null;
    }
}
