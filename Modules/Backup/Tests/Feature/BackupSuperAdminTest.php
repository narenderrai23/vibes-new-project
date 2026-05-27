<?php

<<<<<<< HEAD
namespace Modules\Backup\Tests\Feature;
=======
namespace Nasirkhan\ModuleManager\Modules\Backup\Tests\Feature;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackupSuperAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->seed();

        // Get Super Admin
        $user = User::whereId(1)->first();

        $this->actingAs($user);
    }

    /**
     * Backups Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_backups_index(): void
    {
        $response = $this->get('/admin/backups');

        $response->assertStatus(200);
    }

    public function test_non_admin_user_cannot_view_backups_index(): void
    {
        $user = User::whereId(5)->first();
        $this->actingAs($user);

        $response = $this->get('/admin/backups');

        $response->assertStatus(403);
    }

    public function test_backups_index_has_correct_view_components(): void
    {
        $response = $this->get('/admin/backups');

        $response->assertStatus(200);
        $response->assertSee('Backup');
    }
}
