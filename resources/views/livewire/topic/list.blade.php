<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @auth
            <div class="py-6 bg-white border-b border-gray-200">
                <div>
                    <a href="{{ route('topic.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('app.create') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>

    <div class="mb-3">
        @foreach($topics as $topic)
            <div class="lg:flex lg:items-center lg:justify-between mb-4 mt-4">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        <a href="{{ route('topic.view', $topic->id) }}">{{ $topic->title }}</a>
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $topic->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    @can('update', $topic)
                        <a href="{{ route('topic.edit', $topic) }}">
                            <span class="hidden sm:block">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>{{ __('topic.edit') }}
                                </button>
                            </span>
                        </a>
                    @endcan
                    @can('delete', $topic)
                        @livewire('topic.delete', compact('topic'))
                    @endcan
                </div>
            </div>
            <hr/>
        @endforeach
    </div>

    {{ $topics->links('layouts.pagination') }}
</div>

