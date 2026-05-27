<?php

namespace Modules\Trainer\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class TrainerBackendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserBuilder::make()->asAdmin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_trainer_index(): void
    {
        $response = $this->get('/admin/trainers');

        $response->assertStatus(200);
        $response->assertSee('Trainers');
    }

    public function test_admin_can_create_trainer(): void
    {
        $data = [
            'name' => 'Test Trainer',
            'description' => 'Test description',
            'status' => 1,
        ];

        $response = $this->post('/admin/trainers', $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('trainers', ['name' => 'Test Trainer']);
    }

    public function test_admin_can_view_trainer(): void
    {
        $trainer = \Modules\Trainer\Models\Trainer::factory()->create();

        $response = $this->get("/admin/trainers/{$trainer->id}");

        $response->assertStatus(200);
        $response->assertSee($trainer->name);
    }

    public function test_admin_can_edit_trainer(): void
    {
        $trainer = \Modules\Trainer\Models\Trainer::factory()->create();

        $response = $this->get("/admin/trainers/{$trainer->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($trainer->name);
    }

    public function test_admin_can_update_trainer(): void
    {
        $trainer = \Modules\Trainer\Models\Trainer::factory()->create();

        $data = [
            'name' => 'Updated Trainer',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $response = $this->put("/admin/trainers/{$trainer->id}", $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('trainers', ['name' => 'Updated Trainer']);
    }

    public function test_admin_can_delete_trainer(): void
    {
        $trainer = \Modules\Trainer\Models\Trainer::factory()->create();

        $response = $this->delete("/admin/trainers/{$trainer->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('trainers', ['id' => $trainer->id]);
    }

    public function test_admin_can_restore_trainer(): void
    {
        $trainer = \Modules\Trainer\Models\Trainer::factory()->create();
        $trainer->delete();

        $response = $this->patch("/admin/trainers/{$trainer->id}/restore");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('trainers', [
            'id' => $trainer->id,
            'deleted_at' => null,
        ]);
    }
}
