<?php

declare(strict_types=1);

namespace App\Http\Livewire\Comment;

use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $topic;
    public $content;

    protected $rules = [
        'content' => 'required|string|min:50',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->authorize();

        $this->validate();

        $data = ['user_id' => auth()->id(), 'content' => $this->content];

        if ($this->topic->comments()->create($data)) {
            session()->flash('alert.success', __('comment.added.successful'));
        } else {
            session()->flash('alert.error', __('comment.added.failed'));
        }

        return redirect(route('topic.view', $this->topic));

    }

    public function mount(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function render()
    {
        $this->authorize();

        return view('livewire.comment.create');
    }

    private function authorize()
    {
        abort_if(Auth::guest(), 403);
    }
}
