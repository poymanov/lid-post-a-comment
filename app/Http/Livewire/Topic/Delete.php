<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
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

        if ($this->topic->delete()) {
            session()->flash('alert.success', __('topic.deleted.successful'));
        } else {
            session()->flash('alert.error', __('topic.deleted.failed'));
        }

        return redirect(route('topic.list'));
    }

    public function render()
    {
        $this->authorize('delete', $this->topic);

        return view('livewire.topic.delete');
    }
}
