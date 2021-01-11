<?php

declare(strict_types=1);

namespace App\Http\Livewire\Comment;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    public $comment;

    public function delete()
    {
        $this->authorize('delete', $this->comment);

        DB::beginTransaction();

        if ($this->comment->delete()) {
            session()->flash('alert.success', __('comment.deleted.successful'));

            if ($this->comment->image && !$this->removeImage($this->comment->image)) {
                session()->flash('alert.error', __('comment.image.failed'));
                DB::rollBack();
            }
        } else {
            session()->flash('alert.error', __('comment.deleted.failed'));

            DB::rollBack();
        }

        DB::commit();

        return redirect(route('topic.view', $this->comment->topic));
    }

    /**
     * @param string $name
     */
    private function removeImage(string $name)
    {
        return Storage::disk('public')->delete($name);
    }

    public function render()
    {
        $this->authorize('delete', $this->comment);

        return view('livewire.comment.delete');
    }
}
