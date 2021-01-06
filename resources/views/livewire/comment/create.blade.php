<div>
    <form wire:submit.prevent="submit">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <div class="col-span-3 sm:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">
                        {{ __('comment.content') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <textarea name="content" id="content" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" wire:model="content" required></textarea>
                        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('app.add') }}
                </button>
            </div>
        </div>
    </form>
</div>
