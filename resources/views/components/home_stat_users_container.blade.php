<div
    class="stat-card mx-auto mt-12 w-full transform rounded-xl border
           bg-white p-8 shadow-lg transition duration-300 hover:scale-105
           {{ $col_span_lg ?? '' }}"
>
    <h2 class="mb-4 text-center text-2xl font-bold text-gray-800">
        {{ $container_title }}
    </h2>
    @if ($users_collection->isNotEmpty())
        @php
            $userCount = $users_collection->count();
            $gridClass = 'grid-cols-1'; // default for mobile

            if ($userCount === 1) {
                $gridClass .= ' md:grid-cols-1 lg:grid-cols-1';
            } elseif ($userCount === 2) {
                $gridClass .= ' md:grid-cols-2 lg:grid-cols-2';
            } elseif ($userCount === 3) {
                $gridClass .= ' md:grid-cols-3 lg:grid-cols-3';
            } else { // 4 or more users
                $gridClass .= ' md:grid-cols-2 lg:grid-cols-4'; // max 4 on large screens
            }
        @endphp

        <ul class="grid {{ $gridClass }} gap-4">
            @foreach ($users_collection as $index => $user)
                <li class="user-item flex items-center space-x-3 rounded-lg bg-gray-50 p-2 transition
                           duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm">
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
                            <span
                                class="animated-count"
                                data-start="0"
                                data-end="{{ number_format(floatval(str_replace(',', '', $user->{$count_field})), $decimals, '.', '') }}"
                                data-decimals="{{ $decimals }}"></span>
                            {{ $count_label }}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-gray-600">
            {{ __('content.no_top_users_found') }}
        </p>
    @endif
</div>
