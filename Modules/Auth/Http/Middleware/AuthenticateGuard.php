<?php

namespace Modules\Auth\Http\Middleware;

use App\Support\PanelRedirector;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateGuard
{
    public function __construct(private readonly PanelRedirector $redirector)
    {
    }

    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (! Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                throw new AuthenticationException('Unauthenticated.');
            }

            return redirect()->guest($this->redirector->loginUrlForGuard($guard));
        }

        return $next($request);
    }
}
