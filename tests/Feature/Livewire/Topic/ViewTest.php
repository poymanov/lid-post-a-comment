<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Topic;

use App\Http\Livewire\Comment\CommentList;
use App\Http\Livewire\Comment\Create;
use App\Http\Livewire\Topic\View;
use App\Models\Comment;
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
     * Страница отображает правильный компонент
     */
    function test_page_contains_comments_list_livewire_component()
    {
        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertSeeLivewire(CommentList::getName());
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

    /**
     * На странице отображается название темы
     */
    function test_page_contains_comments_header()
    {
        $topic = Topic::factory()->create();

        $this->get(self::BASE_URL . $topic->id)->assertSee('Комментарии');
    }

    /**
     * На странице отображатся комментарии к теме
     */
    function test_page_contains_comments()
    {
        $topic = Topic::factory()->create();
        $comment = Comment::factory()->create(['topic_id' => $topic->id]);

        $response = $this->get(self::BASE_URL . $topic->id);
        $response->assertSee($comment->content);
        $response->assertSee($comment->user->name);
    }

    /**
     * На странице отображатся комментарии только для определенной теме
     */
    function test_page_contains_particular_topic_comments()
    {
        $topic = Topic::factory()->create();
        $comment = Comment::factory()->create(['topic_id' => $topic->id]);

        $anotherTopicComment = Comment::factory()->create();

        $response = $this->get(self::BASE_URL . $topic->id);
        $response->assertSee($comment->content);
        $response->assertSee($comment->user->name);

        $response->assertDontSee($anotherTopicComment->content);
        $response->assertDontSee($anotherTopicComment->user->name);
    }

    /**
     * Отображение комментариев с учетом пагинации
     */
    public function test_with_pagination()
    {
        $topic = Topic::factory()->create();

        $commentsCount = 6;

        $comments = Comment::factory($commentsCount)->create(['topic_id' => $topic->id]);

        $response = $this->get(self::BASE_URL . $topic->id);

        $response->assertSee("Комментарии ($commentsCount)");

        $response->assertSee($comments[0]->content);
        $response->assertSee($comments[1]->content);
        $response->assertSee($comments[2]->content);
        $response->assertSee($comments[3]->content);
        $response->assertSee($comments[4]->content);
        $response->assertDontSee($comments[5]->content);
    }
}
