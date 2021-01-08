<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    public $topic;

    public function mount(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function delete()
    {
        $this->authorize('delete', $this->topic);

        DB::beginTransaction();

        if (($this->topic->comments()->exists() && !$this->topic->comments()->delete())) {
            session()->flash('alert.error', __('topic.deleted.failed'));
            DB::rollback();
        }

        if (!$this->topic->delete()) {
            session()->flash('alert.error', __('topic.deleted.failed'));
            DB::rollback();
        }

        session()->flash('alert.success', __('topic.deleted.successful'));
        DB::commit();

        return redirect(route('topic.list'));
    }

    public function render()
    {
        $this->authorize('delete', $this->topic);

        return view('livewire.topic.delete');
    }
}
