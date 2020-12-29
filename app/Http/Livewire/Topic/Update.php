<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Update extends Component
{
    use AuthorizesRequests;

    public $title;
    public $topic;

    public function mount(Topic $topic)
    {
        $this->topic = $topic;
        $this->title = $topic->title;
    }

    protected $rules = [
        'title' => 'required|string|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $this->topic->title = $this->title;

        if ($this->topic->save()) {
            session()->flash('alert.success', __('topic.updated.successful'));
        } else {
            session()->flash('alert.error', __('topic.updated.failed'));
        }

        return redirect(route('topic.list'));
    }

    public function render()
    {
        $this->authorize('update', $this->topic);

        return view('livewire.topic.update');
    }
}
