<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use App\Console\Commands\ModuleManager\AuthPermissionsCommand;
use App\Console\Commands\ModuleManager\ClearAllCommand;
use App\Console\Commands\ModuleManager\InsertDemoDataCommand;
use App\Console\Commands\ModuleManager\ModuleBuildCommand;
use App\Console\Commands\ModuleManager\ModuleCheckMigrationsCommand;
use App\Console\Commands\ModuleManager\ModuleDependenciesCommand;
use App\Console\Commands\ModuleManager\ModuleDetectUpdatesCommand;
use App\Console\Commands\ModuleManager\ModuleDiffCommand;
use App\Console\Commands\ModuleManager\ModuleGenerateTestCommand;
use App\Console\Commands\ModuleManager\ModuleHelpCommand;
use App\Console\Commands\ModuleManager\ModulePublishCommand;
use App\Console\Commands\ModuleManager\ModuleRemoveCommand;
use App\Console\Commands\ModuleManager\ModuleDisableCommand;
use App\Console\Commands\ModuleManager\ModuleEnableCommand;
use App\Console\Commands\ModuleManager\ModuleStatusCommand;
use App\Console\Commands\ModuleManager\ModuleTrackMigrationsCommand;
use App\ModuleManager;
use App\Services\MigrationTracker;
use App\Services\ModuleVersion;

class ModuleManagerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerModules();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InsertDemoDataCommand::class,
                ClearAllCommand::class,
                AuthPermissionsCommand::class,
                ModuleBuildCommand::class,
                ModuleRemoveCommand::class,
                ModuleDisableCommand::class,
                ModuleEnableCommand::class,
                ModulePublishCommand::class,
                ModuleStatusCommand::class,
                ModuleDiffCommand::class,
                ModuleCheckMigrationsCommand::class,
                ModuleDependenciesCommand::class,
                ModuleTrackMigrationsCommand::class,
                ModuleDetectUpdatesCommand::class,
                ModuleGenerateTestCommand::class,
                ModuleHelpCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/module-manager.php', 'module-manager');

        $this->app->singleton('module-manager', function () {
            return new ModuleManager;
        });

        $this->app->singleton(ModuleVersion::class, function () {
            return new ModuleVersion;
        });

        $this->app->singleton(MigrationTracker::class, function () {
            return new MigrationTracker;
        });
    }

    public function registerModules(): void
    {
        $statusFile = base_path('modules_statuses.json');

        if (! File::exists($statusFile)) {
            $defaultModules = [
                'Post' => true,
                'Category' => true,
                'Tag' => true,
                'Menu' => true,
            ];
            File::put($statusFile, json_encode($defaultModules, JSON_PRETTY_PRINT));
        }

        try {
            $modules = Cache::remember('module_statuses', 3600, function () use ($statusFile) {
                return json_decode(File::get($statusFile), true);
            });
        } catch (\Exception $e) {
            $modules = json_decode(File::get($statusFile), true);
        }

        if (! is_array($modules)) {
            return;
        }

        foreach ($modules as $module => $enabled) {
            $isEnabled = $enabled === true || (is_array($enabled) && ($enabled['enabled'] ?? true) === true);

            if (! $isEnabled) {
                continue;
            }

            $providerClass = "Modules\\{$module}\\Providers\\{$module}ServiceProvider";

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }
}
