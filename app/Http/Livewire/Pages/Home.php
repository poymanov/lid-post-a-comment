<?php

namespace App\Http\Livewire\Pages;

use App\Models\Topic;
use Livewire\Component;

class Home extends Component
{
    private const TOPICS_LIMIT = 3;

    public function render()
    {
        $topics = Topic::withCount('comments')
            ->orderBy('comments_count', 'desc')->limit(self::TOPICS_LIMIT)->get();

        return view('livewire.pages.home', compact('topics'));
    }
}
