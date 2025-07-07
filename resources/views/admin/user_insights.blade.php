@extends('layouts.main')

@section('main')
    <div class="bg-white shadow rounded-lg p-8 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('admin.user_details') }}</h1>

        <div class="flex items-center mb-6">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-4 border-sky-400 mr-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-md text-gray-600">{{ $user->email }}</p>
                <p class="text-md text-gray-600">Discord ID: {{ $user->discord_id }}</p>
                <p class="text-md text-gray-600 capitalize">Role: <span class="font-bold">{{ $user->role }}</span></p>
                <p class="text-md text-gray-600">{{ __('admin.account_created_on') }}: {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-5 border">
                <p class="text-lg font-semibold text-gray-700">{{ __('admin.images_uploaded') }}</p>
                <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_count) }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 border">
                <p class="text-lg font-semibold text-gray-700">{{ __('admin.storage_used') }}</p>
                <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_sum_size / 1024 / 1024, 2) }} MB</p>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('admin.user_images') }}</h3>
        @if($userImages->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($userImages as $image)
                    @php
                        $viewRoute = Str::startsWith($image->mime, 'video/')
                            ? route('vid.show', $image)
                            : route('img.show', $image);
                    @endphp

                    <div class="group relative border rounded-lg shadow-sm bg-white overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md">
                        <div class="relative w-full aspect-video flex items-center justify-center bg-gray-100 rounded-t-lg">
                            @if(Str::startsWith($image->mime, 'video/'))
                                <video controls class="absolute inset-0 w-full h-full object-contain rounded-t-lg">
                                    <source src="{{ $viewRoute }}" type="{{ $image->mime }}">
                                    {{ __('content.video_not_supported') }}
                                </video>
                            @else
                                <img src="{{ $viewRoute }}"
                                     alt="{{ $image->original_name }}"
                                     class="absolute inset-0 w-full h-full object-contain rounded-t-lg">
                            @endif
                        </div>

                        <div class="p-3 flex flex-col flex-grow">
                            <div class="text-sm font-medium text-gray-800 truncate mb-2" title="{{ $image->original_name }}">
                                {{ $image->original_name }}
                            </div>
                            <div class="flex-grow"></div>
                            <div class="grid grid-cols-1 gap-2 text-sm mt-2">
                                <a href="{{ $viewRoute }}" target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                    <i class="bi bi-eye mr-1"></i> {{ __('content.view') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $userImages->links() }}
            </div>
        @else
            <p class="text-gray-600">{{ __('admin.no_user_images') }}</p>
        @endif

        <div class="mt-8 text-right">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                <i class="bi bi-arrow-left mr-2"></i> {{ __('admin.back_to_dashboard') }}
            </a>
        </div>
    </div>
@endsection
