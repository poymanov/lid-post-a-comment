<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;

class Create extends Component
{
    public $title;

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

        $topic = new Topic();
        $topic->title = $this->title;
        $topic->user_id = auth()->id();

        if ($topic->save()) {
            session()->flash('alert.success', __('topic.created.successful'));
        } else {
            session()->flash('alert.error', __('topic.created.failed'));
        }

        return redirect(route('topic.list'));
    }

    public function render()
    {
        return view('livewire.topic.create');
    }
}
