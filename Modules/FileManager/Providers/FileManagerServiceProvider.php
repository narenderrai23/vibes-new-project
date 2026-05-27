<?php

<<<<<<< HEAD
namespace Modules\FileManager\Providers;
=======
namespace Nasirkhan\ModuleManager\Modules\FileManager\Providers;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'FileManager';

    /**
     * @var string
     */
    protected $moduleNameLower = 'filemanager';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //
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
