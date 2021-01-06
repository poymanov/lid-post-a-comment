<?php

declare(strict_types=1);

namespace App\Http\Livewire\Topic;

use App\Models\Topic;
use Livewire\Component;

class View extends Component
{
    public $topic;

    public function mount(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function render()
    {
        return view('livewire.topic.view');
    }
}
