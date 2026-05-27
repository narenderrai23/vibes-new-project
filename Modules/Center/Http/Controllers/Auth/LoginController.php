<?php

namespace Modules\Center\Http\Controllers\Auth;

<<<<<<< HEAD
use Illuminate\Auth\Events\Lockout;
=======
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
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
    protected string $guard = 'center';

<<<<<<< HEAD
    public function create(): View
=======
    protected string $redirectTo = '/center/dashboard';

    public function showLoginForm(): View
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
    {
        return view('center::auth.login');
    }

<<<<<<< HEAD
    public function store(Request $request): RedirectResponse
=======
    public function login(Request $request): RedirectResponse
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
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

<<<<<<< HEAD
        return redirect()->intended(route('center.dashboard'));
=======
        return redirect()->intended($this->redirectTo);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('center.login');
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

<<<<<<< HEAD
        event(new Lockout($request));

=======
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
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
<<<<<<< HEAD
        return Str::transliterate('center|' . Str::lower($request->string('email')) . '|' . $request->ip());
=======
        return 'center|' . Str::lower($request->string('email')) . '|' . $request->ip();
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
    }
}
