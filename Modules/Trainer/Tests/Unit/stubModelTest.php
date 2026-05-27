<?php

namespace Modules\Trainer\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Trainer\Models\Trainer;

class TrainerModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_trainer_has_correct_table_name(): void
    {
        $trainer = new Trainer();

        $this->assertEquals('trainers', $trainer->getTable());
    }

    public function test_trainer_has_correct_casts(): void
    {
        $trainer = new Trainer();
        $casts = $trainer->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
    }

    public function test_trainer_uses_soft_deletes(): void
    {
        $trainer = Trainer::factory()->create();
        $trainer->delete();

        $this->assertSoftDeleted('trainers', ['id' => $trainer->id]);
    }

    public function test_trainer_factory_creates_valid_data(): void
    {
        $trainer = Trainer::factory()->create();

        $this->assertNotEmpty($trainer->name);
        $this->assertDatabaseHas('trainers', [
            'id' => $trainer->id,
            'name' => $trainer->name,
        ]);
    }
}
