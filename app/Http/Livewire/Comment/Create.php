<?php

declare(strict_types=1);

namespace App\Http\Livewire\Comment;

use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;

class Create extends Component
{
    public $topic;
    public $content;
    public $image;

    protected $rules = [
        'content' => 'required|string|min:50',
    ];

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function submit()
    {
        $this->authorize();

        $this->validate();

        $data = ['user_id' => auth()->id(), 'content' => $this->content];

        if ($this->image) {
            $imageName = $this->generateImageName();

            if (!$this->storeImage($imageName)) {
                session()->flash('alert.error', __('comment.image.store.failed'));
                return redirect(route('topic.view', $this->topic));
            }

            $data['image'] = $imageName;
        }

        if ($this->topic->comments()->create($data)) {
            session()->flash('alert.success', __('comment.added.successful'));
        } else {
            if (isset($data['image'])) {
                $this->removeImage($data['image']);
            }

            session()->flash('alert.error', __('comment.added.failed'));
        }

        return redirect(route('topic.view', $this->topic));
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function storeImage(string $name): bool
    {
        if (!$this->image) {
            return false;
        }

        $img = ImageManagerStatic::make($this->image)->encode('jpg');

        return Storage::disk('public')->put($name, $img);
    }

    /**
     * @param string $name
     */
    private function removeImage(string $name)
    {
        Storage::disk('public')->delete($name);
    }

    private function generateImageName(): string
    {
        return $name = Str::random() . '.jpg';
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
