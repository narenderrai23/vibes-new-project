<?php

namespace App\Console\Commands\ModuleManager;

use Illuminate\Console\Command;

class ModuleHelpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:help {topic? : Specific help topic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display help for module management commands';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $topic = $this->argument('topic');

        if ($topic) {
            return $this->showTopicHelp($topic);
        }

        return $this->showGeneralHelp();
    }

    /**
     * Show general help overview.
     */
    protected function showGeneralHelp(): int
    {
        $this->newLine();
        $this->line('
  <fg=bright-blue>╔═══════════════════════════════════════════════════════════════╗</>
  <fg=bright-blue>║</> <fg=bright-white>            MODULE MANAGER - COMMAND REFERENCE</>               <fg=bright-blue>║</>
  <fg=bright-blue>╚═══════════════════════════════════════════════════════════════╝</>
        ');

        $this->newLine();
        $this->components->twoColumnDetail('<fg=yellow>🎯 ESSENTIAL COMMANDS</>', '<fg=gray>(Most Used)</>');
        $this->newLine();

        $this->line('  <fg=green>module:status</> [module]');
        $this->line('    View module status, versions, and dependencies');
        $this->newLine();

        $this->line('  <fg=green>module:dependencies</> [module]');
        $this->line('    Check if module dependencies are satisfied');
        $this->newLine();

        $this->line('  <fg=green>module:publish</> {module}');
        $this->line('    Publish module to Modules/ directory for customization');
        $this->newLine();

        $this->line('  <fg=green>module:diff</> {module} [--detailed]');
        $this->line('    Compare package vs published version');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=yellow>🔄 MIGRATION MANAGEMENT</>', '');
        $this->newLine();

        $this->line('  <fg=green>module:track-migrations</> [module] [--force]');
        $this->line('    Track current migration state (do before composer update)');
        $this->newLine();

        $this->line('  <fg=green>module:detect-updates</> [module]');
        $this->line('    Detect new migrations after package update');
        $this->newLine();

        $this->line('  <fg=green>module:check-migrations</> [module]');
        $this->line('    Check for unpublished migrations');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=yellow>🧪 DEVELOPMENT & TESTING</>', '');
        $this->newLine();

        $this->line('  <fg=green>module:make-test</> {module} {name} [--unit]');
        $this->line('    Generate a test class for a module');
        $this->newLine();

        $this->line('  <fg=green>module:enable</> {module}');
        $this->line('    Enable a disabled module');
        $this->newLine();

        $this->line('  <fg=green>module:disable</> {module}');
        $this->line('    Disable a module without deleting');
        $this->newLine();

        $this->components->twoColumnDetail('<fg=yellow>📚 HELP TOPICS</>', '');
        $this->newLine();

        $this->line('  <fg=cyan>module:help workflows</> - Common workflows');
        $this->line('  <fg=cyan>module:help update</>    - After composer update workflow');
        $this->line('  <fg=cyan>module:help custom</>    - Customizing modules');
        $this->line('  <fg=cyan>module:help testing</>   - Testing modules');
        $this->newLine();

        $this->components->info('💡 Tip: Use module:help {topic} for detailed help on any topic');
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Show help for specific topic.
     */
    protected function showTopicHelp(string $topic): int
    {
        return match (strtolower($topic)) {
            'workflows', 'workflow' => $this->showWorkflowsHelp(),
            'update', 'updates', 'composer' => $this->showUpdateWorkflowHelp(),
            'custom', 'customize', 'customization' => $this->showCustomizationHelp(),
            'test', 'tests', 'testing' => $this->showTestingHelp(),
            default => $this->showUnknownTopic($topic),
        };
    }

    /**
     * Show workflows help.
     */
    protected function showWorkflowsHelp(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail('<fg=bright-blue>📋 COMMON WORKFLOWS</>', '');
        $this->newLine();

        $this->components->warn('1. Fresh Installation:');
        $this->line('   php artisan module:status');
        $this->line('   php artisan module:dependencies');
        $this->line('   php artisan module:track-migrations');
        $this->line('   php artisan migrate');
        $this->line('   php artisan test');
        $this->newLine();

        $this->components->warn('2. After Composer Update:');
        $this->line('   php artisan module:detect-updates');
        $this->line('   php artisan vendor:publish --tag=post-migrations');
        $this->line('   php artisan migrate');
        $this->line('   php artisan module:track-migrations --force');
        $this->newLine();

        $this->components->warn('3. Customizing a Module:');
        $this->line('   php artisan module:publish Post');
        $this->line('   # Edit files in Modules/Post/');
        $this->line('   php artisan module:diff Post --detailed');
        $this->newLine();

        $this->components->info('Use: module:help update|custom|testing for specific workflows');
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Show update workflow help.
     */
    protected function showUpdateWorkflowHelp(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail('<fg=bright-blue>🔄 AFTER COMPOSER UPDATE WORKFLOW</>', '');
        $this->newLine();

        $this->components->warn('STEP 1: Track current state (BEFORE update)');
        $this->line('   <fg=green>php artisan module:track-migrations</>');
        $this->line('   └─ Creates snapshot of current migrations');
        $this->newLine();

        $this->components->warn('STEP 2: Update package');
        $this->line('   <fg=green>composer update nasirkhan/module-manager</>');
        $this->line('   └─ Updates to latest version');
        $this->newLine();

        $this->components->warn('STEP 3: Detect changes');
        $this->line('   <fg=green>php artisan module:detect-updates</>');
        $this->line('   └─ Shows new migrations and version changes');
        $this->newLine();

        $this->components->warn('STEP 4: Publish new migrations (if any)');
        $this->line('   <fg=green>php artisan vendor:publish --tag=post-migrations</>');
        $this->line('   └─ Publishes new migration files');
        $this->newLine();

        $this->components->warn('STEP 5: Review & run migrations');
        $this->line('   <fg=green>php artisan migrate</>');
        $this->line('   └─ Applies database changes');
        $this->newLine();

        $this->components->warn('STEP 6: Update tracking state');
        $this->line('   <fg=green>php artisan module:track-migrations --force</>');
        $this->line('   └─ Updates tracking to new state');
        $this->newLine();

        $this->components->warn('STEP 7: Check for code changes (optional)');
        $this->line('   <fg=green>php artisan module:diff Post</>');
        $this->line('   └─ Shows code differences if module is published');
        $this->newLine();

        $this->components->info('💡 Always track BEFORE updating to detect changes');
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Show customization help.
     */
    protected function showCustomizationHelp(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail('<fg=bright-blue>🎨 CUSTOMIZING MODULES</>', '');
        $this->newLine();

        $this->components->warn('Why customize a module?');
        $this->line('   • Add new features');
        $this->line('   • Modify views or routes');
        $this->line('   • Change business logic');
        $this->line('   • Extend functionality');
        $this->newLine();

        $this->components->warn('Steps to customize:');
        $this->newLine();

        $this->line('   <fg=yellow>1.</> Check current status');
        $this->line('      <fg=green>php artisan module:status Post</>');
        $this->newLine();

        $this->line('   <fg=yellow>2.</> Publish the module');
        $this->line('      <fg=green>php artisan module:publish Post</>');
        $this->line('      └─ Copies to Modules/Post/');
        $this->newLine();

        $this->line('   <fg=yellow>3.</> Make your changes');
        $this->line('      Edit files in: Modules/Post/');
        $this->newLine();

        $this->line('   <fg=yellow>4.</> After package update, check diff');
        $this->line('      <fg=green>php artisan module:diff Post --detailed</>');
        $this->line('      └─ Shows upstream changes');
        $this->newLine();

        $this->line('   <fg=yellow>5.</> Manually merge if needed');
        $this->line('      Review changes and merge manually');
        $this->newLine();

        $this->components->warn('⚠️  Important Notes:');
        $this->line('   • Published modules won\'t auto-update via composer');
        $this->line('   • You\'re responsible for merging upstream changes');
        $this->line('   • Use version control for your customizations');
        $this->line('   • Only publish if absolutely necessary');
        $this->newLine();

        $this->components->info('💡 Use module:diff regularly to stay in sync with updates');
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Show testing help.
     */
    protected function showTestingHelp(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail('<fg=bright-blue>🧪 TESTING MODULES</>', '');
        $this->newLine();

        $this->components->warn('Creating Tests:');
        $this->newLine();

        $this->line('   <fg=yellow>Feature Test</> (uses database, HTTP)');
        $this->line('   <fg=green>php artisan module:make-test Post CreatePostTest</>');
        $this->newLine();

        $this->line('   <fg=yellow>Unit Test</> (isolated, fast)');
        $this->line('   <fg=green>php artisan module:make-test Post PostModelTest --unit</>');
        $this->newLine();

        $this->components->warn('Running Tests:');
        $this->newLine();

        $this->line('   <fg=yellow>All tests</>');
        $this->line('   <fg=green>php artisan test</>');
        $this->newLine();

        $this->line('   <fg=yellow>Specific module tests</>');
        $this->line('   <fg=green>php artisan test --filter=Post</>');
        $this->newLine();

        $this->line('   <fg=yellow>With coverage</>');
        $this->line('   <fg=green>php artisan test --coverage</>');
        $this->newLine();

        $this->components->warn('Test Structure:');
        $this->line('   Modules/Post/Tests/');
        $this->line('   ├── Feature/  (integration tests)');
        $this->line('   └── Unit/     (isolated tests)');
        $this->newLine();

        $this->components->info('💡 Write tests for new features before implementing');
        $this->newLine();

        return self::SUCCESS;
    }

    /**
     * Show unknown topic message.
     */
    protected function showUnknownTopic(string $topic): int
    {
        $this->components->error("Unknown help topic: {$topic}");
        $this->newLine();
        $this->line('Available topics:');
        $this->line('  • workflows  - Common workflows');
        $this->line('  • update     - After composer update');
        $this->line('  • custom     - Customizing modules');
        $this->line('  • testing    - Testing modules');
        $this->newLine();

        return self::FAILURE;
    }
}
