<div>
    <h2 class="text-xl font-bold leading-tight text-gray-900 mb-2">
        {{ __('comment.list.header') }} ({{ $comments->total() }})
    </h2>
    @foreach($comments as $comment)
        <article class="border mb-3 border-gray-400 rounded-lg md:p-4 bg-white sm:py-3 py-4 px-2" data-article-path="/hagnerd/setting-up-tailwind-with-create-react-app-4jd" data-content-user-id="112962">
            <div role="presentation">
                <div>
                    <div class="flex items-center mb-2">
                        <div>
                            <p class="text text-gray-700 text-sm hover:text-black">{{ $comment->user->name }}</p>
                            <time datetime="{{ $comment->created_at->toISOString() }}" class="text-xs text-gray-600 hover:text-black">{{ $comment->created_at->diffForHumans() }}</time>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 leading-6">{{ $comment->content }}</div>
                        @if($comment->image)
                            <img src="{{$comment->imagePath}}" width="200" alt="" class="mb-2" />
                        @endif
                    </div>
                </div>
            </div>
            @auth
                @if($comment->user->id == auth()->id())
                    @livewire('comment.delete', compact('comment'))
                @endif
            @endauth
        </article>
    @endforeach

    {{ $comments->links('layouts.pagination') }}
</div>
