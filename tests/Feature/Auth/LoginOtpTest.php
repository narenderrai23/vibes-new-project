<?php

namespace Tests\Feature\Auth;

use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LoginOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_request_email_otp_and_authenticate(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'otp@example.com',
            'mobile' => '9000000001',
            'status' => 1,
        ]);

        $response = $this->post(route('admin.login.otp.send'), [
            'email' => $user->email,
            'method' => 'email',
        ]);

        $response->assertRedirect(route('admin.login.otp.verify'));

        Mail::assertSent(LoginOtpMail::class, function (LoginOtpMail $mail) use ($user) {
            return $mail->hasTo($user->email) && ! empty($mail->code);
        });

        $cacheKey = 'login_otp:admin:' . strtolower($user->email) . ':email';
        $code = Cache::get($cacheKey);

        $this->assertNotNull($code);

        $this->post(route('admin.login.otp.authenticate'), [
            'email' => $user->email,
            'method' => 'email',
            'otp_code' => $code,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_request_sms_otp_and_authenticate(): void
    {
        Log::spy();

        $user = User::factory()->create([
            'email' => 'otp-sms@example.com',
            'mobile' => '9000000002',
            'status' => 1,
        ]);

        $response = $this->post(route('admin.login.otp.send'), [
            'email' => $user->email,
            'method' => 'sms',
        ]);

        $response->assertRedirect(route('admin.login.otp.verify'));

        $cacheKey = 'login_otp:admin:' . strtolower($user->email) . ':sms';
        $code = Cache::get($cacheKey);

        $this->assertNotNull($code);
        Log::shouldHaveReceived('info')->once();

        $this->post(route('admin.login.otp.authenticate'), [
            'email' => $user->email,
            'method' => 'sms',
            'otp_code' => $code,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }
}
