<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Modules\Center\Models\CenterUser;
use Modules\Student\Models\Student;
use Modules\Trainer\Models\Trainer;
use Tests\TestCase;

class MultiAuthRedirectTest extends TestCase
{
    public function test_guests_are_redirected_to_the_matching_panel_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
        $this->get('/center/dashboard')->assertRedirect('/center/login');
        $this->get('/trainer/dashboard')->assertRedirect('/trainer/login');
        $this->get('/student/dashboard')->assertRedirect('/student/login');
    }

    public function test_authenticated_users_are_redirected_to_the_matching_panel_dashboard(): void
    {
        $this->actingAs((new User)->forceFill(['id' => 1]), 'web')
            ->get('/admin/login')
            ->assertRedirect('/admin/dashboard');

        $this->actingAs((new CenterUser)->forceFill(['id' => 1]), 'center')
            ->get('/center/login')
            ->assertRedirect('/center/dashboard');

        $this->actingAs((new Trainer)->forceFill(['id' => 1]), 'trainer')
            ->get('/trainer/login')
            ->assertRedirect('/trainer/dashboard');

        $this->actingAs((new Student)->forceFill(['id' => 1]), 'student')
            ->get('/student/login')
            ->assertRedirect('/student/dashboard');
    }

    public function test_panel_base_paths_redirect_to_their_dashboards(): void
    {
        $this->get('/admin')->assertRedirect('/admin/dashboard');
        $this->get('/center')->assertRedirect('/center/dashboard');
        $this->get('/trainer')->assertRedirect('/trainer/dashboard');
        $this->get('/student')->assertRedirect('/student/dashboard');
        $this->get('/login')->assertRedirect('/student/login');
    }
}
