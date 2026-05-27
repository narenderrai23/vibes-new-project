<?php

use App\Http\Middleware\SetLocale;
use App\Support\PanelRedirector;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->web(SetLocale::class);
        $middleware->web(append: [
            SetLocale::class,
        ]);

        $middleware->redirectGuestsTo(
            fn (Request $request): string => app(PanelRedirector::class)->loginUrlForRequest($request)
        );

        $middleware->redirectUsersTo(
            fn (Request $request): string => app(PanelRedirector::class)->dashboardUrlForAuthenticatedUser($request)
        );

        // Register Spatie Permission middleware aliases
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
