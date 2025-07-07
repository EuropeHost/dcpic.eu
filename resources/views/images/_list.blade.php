@if($images->count())
    {{-- Reverted grid columns to a max of 4 as per original request --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($images as $image)
            @php
                $viewRoute = Str::startsWith($image->mime, 'video/')
                    ? route('vid.show', $image)
                    : route('img.show', $image);
            @endphp

            <div x-data="{ showCopyModal: false, showDeleteModal: false, isOwner: {{ auth()->id() === $image->user_id ? 'true' : 'false' }} }"
                 class="group relative border rounded-lg shadow-sm bg-white overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md">

                {{-- Image/Video Preview Container --}}
                {{-- Changed to aspect-video and object-contain to show whole media --}}
                <div class="relative w-full aspect-video flex items-center justify-center bg-gray-100 rounded-t-lg">
                    @if(Str::startsWith($image->mime, 'video/'))
                        <video controls class="absolute inset-0 w-full h-full object-contain rounded-t-lg"> {{-- object-contain for full video view --}}
                            <source src="{{ $viewRoute }}" type="{{ $image->mime }}">
                            {{ __('content.video_not_supported') }}
                        </video>
                        {{-- Play icon overlay REMOVED --}}
                    @else
                        <img src="{{ $viewRoute }}"
                             alt="{{ $image->original_name }}"
                             class="absolute inset-0 w-full h-full object-contain rounded-t-lg"> {{-- object-contain for full image view --}}
                    @endif
                </div>

                <div class="p-3 flex flex-col flex-grow">
                    {{-- Image Name (truncated with full name on hover) --}}
                    <div class="text-sm font-medium text-gray-800 truncate mb-2" title="{{ $image->original_name }}">
                        {{ $image->original_name }}
                    </div>

                    {{-- Actions Block --}}
                    <div class="flex-grow"></div> {{-- Pushes actions to the bottom --}}
                    <div class="grid grid-cols-2 gap-2 text-sm mt-2"> {{-- Grid for action buttons --}}

                        {{-- View Button --}}
                        <a href="{{ $viewRoute }}" target="_blank"
                           class="inline-flex items-center justify-center p-2 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            <i class="bi bi-eye mr-1"></i> {{ __('content.view') }}
                        </a>

                        {{-- Copy Link Button --}}
                        <button
                            @click="navigator.clipboard.writeText('{{ $viewRoute }}').then(() => { showCopyModal = true })"
                            type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                            title="{{ __('content.copy_link_title') }}">
                            <i class="bi bi-clipboard mr-1"></i> {{ __('content.copy_link') }}
                        </button>

                        @if(auth()->id() === $image->user_id) {{-- Only show if authenticated user is owner --}}
                            {{-- Delete Button --}}
                            <button
                                @click="showDeleteModal = true"
                                type="button"
                                class="inline-flex items-center justify-center p-2 rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition">
                                <i class="bi bi-trash mr-1"></i> {{ __('content.delete') }}
                            </button>

                            {{-- Visibility Select --}}
                            <form method="POST" action="{{ route('images.toggleVisibility', $image) }}" class="col-span-1">
                                @csrf
                                @method('PATCH')
                                <select name="is_public" onchange="this.form.submit()"
                                        class="w-full text-sm border-gray-300 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-sky-500 focus:border-sky-500 p-2 pr-8 transition">
                                    <option value="0" {{ !$image->is_public ? 'selected' : '' }}>{{ __('content.private') }}</option>
                                    <option value="1" {{ $image->is_public ? 'selected' : '' }}>{{ __('content.public') }}</option>
                                </select>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Copy Link Modal --}}
                <div x-show="showCopyModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4"
                     @click.away="showCopyModal = false">
                    <div class="bg-white rounded-xl shadow-2xl max-w-xs w-full p-6 text-center">
                        <p class="text-lg font-semibold mb-4 text-gray-800">{{ __('content.link_copied') }}</p>
                        <button @click="showCopyModal = false"
                                class="px-5 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                            {{ __('content.close') }}
                        </button>
                    </div>
                </div>

                {{-- Delete Confirmation Modal --}}
                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4"
                     @click.away="showDeleteModal = false">
                    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('content.delete_question') }}</h3>
                        <p class="mb-6 text-gray-600 truncate text-base" title="{{ $image->original_name }}">
                            {{ $image->original_name }}
                        </p>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button @click="showDeleteModal = false"
                                    class="px-5 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                {{ __('content.cancel') }}
                            </button>

                            <form method="POST" action="{{ route('images.destroy', $image) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    {{ __('content.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $images->links('vendor.pagination.images') }}
    </div>
@else
    <p class="text-gray-500 text-center py-8">{{ __('content.no_images_yet') }}</p>
@endif
