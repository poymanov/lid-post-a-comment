<?php

declare(strict_types=1);

namespace App\Http\Livewire\Comment;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    public $comment;

    public function delete()
    {
        $this->authorize('delete', $this->comment);

        if ($this->comment->delete()) {
            session()->flash('alert.success', __('comment.deleted.successful'));
        } else {
            session()->flash('alert.error', __('comment.deleted.failed'));
        }

        return redirect(route('topic.view', $this->comment->topic));
    }

    public function render()
    {
        $this->authorize('delete', $this->comment);

        return view('livewire.comment.delete');
    }
}
