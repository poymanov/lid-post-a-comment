<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run()
    {
        Topic::factory()->has(Comment::factory()->count(10))->create(['user_id' => 1]);
        Topic::factory(10)->has(Comment::factory()->count(10))->create();
    }
}
