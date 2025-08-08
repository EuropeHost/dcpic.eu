<div
    class="stat-card mx-auto mt-12 w-full bg-white border shadow-lg rounded-xl p-8 transform transition duration-300"
>
    <h2 class="mb-4 text-center text-2xl font-bold text-gray-800">
        {{ __('content.top_image_users') }}
    </h2>
    @if ($topImageUsers->isNotEmpty())
        <ul class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($topImageUsers as $index => $user)
                <li class="user-item flex items-center space-x-3 bg-gray-50 p-2 rounded-lg transform transition duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm">
                    <div class="rank flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                bg-sky-100 text-lg font-bold text-sky-600">
                        {{ $index + 1 }}
                    </div>
                    <img
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}"
                        class="w-10 h-10 rounded-full border-2 border-sky-400 object-cover"
                    >
                    <div class="min-w-0 flex-grow text-left">
                        <p class="truncate font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">
                            <span class="animated-count" data-start="0"
                                data-end="{{ $user->image_count }}"
                                data-decimals="0"></span> {{ __('content.images') }}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-600">
            {{ __('content.no_top_image_users') }}
        </p>
    @endif
</div>