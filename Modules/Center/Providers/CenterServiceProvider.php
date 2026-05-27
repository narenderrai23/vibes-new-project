<?php

namespace Modules\Center\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Http\Middleware\AuthenticateGuard;
use App\Http\Middleware\RedirectIfAuthenticated;
use Symfony\Component\Finder\Finder;

class CenterServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Center';

    /**
     * @var string
     */
    protected $moduleNameLower = 'center';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadRoutesFrom(base_path('Modules/Center/routes/web.php'));
        $this->loadMigrationsFrom(base_path('Modules/Center/database/migrations'));

        $router = $this->app['router'];
        $router->aliasMiddleware('auth.guard', AuthenticateGuard::class);
        $router->aliasMiddleware('auth.guest', RedirectIfAuthenticated::class);

        // register commands
        $this->registerCommands('\Modules\Center\Console\Commands');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        // Event Service Provider
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            base_path('Modules/Center/Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            base_path('Modules/Center/Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = base_path('Modules/Center/Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'center');
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * Register commands.
     *
     * @param  string  $namespace
     */
    protected function registerCommands($namespace = '')
    {
        $consolePath = __DIR__.'/../Console';
        if (! is_dir($consolePath)) {
            return;
        }

        $finder = new Finder(); // from Symfony\Component\Finder;
        $finder->files()->name('*.php')->in($consolePath);

        $classes = [];
        foreach ($finder as $file) {
            $class = $namespace.'\\'.$file->getBasename('.php');
            array_push($classes, $class);
        }

        $this->commands($classes);
    }
}
