<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-gray-50 p-4 rounded-lg border">
    <div class="rounded-lg p-5 border bg-white">
        <p class="text-lg font-semibold text-gray-700">{{ __('profile.total_uploads') }}</p>
        <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_count) }}</p>
    </div>
    
    <div class="rounded-lg p-5 border bg-white">
        <p class="text-lg font-semibold text-gray-700">{{ __('profile.public_uploads') }}</p>
        <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($publicImagesCount) }}</p>
    </div>
    
    <div class="rounded-lg p-5 border bg-white">
        <p class="text-lg font-semibold text-gray-700">{{ __('profile.private_uploads') }}</p>
        <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($privateImagesCount) }}</p>
    </div>
    
    <div class="rounded-lg p-5 border bg-white"> {{-- Removed md:col-span-3 to make it a single column item --}}
        <p class="text-lg font-semibold text-gray-700">{{ __('profile.storage_used') }}</p>
        <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_sum_size / 1024 / 1024, 2) }} MB</p>
    </div>
</div>
