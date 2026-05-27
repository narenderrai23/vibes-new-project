<?php

<<<<<<< HEAD
namespace Modules\Menu\Providers;
=======
namespace Nasirkhan\ModuleManager\Modules\Menu\Providers;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    protected function configureEmailVerification(): void
    {
        // Email verification is handled by the application's AppServiceProvider.
    }
}
