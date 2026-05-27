<?php

<<<<<<< HEAD
namespace Modules\LogViewer\Providers;
=======
namespace Nasirkhan\ModuleManager\Modules\LogViewer\Providers;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use Illuminate\Support\ServiceProvider;

class LogViewerServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'LogViewer';

    /**
     * @var string
     */
    protected $moduleNameLower = 'logviewer';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerConfig();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configPath = __DIR__.'/../config/log-viewer.php';

        // Merge module config with app config
        $this->mergeConfigFrom($configPath, 'log-viewer');

        // Publish config for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path('log-viewer.php'),
            ], ['config', 'logviewer-config', 'logviewer-module-config']);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
