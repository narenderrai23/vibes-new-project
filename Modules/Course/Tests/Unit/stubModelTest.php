<?php

namespace Modules\Course\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Course\Models\Course;

class CourseModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_has_correct_table_name(): void
    {
        $course = new Course();

        $this->assertEquals('courses', $course->getTable());
    }

    public function test_course_has_correct_casts(): void
    {
        $course = new Course();
        $casts = $course->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
    }

    public function test_course_uses_soft_deletes(): void
    {
        $course = Course::factory()->create();
        $course->delete();

        $this->assertSoftDeleted('courses', ['id' => $course->id]);
    }

    public function test_course_factory_creates_valid_data(): void
    {
        $course = Course::factory()->create();

        $this->assertNotEmpty($course->name);
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => $course->name,
        ]);
    }
}
