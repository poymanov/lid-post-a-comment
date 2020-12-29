<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run()
    {
        Topic::factory()->create(['user_id' => 1]);
        Topic::factory(10)->create();
    }
}
