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
            {{-- Global Storage Overview Card --}}
            <div class="bg-white border shadow-lg rounded-xl p-8 flex flex-col justify-between transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.storage_overview') }}</h2>
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                        <div class="bg-sky-600 h-4 rounded-full transition-all" style="width: {{ $storagePercentage }}%"></div>
                    </div>
                    <p class="text-lg text-gray-700 font-semibold mb-1">
                        {{ number_format($totalUsed / 1048576, 2) }} MB /
                        {{ number_format($totalLimit / 1073741824, 2) }} GiB
                    </p>
                    <p class="text-md text-gray-600">({{ number_format($storagePercentage, 1) }}% {{ __('content.used') }})</p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-md text-gray-700">
                        <strong>{{ __('content.average_per_user') }}:</strong>
                        {{ number_format($avgPerUser / 1048576, 2) }} MB
                    </p>
                </div>
            </div>

            {{-- General Statistics Card --}}
            <div class="bg-white border shadow-lg rounded-xl p-8 flex flex-col justify-between transform transition duration-300 hover:scale-105 hover:shadow-xl">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.general_stats') }}</h2>
                    <p class="text-lg text-gray-700 mb-2">
                        <i class="bi bi-person-fill text-sky-600 mr-2"></i><strong>{{ __('content.total_users') }}:</strong> {{ number_format($totalUsers) }}
                    </p>
                    <p class="text-lg text-gray-700">
                        <i class="bi bi-image-fill text-sky-600 mr-2"></i><strong>{{ __('content.total_images_uploaded') }}:</strong> {{ number_format($totalImages) }}
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500 italic">{{ __('content.stats_update_info') }}</p>
                </div>
            </div>

            {{-- Top Users by Storage --}}
            <div class="bg-white border shadow-lg rounded-xl p-8 transform transition duration-300 hover:scale-105 hover:shadow-xl col-span-1 md:col-span-2 lg:col-span-1">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.top_storage_users') }}</h2>
                @if ($topStorageUsers->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach ($topStorageUsers as $user)
                            <li class="flex items-center space-x-3 bg-gray-50 p-2 rounded-lg">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-sky-400">
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->storage_used_mb }} MB</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">{{ __('content.no_top_storage_users') }}</p>
                @endif
            </div>
        </div>

        {{-- Top Users by Image Count - Separate Section --}}
        <div class="mt-12 bg-white border shadow-lg rounded-xl p-8 max-w-6xl mx-auto transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('content.top_image_users') }}</h2>
            @if ($topImageUsers->isNotEmpty())
                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($topImageUsers as $user)
                        <li class="flex items-center space-x-3 bg-gray-50 p-2 rounded-lg">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-sky-400">
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->image_count }} {{ __('content.images') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">{{ __('content.no_top_image_users') }}</p>
            @endif
        </div>
    </div>
@endsection
