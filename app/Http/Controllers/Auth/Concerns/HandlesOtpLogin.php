<?php

namespace App\Http\Controllers\Auth\Concerns;

use App\Mail\LoginOtpMail;
use App\Support\PanelRedirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

trait HandlesOtpLogin
{
    public function showOtpRequestForm(): View
    {
        return view($this->getAuthViewPrefix() . 'otp-request', [
            'sendOtpRoute' => $this->getOtpSendRouteName(),
            'loginRoute' => $this->getLoginRouteName(),
            'title' => __('OTP Login'),
        ]);
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $method = $this->validateOtpMethod($request);

        $rules = $method === 'sms'
            ? ['mobile' => ['required', 'string', 'min:7', 'max:20']]
            : ['email'  => ['required', 'string', 'email']];

        $request->validate($rules);

        $identifier = $method === 'sms'
            ? $this->normalizeMobile($request->string('mobile'))
            : Str::lower($request->string('email'));

        $field = $method === 'sms' ? 'mobile' : 'email';
        $user  = $method === 'sms'
            ? $this->findUserByMobile($identifier)
            : $this->findUserByEmail($identifier);

        if (! $user || ($user->status ?? 1) !== 1) {
            throw ValidationException::withMessages([
                $field => __('auth.failed'),
            ]);
        }

        $code = $this->generateOtpCode();
        Cache::put($this->getOtpCacheKey($identifier, $method), $code, now()->addMinutes(10));

        if ($method === 'email') {
            $this->sendOtpEmail($user, $code);
        } else {
            $this->sendOtpSms($user, $code);
        }

        return redirect()->route($this->getOtpVerifyRouteName())
            ->with([
                'otp_identifier' => $identifier,
                'otp_method'     => $method,
                'status'         => $method === 'sms'
                    ? __('A one-time code has been sent to your mobile.')
                    : __('A one-time code has been sent to your email.'),
            ]);
    }

    public function showOtpVerifyForm(Request $request): View|RedirectResponse
    {
        $identifier = session('otp_identifier');
        $method     = session('otp_method');

        if (! $identifier || ! $method) {
            return redirect()->route($this->getOtpRequestRouteName());
        }

        return view($this->getAuthViewPrefix() . 'otp-verify', [
            'loginRoute'           => $this->getLoginRouteName(),
            'authenticateOtpRoute' => $this->getOtpAuthenticateRouteName(),
            'identifier'           => $identifier,
            'method'               => $method,
        ]);
    }

    // public function verifyOtp(Request $request): RedirectResponse
    // {
    //     $method = $this->validateOtpMethod($request);

    //     $request->validate([
    //         'identifier' => ['required', 'string'],
    //         'otp_code'   => ['required', 'string', 'size:4'],
    //     ]);

    //     $identifier = $method === 'sms'
    //         ? $this->normalizeMobile($request->string('identifier'))
    //         : Str::lower($request->string('identifier'));

    //     $expected = Cache::get($this->getOtpCacheKey($identifier, $method));

    //     if (! $expected || ! hash_equals($expected, $request->string('otp_code'))) {
    //         RateLimiter::hit($this->throttleKey($request));

    //         throw ValidationException::withMessages([
    //             'otp_code' => __('The one-time code is invalid or has expired.'),
    //         ]);
    //     }

    //     Cache::forget($this->getOtpCacheKey($identifier, $method));

    //     $user = $method === 'sms'
    //         ? $this->findUserByMobile($identifier)
    //         : $this->findUserByEmail($identifier);

    //     if (! $user) {
    //         throw ValidationException::withMessages([
    //             'otp_code' => __('auth.failed'),
    //         ]);
    //     }

    //     return $this->authenticateOtpUser($user, $request);
    // }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $method = $this->validateOtpMethod($request);

        $request->validate([
            'identifier' => ['required', 'string'],
            'otp_code'   => ['required', 'string', 'size:4'],
        ]);

        $identifier = $method === 'sms'
            ? $this->normalizeMobile($request->string('identifier'))
            : Str::lower($request->string('identifier'));

        $otpCode = (string) $request->string('otp_code');

        $expected = Cache::get($this->getOtpCacheKey($identifier, $method));

        if (! $expected || ! hash_equals((string) $expected, $otpCode)) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'otp_code' => __('The one-time code is invalid or has expired.'),
            ]);
        }

        Cache::forget($this->getOtpCacheKey($identifier, $method));

        $user = $method === 'sms'
            ? $this->findUserByMobile($identifier)
            : $this->findUserByEmail($identifier);

        if (! $user) {
            throw ValidationException::withMessages([
                'otp_code' => __('auth.failed'),
            ]);
        }

        return $this->authenticateOtpUser($user, $request);
    }

    protected function validateOtpMethod(Request $request): string
    {
        $request->validate([
            'method' => ['required', 'string', 'in:email,sms'],
        ]);

        return (string) $request->string('method');
    }

    protected function normalizeMobile(string $mobile): string
    {
        return preg_replace('/[^\d+]/', '', $mobile) ?? $mobile;
    }

    protected function findUserByMobile(string $mobile): ?object
    {
        return null;
    }

    protected function panelRedirector(): PanelRedirector
    {
        return app(PanelRedirector::class);
    }

    protected function getLoginRouteName(): string
    {
        return $this->getRouteNamePrefix() . '.login';
    }

    protected function getOtpRequestRouteName(): string
    {
        return $this->getRouteNamePrefix() . '.login.otp.request';
    }

    protected function getOtpSendRouteName(): string
    {
        return $this->getRouteNamePrefix() . '.login.otp.send';
    }

    protected function getOtpVerifyRouteName(): string
    {
        return $this->getRouteNamePrefix() . '.login.otp.verify';
    }

    protected function getOtpAuthenticateRouteName(): string
    {
        return $this->getRouteNamePrefix() . '.login.otp.authenticate';
    }

    protected function getOtpCacheKey(string $identifier, string $method): string
    {
        return sprintf('login_otp:%s:%s:%s', $this->getRouteNamePrefix(), Str::lower($identifier), $method);
    }

    protected function generateOtpCode(): string
    {
        return str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    protected function sendOtpEmail(object $user, string $code): void
    {
        Mail::to($user->email)->send(new LoginOtpMail($code, $this->getRouteNamePrefix()));
    }

    protected function sendOtpSms(object $user, string $code): void
    {
        Log::info("[OTP] SMS login code for {$user->email} to {$user->mobile}: {$code}");
    }

    protected function authenticateOtpUser(object $user, Request $request): RedirectResponse
    {
        Auth::guard($this->getAuthGuardName())->login($user);

        $request->session()->regenerate();

        return redirect()->intended($this->panelRedirector()->dashboardUrlForGuard($this->getAuthGuardName()));
    }

    protected function getAuthGuardName(): string
    {
        return property_exists($this, 'guard') ? $this->guard : 'web';
    }

    abstract protected function getRouteNamePrefix(): string;
    abstract protected function getAuthViewPrefix(): string;
    abstract protected function findUserByEmail(string $email): ?object;
    abstract protected function throttleKey(Request $request): string;
}
