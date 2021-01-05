<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Topic\Update;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const BASE_URL = '/topics/';

    /**
     * Страница отображает правильный компонент
     */
    function test_page_contains_livewire_component()
    {
        $user = User::factory()->create();

        $this->signIn($user);
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        $this->get(self::BASE_URL . $topic->id . '/edit')->assertSeeLivewire(Update::getName());
    }

    /**
     * Гостям недоступна страница редактирования темы
     */
    public function test_guest()
    {
        $topic = Topic::factory()->create();
        $this->get(self::BASE_URL . $topic->id . '/edit')->assertRedirect('/login');
    }

    /**
     * Страница редактирования темы доступна только её автору
     */
    public function test_not_owner()
    {
        $topic = Topic::factory()->create();

        $this->signIn();
        $this->get(self::BASE_URL . $topic->id . '/edit')->assertForbidden();
    }

    /**
     * Страница редактирования несуществующей темы
     */
    public function test_not_existed()
    {
        $this->signIn();
        $this->get(self::BASE_URL . '999/edit')->assertNotFound();
    }

    /**
     * Отображает форму для ввода данных темы
     */
    public function test_form()
    {
        $user = User::factory()->create();

        $this->signIn($user);
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL . $topic->id . '/edit');

        $response->assertSee('Название');
        $response->assertSee($topic->title);
        $response->assertSee('Сохранить');
    }

    /**
     * Попытка редактирования с пустыми данными
     */
    public function test_validation_empty()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Update::class, ['topic' => $topic])
            ->set('title', null)
            ->call('submit')
            ->assertHasErrors([
                'title',
            ]);
    }

    /**
     * Попытка редактирования с длинным наименованием
     */
    public function test_validation_long_title()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Update::class, ['topic' => $topic])
            ->set('title', $this->faker->sentence(200))
            ->call('submit')
            ->assertHasErrors([
                'title',
            ]);
    }

    /**
     * Успешное редактирование
     */
    public function test_success()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(Update::class, ['topic' => $topic])
            ->set('title', 'test')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/topics');

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'test'
        ]);
    }
}
