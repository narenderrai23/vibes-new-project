<?php

namespace Modules\Auth\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Auth\Models\Auth;

class AuthModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_has_correct_table_name(): void
    {
        $auth = new Auth();

        $this->assertEquals('auths', $auth->getTable());
    }

    public function test_auth_has_correct_casts(): void
    {
        $auth = new Auth();
        $casts = $auth->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
    }

    public function test_auth_uses_soft_deletes(): void
    {
        $auth = Auth::factory()->create();
        $auth->delete();

        $this->assertSoftDeleted('auths', ['id' => $auth->id]);
    }

    public function test_auth_factory_creates_valid_data(): void
    {
        $auth = Auth::factory()->create();

        $this->assertNotEmpty($auth->name);
        $this->assertDatabaseHas('auths', [
            'id' => $auth->id,
            'name' => $auth->name,
        ]);
    }
}
