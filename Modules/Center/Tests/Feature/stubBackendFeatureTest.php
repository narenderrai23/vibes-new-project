<?php

namespace Modules\Center\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class CenterBackendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserBuilder::make()->asAdmin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_center_index(): void
    {
        $response = $this->get('/admin/centers');

        $response->assertStatus(200);
        $response->assertSee('Centers');
    }

    public function test_admin_can_create_center(): void
    {
        $data = [
            'name' => 'Test Center',
            'description' => 'Test description',
            'status' => 1,
        ];

        $response = $this->post('/admin/centers', $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('centers', ['name' => 'Test Center']);
    }

    public function test_admin_can_view_center(): void
    {
        $center = \Modules\Center\Models\Center::factory()->create();

        $response = $this->get("/admin/centers/{$center->id}");

        $response->assertStatus(200);
        $response->assertSee($center->name);
    }

    public function test_admin_can_edit_center(): void
    {
        $center = \Modules\Center\Models\Center::factory()->create();

        $response = $this->get("/admin/centers/{$center->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($center->name);
    }

    public function test_admin_can_update_center(): void
    {
        $center = \Modules\Center\Models\Center::factory()->create();

        $data = [
            'name' => 'Updated Center',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $response = $this->put("/admin/centers/{$center->id}", $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('centers', ['name' => 'Updated Center']);
    }

    public function test_admin_can_delete_center(): void
    {
        $center = \Modules\Center\Models\Center::factory()->create();

        $response = $this->delete("/admin/centers/{$center->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('centers', ['id' => $center->id]);
    }

    public function test_admin_can_restore_center(): void
    {
        $center = \Modules\Center\Models\Center::factory()->create();
        $center->delete();

        $response = $this->patch("/admin/centers/{$center->id}/restore");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('centers', [
            'id' => $center->id,
            'deleted_at' => null,
        ]);
    }
}
