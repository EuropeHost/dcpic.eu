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

    <div class="bg-white shadow rounded p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">{{ __('links.create_new_short_link') }}</h2>
        <form action="{{ route('links.store') }}" method="POST">
            @csrf
            <div class="flex flex-col md:flex-row items-end md:space-x-3 space-y-2 md:space-y-0">
                <div class="flex-grow">
                    <label for="original_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('links.original_url') }}</label>
                    <input type="url" name="original_url" id="original_url" required
                           placeholder="https://example.com/your-long-url-here"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-500 focus:ring-opacity-50 px-4 py-2">
                    @error('original_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="custom_slug" class="block text-sm font-medium text-gray-700 mb-1">{{ __('links.custom_slug_optional') }}</label>
                    <input type="text" name="custom_slug" id="custom_slug"
                           placeholder="yourcustomlink"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-500 focus:ring-opacity-50 px-4 py-2">
                    <p class="text-xs text-gray-500 mt-1">{{ __('links.slug_requirements') }}</p>
                    @error('custom_slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit"
                    class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 transition text-sm flex-shrink-0">
                    <i class="bi bi-link-45deg"></i> {{ __('links.shorten') }}
                </button>
            </div>
        </form>
    </div>

    @if ($latestImages->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('content.latest_uploads') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($latestImages as $image)
                    <div class="bg-white border rounded shadow p-4 relative overflow-hidden">
                        @if (Str::startsWith($image->mime, 'video/'))
                            <video controls class="max-w-full max-h-48 h-auto rounded mb-2 mx-auto">
                                <source src="{{ route('vid.show.slug', $image) }}" type="{{ $image->mime }}">
                                {{ __('content.video_not_supported') }}
                            </video>
                        @else
                            <img src="{{ route('img.show.slug', $image) }}"
                                class="max-w-full max-h-48 h-auto object-contain rounded mb-2 mx-auto"
                                alt="{{ $image->original_name }}">
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
                <a href="{{ route('links.my') }}" class="text-sky-600 hover:underline">
                    {{ __('links.my_short_links') }}
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

    @if ($latestLinks->isNotEmpty())
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('links.latest_short_links') }}</h3>
            <div class="overflow-x-auto bg-white border rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('links.short_link') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('links.original_link') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('links.visits') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('links.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($latestLinks as $link)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('links.show', $link->slug) }}" target="_blank" class="text-sky-600 hover:underline">
                                        {{ env('APP_URL') }}/l/{{ $link->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 truncate" title="{{ $link->original_url }}">
                                    {{ $link->original_url }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($link->views_count) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="navigator.clipboard.writeText('{{ route('links.show', $link->slug) }}')" class="text-blue-500 hover:text-blue-700 mr-3">{{ __('links.copy') }}</button>
                                    <form action="{{ route('links.destroy', $link) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">{{ __('links.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mb-6">
            <h3 class="text-md font-semibold mb-2">{{ __('links.no_links_yet') }}</h3>
            <div class="bg-white border rounded shadow p-4">
                <p>{{ __('links.create_first_link') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-semibold mb-4">{{ __('content.your_stats') }}</h3>
        <p class="text-gray-700 mb-2">
            {{ __('content.total_images_uploaded') }}:
            {{ auth()->user()->images()->count() }}
        </p>
        <p class="text-gray-700 mb-2">
            {{ __('content.total_links_shortened') }}:
            {{ auth()->user()->links()->count() }}
        </p>
        <p class="text-gray-700 mb-2">
            {{ number_format($totalUserLinkViews) }}
        </p>
        <p class="text-gray-700">
            {{ __('content.account_created') }}:
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
