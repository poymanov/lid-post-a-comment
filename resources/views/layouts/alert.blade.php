@if(session('alert.success'))
    <div class="bg-green-500">
        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <p class="font-medium text-white truncate">
                        <span class="md:inline">{{ session('alert.success') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@elseif(session('alert.error'))
    <div class="bg-red-500">
        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <p class="font-medium text-white truncate">
                        <span class="md:inline">{{ session('alert.error') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
