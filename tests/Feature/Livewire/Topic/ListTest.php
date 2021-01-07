<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Topic\TopicList;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
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

    /**
     * На странице выводятся темы
     */
    public function test_page_contains_topics()
    {
        $topicOne = Topic::factory()->create();
        $topicSecond = Topic::factory()->create();

        $response = $this->get(self::BASE_URL);
        $response->assertSee($topicOne->title);
        $response->assertSee($topicSecond->title);
    }

    /**
     * Для гостей не выводится кнопка редактирования темы
     */
    public function test_guest_page_not_contains_edit_button()
    {
        Topic::factory()->create();

        $response = $this->get(self::BASE_URL);
        $response->assertDontSee('Редактировать');
    }

    /**
     * Пользователи не видят кнопки редактирования тем других пользователей
     */
    public function test_page_not_contains_edit_button_for_other_users()
    {
        $this->signIn();
        Topic::factory()->create();

        $response = $this->get(self::BASE_URL);
        $response->assertDontSee('Редактировать');
    }

    /**
     * Пользователи видят кнопки редактирования собственных тем
     */
    public function test_page_not_contains_edit_button_for_owner()
    {
        $user = User::factory()->create();

        $this->signIn($user);
        Topic::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL);
        $response->assertSee('Редактировать');
    }

    /**
     * Для гостей не выводится кнопка удаления темы
     */
    public function test_guest_page_not_contains_delete_button()
    {
        Topic::factory()->create();

        $response = $this->get(self::BASE_URL);
        $response->assertDontSee('Удалить');
    }

    /**
     * Пользователи не видят кнопки удаления тем других пользователей
     */
    public function test_page_not_contains_delete_button_for_other_users()
    {
        $this->signIn();
        Topic::factory()->create();

        $response = $this->get(self::BASE_URL);
        $response->assertDontSee('Удалить');
    }

    /**
     * Пользователи видят кнопки редактирования собственных тем
     */
    public function test_page_not_contains_delete_button_for_owner()
    {
        $user = User::factory()->create();

        $this->signIn($user);
        Topic::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL);
        $response->assertSee('Удалить');
    }

    /**
     * Отображение тем с учетом пагинации
     */
    public function test_with_pagination()
    {
        $topics = Topic::factory(6)->create();

        $response = $this->get(self::BASE_URL);
        $response->assertSee($topics[0]->title);
        $response->assertSee($topics[1]->title);
        $response->assertSee($topics[2]->title);
        $response->assertSee($topics[3]->title);
        $response->assertSee($topics[4]->title);
        $response->assertDontSee($topics[5]->title);
    }

    /**
     * У темы отображается количество комментариев
     */
    public function test_contains_comments_count()
    {
        $commentsCount = 15;

        $topic = Topic::factory()->has(Comment::factory($commentsCount))->create([
            'title' => 'test'
        ]);

        $this->get(self::BASE_URL)->assertSee($commentsCount);
    }
}
