<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Topic\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const BASE_URL = '/topics/create';

    /**
     * Страница отображает правильный компонент
     */
    function test_page_contains_livewire_component()
    {
        $this->signIn();
        $this->get(self::BASE_URL)->assertSeeLivewire(Create::getName());
    }

    /**
     * Гостям недоступна страница создания темы
     */
    public function test_guest()
    {
        $this->get(self::BASE_URL)->assertRedirect('/login');
    }

    /**
     * Авторизованным пользователям доступна страница создания темы
     */
    public function test_auth()
    {
        $this->signIn();
        $this->get(self::BASE_URL)->assertSuccessful();
    }

    /**
     * Отображает форму для ввода данных темы
     */
    public function test_form()
    {
        $this->signIn();

        $response = $this->get(self::BASE_URL);

        $response->assertSee('Название');
        $response->assertSee('Создать');
    }

    /**
     * Попытка создания с пустыми данными
     */
    public function test_validation_empty()
    {
        Livewire::test(Create::class)
            ->call('submit')
            ->assertHasErrors([
                'title',
            ]);
    }

    /**
     * Попытка создания с длинным наименованием
     */
    public function test_validation_long_title()
    {
        Livewire::test(Create::class)
            ->set('title', $this->faker->sentence(200))
            ->call('submit')
            ->assertHasErrors([
                'title',
            ]);
    }

    /**
     * Успешное создание
     */
    public function test_success()
    {
        $this->signIn();

        Livewire::test(Create::class)
            ->set('title', 'test')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/topics');

        $this->assertDatabaseHas('topics', [
            'title' => 'test'
        ]);
    }
}
