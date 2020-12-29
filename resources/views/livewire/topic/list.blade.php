<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @auth
            <div class="p-6 bg-white border-b border-gray-200">
                <div>
                    <a href="{{ route('topic.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('app.create') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</div>

