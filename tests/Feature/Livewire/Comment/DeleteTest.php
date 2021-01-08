<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Comment;

use App\Http\Livewire\Comment\Delete;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Попытка удаления комментария другого пользователя
     */
    public function test_not_owner()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Livewire::actingAs($user)
            ->test(Delete::class, ['comment' => $comment])
            ->assertForbidden();
    }

    /**
     * Успешное удаление
     */
    public function test_success()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Delete::class, ['comment' => $comment])
            ->call('delete')
            ->assertHasNoErrors()
            ->assertRedirect('/topics/' . $comment->topic->id);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }
}
