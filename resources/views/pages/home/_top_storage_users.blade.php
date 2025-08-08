<div class="stat-card transform rounded-xl border bg-white p-8 shadow-lg
            transition duration-300 hover:scale-105 hover:shadow-xl
            md:col-span-2 lg:col-span-1 home mx-auto mt-12 max-w-6xl px-4 py-12 text-center">
    <h2 class="mb-4 text-center text-2xl font-bold text-gray-800">
        {{ __('content.top_storage_users') }}
    </h2>
    @if ($topStorageUsers->isNotEmpty())
        <ul class="space-y-3">
            @foreach ($topStorageUsers as $index => $user)
                <li class="user-item flex items-center space-x-3 rounded-lg bg-gray-50 p-2 transition
                           duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm">
                    <div class="rank flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                bg-sky-100 text-lg font-bold text-sky-600">
                        {{ $index + 1 }}
                    </div>
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                        class="w-10 h-10 rounded-full border-2 border-sky-400 object-cover" />
                    <div class="min-w-0 flex-grow text-left">
                        <p class="truncate font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">
                            <span class="animated-count" data-start="0"
                                data-end="{{ $user->storage_used_mb }}"
                                data-decimals="2"></span> MB
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-600">
            {{ __('content.no_top_storage_users') }}
        </p>
    @endif
</div>