<?php

namespace Modules\Student\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class StudentBackendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserBuilder::make()->asAdmin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_student_index(): void
    {
        $response = $this->get('/admin/students');

        $response->assertStatus(200);
        $response->assertSee('Students');
    }

    public function test_admin_can_create_student(): void
    {
        $data = [
            'name' => 'Test Student',
            'description' => 'Test description',
            'status' => 1,
        ];

        $response = $this->post('/admin/students', $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('students', ['name' => 'Test Student']);
    }

    public function test_admin_can_view_student(): void
    {
        $student = \Modules\Student\Models\Student::factory()->create();

        $response = $this->get("/admin/students/{$student->id}");

        $response->assertStatus(200);
        $response->assertSee($student->name);
    }

    public function test_admin_can_edit_student(): void
    {
        $student = \Modules\Student\Models\Student::factory()->create();

        $response = $this->get("/admin/students/{$student->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($student->name);
    }

    public function test_admin_can_update_student(): void
    {
        $student = \Modules\Student\Models\Student::factory()->create();

        $data = [
            'name' => 'Updated Student',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $response = $this->put("/admin/students/{$student->id}", $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('students', ['name' => 'Updated Student']);
    }

    public function test_admin_can_delete_student(): void
    {
        $student = \Modules\Student\Models\Student::factory()->create();

        $response = $this->delete("/admin/students/{$student->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('students', ['id' => $student->id]);
    }

    public function test_admin_can_restore_student(): void
    {
        $student = \Modules\Student\Models\Student::factory()->create();
        $student->delete();

        $response = $this->patch("/admin/students/{$student->id}/restore");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'deleted_at' => null,
        ]);
    }
}
