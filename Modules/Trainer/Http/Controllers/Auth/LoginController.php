<?php

namespace Modules\Trainer\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected string $guard = 'trainer';

    protected string $redirectTo = '/trainer/dashboard';

    public function showLoginForm(): View
    {
        return view('trainer::auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited($request);

        if (! Auth::guard($this->guard)->attempt(
            ['email' => $request->email, 'password' => $request->password, 'status' => 1],
            $request->boolean('remember')
        )) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));
        $request->session()->regenerate();

        return redirect()->intended($this->redirectTo);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('trainer.login');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return 'trainer|' . Str::lower($request->string('email')) . '|' . $request->ip();
    }
}
