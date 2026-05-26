<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protect routes for a specific guard.
 * Usage in routes: middleware(['auth.guard:student'])
 */
class AuthenticateGuard
{
    /**
     * Map each guard to its login route name.
     */
    private array $loginRoutes = [
        'student' => 'student.login',
        'trainer' => 'trainer.login',
    ];

    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (! Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                throw new AuthenticationException('Unauthenticated.');
            }

            $loginRoute = $this->loginRoutes[$guard] ?? 'login';

            return redirect()->guest(route($loginRoute));
        }

        return $next($request);
    }
}
