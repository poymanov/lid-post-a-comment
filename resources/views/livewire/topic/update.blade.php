<div>
    <h1 class="text-3xl font-bold leading-tight text-gray-900 mb-3">
        Редактирование - {{ $title }}
    </h1>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="col-span-3 sm:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            {{ __('topic.title') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input type="text" name="title" id="title" value="{{ $title }}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" wire:model="title" required>
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('app.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
