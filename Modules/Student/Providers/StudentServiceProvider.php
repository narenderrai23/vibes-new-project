<?php

namespace Modules\Student\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Http\Middleware\AuthenticateGuard;
use Modules\Auth\Http\Middleware\RedirectIfAuthenticated;

class StudentServiceProvider extends ServiceProvider
{
    protected string $moduleName      = 'Student';
    protected string $moduleNameLower = 'student';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(base_path('Modules/Student/database/migrations'));
        $this->loadRoutesFrom(base_path('Modules/Student/routes/web.php'));

        // Register shared guard middleware aliases (safe to call multiple times — router deduplicates)
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
            base_path('Modules/Student/Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');

        $this->mergeConfigFrom(
            base_path('Modules/Student/Config/config.php'),
            $this->moduleNameLower
        );
    }

    public function registerViews(): void
    {
        $sourcePath = base_path('Modules/Student/Resources/views');

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
