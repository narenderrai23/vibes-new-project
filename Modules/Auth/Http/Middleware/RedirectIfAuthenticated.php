<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirect already-authenticated users away from guest-only pages.
 * Works for the student and trainer guards.
 */
class RedirectIfAuthenticated
{
    private array $redirectMap = [
        'student' => '/student/dashboard',
        'trainer' => '/trainer/dashboard',
    ];

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $redirectTo = $this->redirectMap[$guard] ?? '/';

                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
