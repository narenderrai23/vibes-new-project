<?php

namespace Modules\Auth\Http\Middleware;

<<<<<<< HEAD
use App\Support\PanelRedirector;
=======
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
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
<<<<<<< HEAD
    public function __construct(private readonly PanelRedirector $redirector)
    {
    }
=======
    private array $redirectMap = [
        'student' => '/student/dashboard',
        'trainer' => '/trainer/dashboard',
    ];
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
<<<<<<< HEAD
                return redirect($this->redirector->dashboardUrlForGuard($guard));
=======
                $redirectTo = $this->redirectMap[$guard] ?? '/';

                return redirect($redirectTo);
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
            }
        }

        return $next($request);
    }
}
