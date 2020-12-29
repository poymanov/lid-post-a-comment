<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class TopicList extends Component
{
    use WithPagination;

    private const TOPICS_PER_PAGE = 5;

    public function render()
    {
        $topics = Topic::latest()->paginate(self::TOPICS_PER_PAGE);
        return view('livewire.topic.list', compact('topics'));
    }
}
