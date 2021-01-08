<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Pages;

use App\Http\Livewire\Pages\Home;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Страница отображает правильный компонент
     */
    function test_page_contains_livewire_component()
    {
        $this->get('/')->assertSeeLivewire(Home::getName());
    }

    /**
     * На странице отображаются наиболее обсуждаемые темы
     */
    public function test_page_contains_most_commented_topic()
    {
        $topicFirst = Topic::factory()->has(Comment::factory(20))->create();
        $topicSecond = Topic::factory()->has(Comment::factory(15))->create();
        $topicThird = Topic::factory()->has(Comment::factory(10))->create();
        $topicFourth = Topic::factory()->has(Comment::factory(5))->create();

        $response = $this->get('/');
        $response->assertSee($topicFirst->title);
        $response->assertSee($topicSecond->title);
        $response->assertSee($topicThird->title);
        $response->assertDontSee($topicFourth->title);
    }
}
