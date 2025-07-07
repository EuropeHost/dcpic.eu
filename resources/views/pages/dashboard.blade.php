@extends('layouts.main')

@section('main')
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('content.storage_used') }}</label>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-sky-600 h-4 rounded-full transition-all"
                style="width: {{ auth()->user()->storage_percentage }}%">
            </div>
        </div>
        <p class="text-sm mt-1 text-gray-600">
            {{ auth()->user()->storage_used_mb }} MB /
            {{ auth()->user()->storage_limit_mb }} MB
        </p>
    </div>

    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">{{ __('content.upload_image') }}</h2>
        <form action="{{ route('images.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div
                class="flex flex-col md:flex-row items-center md:space-x-3 space-y-2 md:space-y-0">
                <label
                    class="block cursor-pointer bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 ease-in-out text-sm">
                    {{ __('content.choose_file') }}
                    <input type="file" name="file" accept="image/*,video/mp4" required
                        class="hidden">
                </label>
                <small class="text-xs text-gray-500">
                    {{ __('Only .mp4 videos and images (JPG, PNG, GIF, WebP) are allowed. Max size: :max MB.', ['max' => env('MAX_FILE_SIZE', 50)]) }}
                </small>

                <select name="is_public" class="border rounded px-3 py-2 text-sm">
                    <option value="0">{{ __('content.private') }}</option>
                    <option value="1">{{ __('content.public') }}</option>
                </select>

                <button type="submit"
                    class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 transition text-sm">
                    <i class="bi bi-upload"></i> {{ __('content.upload') }}
                </button>
            </div>
        </form>
    </div>


    @if ($latestImage)
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('content.latest_upload') }}</h3>
            <div class="bg-white border rounded shadow p-4">
                @if (Str::startsWith($latestImage->mime, 'video/'))
                    <video controls class="max-w-full h-auto rounded mb-2">
                        <source src="{{ route('images.show', $latestImage) }}"
                            type="{{ $latestImage->mime }}">
                        {{ __('content.video_not_supported') }}
                    </video>
                @else
                    <img src="{{ route('images.show', $latestImage) }}"
                        class="max-w-full h-auto rounded mb-2"
                        alt="{{ $latestImage->original_name }}">
                @endif

                <div class="flex space-x-4 text-sm">
                    <a href="{{ route('images.my') }}" class="text-sky-600 hover:underline">
                        {{ __('content.see_my') }}
                    </a>
                    <a href="{{ route('images.recent') }}"
                        class="text-sky-600 hover:underline">
                        {{ __('content.see_recent') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('content.no_uploads') }}</h3>
            <div class="bg-white border rounded shadow p-4">
                <p>{{ __('content.upload_first') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold mb-4">{{ __('content.your_stats') }}</h3>
        <p class="text-gray-700 mb-2">
            {{ __('content.total_images_uploaded') }}:
            {{ auth()->user()->images()->count() }}
        </p>
        <p class="text-gray-700">
            {{ __('content.account_created') }}:
            {{ auth()->user()->created_at->format('M d, Y') }}
        </p>
    </div>
@endsection
