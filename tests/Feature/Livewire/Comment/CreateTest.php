<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Comment;

use App\Http\Livewire\Comment\Create;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Попытка добавления с пустыми данными
     */
    public function test_validation_empty()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class, ['topic' => $topic])
            ->call('submit')
            ->assertHasErrors([
                'content' => 'required',
            ]);
    }

    /**
     * Попытка добавления с коротким содержимым
     */
    public function test_validation_short_content()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class, ['topic' => $topic])
            ->set('content', 'test')
            ->call('submit')
            ->assertHasErrors([
                'content' => 'min',
            ]);
    }

    /**
     * Успешное создание
     */
    public function test_success()
    {
        $this->signIn();

        $content = $this->faker->sentence(50);

        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        Livewire::actingAs($user)
            ->test(Create::class, ['topic' => $topic])
            ->set('content', $content)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/topics/' . $topic->id);

        $this->assertDatabaseHas('comments', [
            'content' => $content
        ]);
    }
}
