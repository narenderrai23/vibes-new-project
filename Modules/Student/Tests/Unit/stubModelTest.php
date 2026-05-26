<?php

namespace Modules\Student\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Student\Models\Student;

class StudentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_has_correct_table_name(): void
    {
        $student = new Student();

        $this->assertEquals('students', $student->getTable());
    }

    public function test_student_has_correct_casts(): void
    {
        $student = new Student();
        $casts = $student->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
    }

    public function test_student_uses_soft_deletes(): void
    {
        $student = Student::factory()->create();
        $student->delete();

        $this->assertSoftDeleted('students', ['id' => $student->id]);
    }

    public function test_student_factory_creates_valid_data(): void
    {
        $student = Student::factory()->create();

        $this->assertNotEmpty($student->name);
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $student->name,
        ]);
    }
}
