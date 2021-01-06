<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Comment\Create;
use App\Http\Livewire\Topic\View;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const BASE_URL = '/topics/';

    /**
     * Страница отображает правильный компонент
     */
    function test_page_contains_livewire_component()
    {
        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertSeeLivewire(View::getName());
    }

    /**
     * Для неавторизованных пользователей на странице не отображается компонент добавления комментариев
     */
    function test_page_guest_not_contains_create_comment_livewire_component()
    {
        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertDontSeeLivewire(Create::getName());
    }

    /**
     * Для авторизованных пользователей на странице отображается компонент добавления комментариев
     */
    function test_page_auth_contains_create_comment_livewire_component()
    {
        $this->signIn();

        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertSeeLivewire(Create::getName());
    }

    /**
     * На странице отображается название темы
     */
    function test_page_contains_title()
    {
        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertSee($topic->title);
    }

    /**
     * На странице отображается форма добавления комментария
     */
    function test_create_comment_form()
    {
        $this->signIn();

        $topic = Topic::factory()->create();

        $response = $this->get(self::BASE_URL . $topic->id);

        $response->assertSee('Комментарий');
        $response->assertSee('Добавить');
    }
}
