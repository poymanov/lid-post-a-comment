<div>
    <h1 class="text-3xl font-bold leading-tight text-gray-900 mb-3">
        {{ $topic->title }}
    </h1>
    @auth
        <div class="mt-5 md:mt-0 md:col-span-2">
            @livewire('comment.create', compact('topic'))
        </div>
    @endauth
</div>
