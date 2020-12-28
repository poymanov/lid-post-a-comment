<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Topic\TopicList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/topics';

    /**
     * Страница отображает правильный компонент
     */
    function test_page_contains_livewire_component()
    {
        $this->get(self::BASE_URL)->assertSeeLivewire(TopicList::getName());
    }

    /**
     * Для гостя на странице не отображается кнопка создания темы
     */
    public function test_guest_page_contains_create_button()
    {
        $this->get(self::BASE_URL)->assertDontSee('Создать');
    }

    /**
     * Для авторизованного пользователя на странице отображается кнопка создания темы
     */
    public function test_auth_page_contains_create_button()
    {
        $this->signIn();
        $this->get(self::BASE_URL)->assertSee('Создать');
    }
}
