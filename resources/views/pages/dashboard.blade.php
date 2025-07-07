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
                    class="block cursor-pointer bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 ease-in-out text-sm flex-shrink-0">
                    <span id="fileName">{{ __('content.choose_file') }}</span>
                    <input type="file" name="file" id="fileInput"
                        accept="image/*,video/mp4" required class="hidden">
                </label>
                <small class="text-xs text-gray-500">
                    {{ __('Only .mp4 videos and images (JPG, PNG, GIF, WebP) are allowed. Max size: :max MB.', ['max' => env('MAX_FILE_SIZE', 50)]) }}
                </small>

                <select name="is_public" class="border rounded px-3 py-2 text-sm flex-shrink-0">
                    <option value="0">{{ __('content.private') }}</option>
                    <option value="1">{{ __('content.public') }}</option>
                </select>

                <button type="submit"
                    class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 transition text-sm flex-shrink-0">
                    <i class="bi bi-upload"></i> {{ __('content.upload') }}
                </button>
            </div>
        </form>
    </div>

    {{-- Display last up to 5 uploads --}}
    @if ($latestImages->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('content.latest_uploads') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($latestImages as $image)
                    <div class="bg-white border rounded shadow p-4 relative overflow-hidden">
                        @if (Str::startsWith($image->mime, 'video/'))
                            <video controls class="max-w-full max-h-48 h-auto rounded mb-2 mx-auto"
                                data-id="{{ $image->id }}">
                                <source src="{{ route('images.show', $image) }}" type="{{ $image->mime }}">
                                {{ __('content.video_not_supported') }}
                            </video>
                        @else
                            <img src="{{ route('images.show', $image) }}"
                                class="max-w-full max-h-48 h-auto object-contain rounded mb-2 mx-auto"
                                alt="{{ $image->original_name }}" data-id="{{ $image->id }}">
                        @endif

                        <div class="flex space-x-2 text-xs justify-center flex-wrap">
                            <span class="text-gray-600">{{ $image->created_at->diffForHumans() }}</span>
                            <span class="text-gray-600">|</span>
                            <span class="text-gray-600">{{ number_format($image->size / 1024 / 1024, 2) }} MB</span>
                            <span class="text-gray-600">|</span>
                            <span class="text-gray-600">{{ $image->is_public ? __('content.public') : __('content.private') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex space-x-4 text-sm mt-4 justify-center">
                <a href="{{ route('images.my') }}" class="text-sky-600 hover:underline">
                    {{ __('content.see_my') }}
                </a>
                <a href="{{ route('images.recent') }}" class="text-sky-600 hover:underline">
                    {{ __('content.see_recent') }}
                </a>
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
            {{ auth()->user()->created_at->format('M d, Y') }}
        </p>
    </div>

    @push('scripts')
        <script>
            // File input name display
            document.getElementById('fileInput').addEventListener('change', function() {
                const fileNameSpan = document.getElementById('fileName');
                if (this.files && this.files.length > 0) {
                    fileNameSpan.textContent = this.files[0].name;
                } else {
                    fileNameSpan.textContent = '{{ __('content.choose_file') }}';
                }
            });
        </script>
    @endpush
@endsection
