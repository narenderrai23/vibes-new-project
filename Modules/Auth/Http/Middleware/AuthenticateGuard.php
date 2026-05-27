<?php

namespace Modules\Auth\Http\Middleware;

<<<<<<< HEAD
use App\Support\PanelRedirector;
=======
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

<<<<<<< HEAD
class AuthenticateGuard
{
    public function __construct(private readonly PanelRedirector $redirector)
    {
    }
=======
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
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (! Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                throw new AuthenticationException('Unauthenticated.');
            }

<<<<<<< HEAD
            return redirect()->guest($this->redirector->loginUrlForGuard($guard));
=======
            $loginRoute = $this->loginRoutes[$guard] ?? 'login';

            return redirect()->guest(route($loginRoute));
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
        }

        return $next($request);
    }
}
