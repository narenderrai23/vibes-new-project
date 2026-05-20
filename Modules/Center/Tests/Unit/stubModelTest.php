<?php

namespace Modules\Center\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Center\Models\Center;

class CenterModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_center_has_correct_table_name(): void
    {
        $center = new Center();

        $this->assertEquals('centers', $center->getTable());
    }

    public function test_center_has_correct_casts(): void
    {
        $center = new Center();
        $casts = $center->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
    }

    public function test_center_uses_soft_deletes(): void
    {
        $center = Center::factory()->create();
        $center->delete();

        $this->assertSoftDeleted('centers', ['id' => $center->id]);
    }

    public function test_center_factory_creates_valid_data(): void
    {
        $center = Center::factory()->create();

        $this->assertNotEmpty($center->name);
        $this->assertDatabaseHas('centers', [
            'id' => $center->id,
            'name' => $center->name,
        ]);
    }
}
