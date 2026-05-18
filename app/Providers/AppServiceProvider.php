<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Prevent lazy loading, silently discarding attributes, and accessing missing attributes.
         */
        Model::shouldBeStrict(! app()->isProduction());

        /**
         * Change default string length.
         *
         * MariaDB 10.5 allows index keys to be 3072 chars.
         * MySQL 8.0 appears to be allowing only 1000 chars.
         */
        Schema::defaultStringLength(191);

        /**
         * Register Event Listeners.
         */
        $this->registerEventListeners();

        /**
         * Register Model Observers.
         * This is where you can register observers for your models.
         */
        // User model observer
        User::observe(UserObserver::class);

        /**
         * Implicitly grant "Super Admin" role all permissions
         * This works in the app by using gate-related functions like auth()->user->can() and @can().
         *
         * Falls back to a direct DB query if the permission cache is stale,
         * ensuring super admin is never locked out after a fresh seed or cache flush.
         */
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super admin')) {
                return true;
            }

            // Fallback: bypass cache and query DB directly (guards against stale cache)
            \App\Models\User::$useCachedPermissions = false;
            $isSuperAdmin = $user->hasRole('super admin');
            \App\Models\User::$useCachedPermissions = true;

            if ($isSuperAdmin) {
                // Cache was stale — bust it so subsequent requests use fresh data
                $user->clearPermissionCache();

                return true;
            }

            return null;
        });
    }

    public function registerEventListeners(): void
    {
        // Register event listeners here when needed
    }
}
