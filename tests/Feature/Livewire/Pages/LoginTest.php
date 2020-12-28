<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Pages;

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/login';

    /**
     * @test
     */
    function page_contains_livewire_component()
    {
        $this->get(self::BASE_URL)->assertSeeLivewire(Login::getName());
    }

    /**
     * Отображает форму для ввода регистрационных данных
     */
    public function test_form()
    {
        $response = $this->get(self::BASE_URL);

        $response->assertSee('Email');
        $response->assertSee('Пароль');
    }

    /**
     * Попытка авторизации с пустыми данными
     */
    public function test_validation_empty()
    {
        Livewire::test(Login::class)
            ->call('submit')
            ->assertHasErrors([
                'email',
                'password',
            ]);
    }

    /**
     * Попытка авторизации с некорректным email
     */
    public function test_validation_not_valid_email()
    {
        Livewire::test(Login::class)
            ->set('email', 'test')
            ->call('submit')
            ->assertHasErrors([
                'email' => 'email',
            ]);
    }

    /**
     * Попытка авторизации несуществующим пользователем
     */
    public function test_not_existed_user()
    {
        Livewire::test(Login::class)
            ->set('email', 'test@test.ru')
            ->set('email', 'password')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    /**
     * Попытка авторизации несуществующим пользователем
     */
    public function test_wrong_password()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password123')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    /**
     * Успешная авторизация
     */
    public function test_success()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect('/');
    }
}
