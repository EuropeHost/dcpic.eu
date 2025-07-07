@extends('layouts.main')

@section('main')
    <div class="text-center py-12 px-4 home">
        <h1 class="text-5xl font-extrabold text-gray-800 leading-tight">
            {{ __('content.home_title') }}
        </h1>
        <p class="text-xl mt-4 text-gray-600 max-w-2xl mx-auto">
            {{ __('content.home_subtitle') }}
        </p>

        @guest
            <a href="{{ route('login') }}" class="discord-login-btn mt-8 inline-flex items-center justify-center">
                <i class="bi bi-discord mr-2"></i> {{ __('content.login_with_discord') }}
            </a>
        @endguest

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-white border shadow-lg rounded-xl p-8 flex flex-col justify-between transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.storage_overview') }}</h2>
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                        <div class="bg-sky-600 h-4 rounded-full transition-all" style="width: {{ $storagePercentage }}%"></div>
                    </div>
                    <p class="text-lg text-gray-700 font-semibold mb-1">
                        <span class="animated-count" data-start="0" data-end="{{ number_format($totalUsed / 1048576, 2, '.', '') }}" data-decimals="2"></span> MB /
                        <span class="animated-count" data-start="0" data-end="{{ number_format($totalLimit / 1073741824, 2, '.', '') }}" data-decimals="2"></span> GiB
                    </p>
                    <p class="text-md text-gray-600">
                        (<span class="animated-count" data-start="0" data-end="{{ number_format($storagePercentage, 1, '.', '') }}" data-decimals="1"></span>% {{ __('content.used') }})
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-md text-gray-700">
                        <strong>{{ __('content.average_per_user') }}:</strong>
                        <span class="animated-count" data-start="0" data-end="{{ number_format($avgPerUser / 1048576, 2, '.', '') }}" data-decimals="2"></span> MB
                    </p>
                </div>
            </div>

            <div class="bg-white border shadow-lg rounded-xl p-8 flex flex-col justify-between transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.general_stats') }}</h2>
                    <p class="text-lg text-gray-700 mb-2">
                        <i class="bi bi-person-fill text-sky-600 mr-2"></i><strong>{{ __('content.total_users') }}:</strong>
                        <span class="animated-count" data-start="0" data-end="{{ number_format($totalUsers, 0, '.', '') }}" data-decimals="0"></span>
                    </p>
                    <p class="text-lg text-gray-700">
                        <i class="bi bi-image-fill text-sky-600 mr-2"></i><strong>{{ __('content.total_images_uploaded') }}:</strong>
                        <span class="animated-count" data-start="0" data-end="{{ number_format($totalImages, 0, '.', '') }}" data-decimals="0"></span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 italic">{{ __('content.stats_update_info') }}</p>
                </div>
            </div>

            <div class="bg-white border shadow-lg rounded-xl p-8 transform transition duration-300 hover:scale-105 hover:shadow-xl col-span-1 md:col-span-2 lg:col-span-1">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.top_storage_users') }}</h2>
                @if ($topStorageUsers->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($topStorageUsers as $index => $user)
                            <li class="flex items-center space-x-3 bg-gray-50 p-2 rounded-lg transform transition duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm cursor-pointer">
                                <div class="w-8 h-8 flex items-center justify-center text-lg font-bold text-sky-600 bg-sky-100 rounded-full flex-shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-sky-400">
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        <span class="animated-count" data-start="0" data-end="{{ number_format(floatval(str_replace(',', '', $user->storage_used_mb)), 2, '.', '') }}" data-decimals="2"></span> MB
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">{{ __('content.no_top_storage_users') }}</p>
                @endif
            </div>
        </div>

        <div class="mt-12 bg-white border shadow-lg rounded-xl p-8 max-w-6xl mx-auto transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.top_image_users') }}</h2>
            @if ($topImageUsers->isNotEmpty())
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($topImageUsers as $index => $user)
                        <li class="flex items-center space-x-3 bg-gray-50 p-2 rounded-lg transform transition duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm cursor-pointer">
                            <div class="w-8 h-8 flex items-center justify-center text-lg font-bold text-sky-600 bg-sky-100 rounded-full flex-shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-sky-400">
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">
                                    <span class="animated-count" data-start="0" data-end="{{ number_format($user->image_count, 0, '.', '') }}" data-decimals="0"></span> {{ __('content.images') }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">{{ __('content.no_top_image_users') }}</p>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // This function animates a number from start to end over a duration
            function animateCount(element, duration = 5000) {
                const start = parseFloat(element.dataset.start);
                const end = parseFloat(element.dataset.end);
                const decimals = parseInt(element.dataset.decimals);

                let startTime = null;
                const updateCount = (currentTime) => {
                    if (!startTime) startTime = currentTime;
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    const value = start + (end - start) * progress;

                    element.textContent = value.toFixed(decimals);

                    if (progress < 1) {
                        requestAnimationFrame(updateCount);
                    }
                };
                requestAnimationFrame(updateCount);
            };

            window.addEventListener('load', () => {
                // Find elements with 'animated-count' class
                document.querySelectorAll('.animated-count').forEach(element => {
                    // animation for each element
                    animateCount(element);
                });
            });
        </script>
    @endpush
@endsection
