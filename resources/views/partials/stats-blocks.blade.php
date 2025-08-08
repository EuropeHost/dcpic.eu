{{-- 3-column stats grid --------------------------------------------------- --}}
<div
    class="mx-auto mt-12 grid max-w-6xl grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
>
    {{-- Storage overview --}}
    <div
        class="reveal flex flex-col justify-between rounded-xl border bg-white p-8 shadow-lg transition duration-300 hover:scale-105 hover:shadow-xl"
    >
        <div>
            <h2 class="mb-4 text-2xl font-bold text-gray-800">
                {{ __('content.storage_overview') }}
            </h2>

            <div class="mb-2 h-4 w-full rounded-full bg-gray-200">
                <div
                    class="h-4 rounded-full bg-sky-600 transition-all"
                    style="width: {{ $storagePercentage }}%"
                ></div>
            </div>

            <p class="mb-1 text-lg font-semibold text-gray-700">
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($totalUsed / 1048576, 2, '.', '') }}"
                    data-decimals="2"
                ></span>
                MB /
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($totalLimit / 1073741824, 2, '.', '') }}"
                    data-decimals="2"
                ></span>
                GiB
            </p>

            <p class="text-md text-gray-600">
                (
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($storagePercentage, 1, '.', '') }}"
                    data-decimals="1"
                ></span>
                % {{ __('content.used') }})
            </p>
        </div>

        <div class="mt-6 border-t border-gray-200 pt-4">
            <p class="text-md text-gray-700">
                <strong>{{ __('content.average_per_user') }}:</strong>
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($avgPerUser / 1048576, 2, '.', '') }}"
                    data-decimals="2"
                ></span>
                MB
            </p>
        </div>
    </div>

    {{-- General stats --}}
    <div
        class="reveal flex flex-col justify-between rounded-xl border bg-white p-8 shadow-lg transition duration-300 hover:scale-105 hover:shadow-xl"
    >
        <div>
            <h2 class="mb-4 text-2xl font-bold text-gray-800">
                {{ __('content.general_stats') }}
            </h2>

            <p class="mb-2 text-lg text-gray-700">
                <i class="bi bi-person-fill mr-2 text-sky-600"></i>
                <strong>{{ __('content.total_users') }}:</strong>
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($totalUsers, 0, '.', '') }}"
                    data-decimals="0"
                ></span>
            </p>

            <p class="text-lg text-gray-700">
                <i class="bi bi-image-fill mr-2 text-sky-600"></i>
                <strong>{{ __('content.total_images_uploaded') }}:</strong>
                <span
                    class="animated-count"
                    data-start="0"
                    data-end="{{ number_format($totalImages, 0, '.', '') }}"
                    data-decimals="0"
                ></span>
            </p>
        </div>

        <div class="mt-6 border-t border-gray-200 pt-4">
            <p class="text-sm italic text-gray-500">
                {{ __('content.stats_update_info') }}
            </p>
        </div>
    </div>

    {{-- Top storage users --}}
    <div
        class="reveal col-span-1 rounded-xl border bg-white p-8 shadow-lg transition duration-300 hover:scale-105 hover:shadow-xl md:col-span-2 lg:col-span-1"
    >
        <h2 class="mb-4 text-2xl font-bold text-gray-800">
            {{ __('content.top_storage_users') }}
        </h2>

        @if ($topStorageUsers->isNotEmpty())
            <ul class="space-y-3">
                @foreach ($topStorageUsers as $index => $user)
                    <li
                        class="flex cursor-pointer items-center space-x-3 rounded-lg bg-gray-50 p-2 transition duration-200 transform hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm"
                    >
                        <div
                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-lg font-bold text-sky-600"
                        >
                            {{ $index + 1 }}
                        </div>

                        <img
                            src="{{ $user->avatar_url }}"
                            alt="{{ $user->name }}"
                            class="h-10 w-10 rounded-full border-2 border-sky-400 object-cover"
                        >

                        <div class="flex-grow">
                            <p class="font-semibold text-gray-800">
                                {{ $user->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span
                                    class="animated-count"
                                    data-start="0"
                                    data-end="{{ number_format(
                                        floatval(str_replace(',', '', $user->storage_used_mb)),
                                        2,
                                        '.',
                                        ''
                                    ) }}"
                                    data-decimals="2"
                                ></span>
                                MB
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">
                {{ __('content.no_top_storage_users') }}
            </p>
        @endif
    </div>
</div>

{{-- Top image users ------------------------------------------------------ --}}
<div
    class="reveal mx-auto mt-12 max-w-6xl rounded-xl border bg-white p-8 shadow-lg transition duration-300 hover:scale-105 hover:shadow-xl"
>
    <h2 class="mb-4 text-2xl font-bold text-gray-800">
        {{ __('content.top_image_users') }}
    </h2>

    @if ($topImageUsers->isNotEmpty())
        <ul class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($topImageUsers as $index => $user)
                <li
                    class="flex cursor-pointer items-center space-x-3 rounded-lg bg-gray-50 p-2 transition duration-200 transform hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm"
                >
                    <div
                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-sky-100 text-lg font-bold text-sky-600"
                    >
                        {{ $index + 1 }}
                    </div>

                    <img
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}"
                        class="h-10 w-10 rounded-full border-2 border-sky-400 object-cover"
                    >

                    <div class="flex-grow">
                        <p class="font-semibold text-gray-800">
                            {{ $user->name }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span
                                class="animated-count"
                                data-start="0"
                                data-end="{{ number_format($user->image_count, 0, '.', '') }}"
                                data-decimals="0"
                            ></span>
                            {{ __('content.images') }}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-600">
            {{ __('content.no_top_image_users') }}
        </p>
    @endif
</div>