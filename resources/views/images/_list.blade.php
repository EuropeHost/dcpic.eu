@if($images->count())
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($images as $image)
            <div x-data="{ showCopyModal: false, showDeleteModal: false }" class="border rounded shadow p-2 bg-white relative">
                
                {{-- Image Preview --}}
				@if(Str::startsWith($image->mime, 'video/'))
				    <video controls class="w-full h-40 object-cover rounded mb-2">
				        <source src="{{ route('images.show', $image) }}" type="{{ $image->mime }}">
				        {{ __('content.video_not_supported') }}
				    </video>
				@else
				    <img src="{{ route('images.show', $image) }}" 
				         alt="{{ $image->original_name }}" 
				         class="w-full h-40 object-cover rounded mb-2">
				@endif


                {{-- Top row: View + Copy --}}
                <div class="flex justify-between items-center text-sm mt-2">
                    <a href="{{ route('images.show', $image) }}" target="_blank" class="text-blue-500 hover:underline flex items-center space-x-1">
                        <i class="bi bi-eye"></i> <span>{{ __('content.view') }}</span>
                    </a>

                    <button 
                        @click="
                            navigator.clipboard.writeText('{{ route('images.show', $image) }}')
                            .then(() => { showCopyModal = true })
                        "
                        type="button"
                        class="text-gray-500 hover:text-gray-800 flex items-center space-x-1"
                        title="{{ __('Copy link to clipboard') }}">
                        <i class="bi bi-clipboard"></i> <span>{{ __('content.copy_link') }}</span>
                    </button>
                </div>

                {{-- Bottom row: Delete + Visibility --}}
                @if(auth()->id() === $image->user_id)
                    <div class="flex justify-between items-center text-sm mt-2">
                        <button 
                            @click="showDeleteModal = true"
                            type="button"
                            class="text-red-500 hover:underline flex items-center space-x-1"
                        >
                            <i class="bi bi-trash"></i> <span>{{ __('content.delete') }}</span>
                        </button>

                        <form method="POST" action="{{ route('images.toggleVisibility', $image) }}">
                            @csrf
                            @method('PATCH')
                            <select name="is_public" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1">
                                <option value="0" {{ !$image->is_public ? 'selected' : '' }}>{{ __('Private') }}</option>
                                <option value="1" {{ $image->is_public ? 'selected' : '' }}>{{ __('Public') }}</option>
                            </select>
                        </form>
                    </div>
                @endif

                {{-- Image Name --}}
                <div class="text-sm text-gray-700 truncate mt-2" title="{{ $image->original_name }}">
                    {{ $image->original_name }}
                </div>

                {{-- Copy Link Modal --}}
                <div x-show="showCopyModal" 
                     x-cloak
                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                     x-transition
                     @click.away="showCopyModal = false">
                    <div class="bg-white rounded-lg shadow-lg max-w-xs w-full p-6 text-center">
                        <p class="mb-4">{{ __('content.link_copied') }}</p>
                        <button @click="showCopyModal = false" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ __('content.close') }}
                        </button>
                    </div>
                </div>

                {{-- Delete Confirmation Modal --}}
                @if(auth()->id() === $image->user_id)
                    <div x-show="showDeleteModal" 
                         x-cloak
                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                         x-transition
                         @click.away="showDeleteModal = false">
                        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('content.delete_question') }}</h3>
                            <p class="mb-6 text-gray-600 truncate" title="{{ $image->original_name }}">{{ $image->original_name }}</p>

                            <div class="flex justify-end space-x-3">
                                <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                    {{ __('content.cancel') }}
                                </button>

                                <form method="POST" action="{{ route('images.destroy', $image) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        {{ __('content.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $images->links() }}
    </div>
@else
    <p class="text-gray-500">{{ __('content.no_images_yet') }}</p>
@endif
