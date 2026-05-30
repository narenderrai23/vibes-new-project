<?php

namespace Modules\Course\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Builders\UserBuilder;
use Tests\TestCase;

class CourseBackendTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserBuilder::make()->asAdmin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_course_index(): void
    {
        $response = $this->get('/admin/courses');

        $response->assertStatus(200);
        $response->assertSee('Courses');
    }

    public function test_admin_can_create_course(): void
    {
        $data = [
            'name' => 'Test Course',
            'description' => 'Test description',
            'status' => 1,
        ];

        $response = $this->post('/admin/courses', $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('courses', ['name' => 'Test Course']);
    }

    public function test_admin_can_view_course(): void
    {
        $course = \Modules\Course\Models\Course::factory()->create();

        $response = $this->get("/admin/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertSee($course->name);
    }

    public function test_admin_can_edit_course(): void
    {
        $course = \Modules\Course\Models\Course::factory()->create();

        $response = $this->get("/admin/courses/{$course->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($course->name);
    }

    public function test_admin_can_update_course(): void
    {
        $course = \Modules\Course\Models\Course::factory()->create();

        $data = [
            'name' => 'Updated Course',
            'description' => 'Updated description',
            'status' => 1,
        ];

        $response = $this->put("/admin/courses/{$course->id}", $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('courses', ['name' => 'Updated Course']);
    }

    public function test_admin_can_delete_course(): void
    {
        $course = \Modules\Course\Models\Course::factory()->create();

        $response = $this->delete("/admin/courses/{$course->id}");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('courses', ['id' => $course->id]);
    }

    public function test_admin_can_restore_course(): void
    {
        $course = \Modules\Course\Models\Course::factory()->create();
        $course->delete();

        $response = $this->patch("/admin/courses/{$course->id}/restore");

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'deleted_at' => null,
        ]);
    }
}
