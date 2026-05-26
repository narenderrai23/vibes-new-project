<?php

namespace Modules\Auth\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class AuthBackendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserBuilder::make()->asAdmin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_auth_index(): void
    {
        $response = $this->get('/admin/auths');

        $response->assertStatus(200);
        $response->assertSee('Auths');
    }

    public function test_admin_can_create_auth(): void
    {
        $data = [
            'name' => 'Test Auth',
            'description' => 'Test description',
            'status' => 1,
        ];

        $response = $this->post('/admin/auths', $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('auths', ['name' => 'Test Auth']);
    }

    public function test_admin_can_view_auth(): void
    {
        $auth = \Modules\Auth\Models\Auth::factory()->create();

        $response = $this->get("/admin/auths/{$auth->id}");

        $response->assertStatus(200);
        $response->assertSee($auth->name);
    }

    public function test_admin_can_edit_auth(): void
    {
        $auth = \Modules\Auth\Models\Auth::factory()->create();

        $response = $this->get("/admin/auths/{$auth->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($auth->name);
    }

    public function test_admin_can_update_auth(): void
    {
        $auth = \Modules\Auth\Models\Auth::factory()->create();

        $data = [
            'name' => 'Updated Auth',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $response = $this->put("/admin/auths/{$auth->id}", $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('auths', ['name' => 'Updated Auth']);
    }

    public function test_admin_can_delete_auth(): void
    {
        $auth = \Modules\Auth\Models\Auth::factory()->create();

        $response = $this->delete("/admin/auths/{$auth->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('auths', ['id' => $auth->id]);
    }

    public function test_admin_can_restore_auth(): void
    {
        $auth = \Modules\Auth\Models\Auth::factory()->create();
        $auth->delete();

        $response = $this->patch("/admin/auths/{$auth->id}/restore");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('auths', [
            'id' => $auth->id,
            'deleted_at' => null,
        ]);
    }
}
