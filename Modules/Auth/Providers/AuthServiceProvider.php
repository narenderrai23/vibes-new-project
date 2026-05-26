<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Http\Middleware\AuthenticateGuard;
use Modules\Auth\Http\Middleware\RedirectIfAuthenticated;

/**
 * Auth module service provider.
 *
 * Responsibilities:
 *  - Register the shared auth middleware aliases (auth.guard, auth.guest)
 *    used by Student, Trainer, and Clinic modules.
 *  - Load the admin dashboard route (web guard).
 *
 * Each role portal (Student, Trainer, Clinic) is a separate module with
 * its own model, migration, controller, views, and routes.
 */
class AuthServiceProvider extends ServiceProvider
{
    protected string $moduleName      = 'Auth';
    protected string $moduleNameLower = 'auth';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadRoutesFrom(base_path('Modules/Auth/routes/web.php'));

        // Register shared guard middleware aliases.
        // Student, Trainer, and Clinic service providers also call these —
        // the router silently overwrites with the same class, so no conflict.
        $router = $this->app['router'];
        $router->aliasMiddleware('auth.guard', AuthenticateGuard::class);
        $router->aliasMiddleware('auth.guest', RedirectIfAuthenticated::class);
    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            base_path('Modules/Auth/Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');

        $this->mergeConfigFrom(
            base_path('Modules/Auth/Config/config.php'),
            $this->moduleNameLower
        );
    }

    public function registerViews(): void
    {
        $sourcePath = base_path('Modules/Auth/Resources/views');

        $this->publishes([
            $sourcePath => resource_path('views/modules/' . $this->moduleNameLower),
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', $this->moduleNameLower);
    }

    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
