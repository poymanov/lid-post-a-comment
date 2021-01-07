<?php

declare(strict_types=1);

namespace App\Http\Livewire\Comment;

use App\Models\Topic;
use Livewire\Component;
use Livewire\WithPagination;

class CommentList extends Component
{
    use WithPagination;

    private const COMMENTS_PER_PAGE = 5;

    public Topic $topic;

    public function render()
    {
        $comments = $this->topic->comments()->latest()->paginate(self::COMMENTS_PER_PAGE);
        return view('livewire.comment.list', compact('comments'));
    }
}
