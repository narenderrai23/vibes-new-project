<?php

namespace Modules\Student\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Concerns\HandlesOtpLogin;
use App\Support\PanelRedirector;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Student\Models\Student;

class LoginController extends Controller
{
    use HandlesOtpLogin;

    protected string $guard = 'student';

    public function create(): View
    {
        return view('student::auth.login');
    }

    public function store(Request $request): RedirectResponse
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

        return redirect()->intended(app(PanelRedirector::class)->dashboardUrlForGuard($this->guard));
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

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
        return Str::transliterate('student|' . Str::lower($request->string('email')) . '|' . $request->ip());
    }

    protected function findUserByEmail(string $email): ?Student
    {
        return Student::where('email', $email)->first();
    }

    protected function findUserByMobile(string $mobile): ?Student
    {
        return Student::where('mobile', $mobile)->first();
    }

    protected function getRouteNamePrefix(): string
    {
        return 'student';
    }

    protected function getAuthViewPrefix(): string
    {
        return 'student::auth.';
    }
}
