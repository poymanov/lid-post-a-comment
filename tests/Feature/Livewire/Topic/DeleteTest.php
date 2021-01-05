<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Topic\Delete;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Попытка удаления темы другого пользователя
     */
    public function test_not_owner()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        Livewire::actingAs($user)
            ->test(Delete::class, ['topic' => $topic])
            ->assertForbidden();
    }

    /**
     * Успешное удаление
     */
    public function test_success()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Delete::class, ['topic' => $topic])
            ->call('delete')
            ->assertHasNoErrors()
            ->assertRedirect('/topics');

        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
        ]);
    }
}
