<section
    id="stats"
    class="home mx-auto flex min-h-screen w-full max-w-7xl flex-col
           items-center justify-center px-4 py-24"
>
    <div class="grid w-full grid-cols-1 gap-8 md:grid-cols-2"> {{-- Changed to md:grid-cols-2 for exactly 2 containers --}}
        <div class="stat-card flex transform flex-col justify-between rounded-xl
                    border bg-white p-8 shadow-lg transition duration-300
                    hover:scale-105 hover:shadow-xl">
            <div class="text-center">
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
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($totalUsed / 1048576, 2, '.', '') }}"
                        data-decimals="2"></span>
                    MB /
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($totalLimit / 1073741824, 2, '.', '') }}"
                        data-decimals="2"></span>
                    GiB
                </p>
                <p class="text-md text-gray-600">
                    (<span class="animated-count" data-start="0"
                        data-end="{{ number_format($storagePercentage, 1, '.', '') }}"
                        data-decimals="1"></span>
                    % {{ __('content.used') }})
                </p>
            </div>
            <div class="mt-6 border-t border-gray-200 pt-4 text-center">
                <p class="text-md text-gray-700">
                    <strong>{{ __('content.average_per_user') }}:</strong>
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($avgPerUser / 1048576, 2, '.', '') }}"
                        data-decimals="2"></span>
                    MB
                </p>
            </div>
        </div>

        <div class="stat-card flex transform flex-col justify-between rounded-xl
                    border bg-white p-8 shadow-lg transition duration-300
                    hover:scale-105 hover:shadow-xl">
            <div class="text-center">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">
                    {{ __('content.general_stats') }}
                </h2>
                <p class="mb-2 text-lg text-gray-700">
                    <i class="bi bi-person-fill mr-2 text-sky-600"></i>
                    <strong>{{ __('content.total_users') }}:</strong>
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($totalUsers, 0, '.', '') }}"
                        data-decimals="0"></span>
                </p>
                <p class="mb-2 text-lg text-gray-700">
                    <i class="bi bi-image-fill mr-2 text-sky-600"></i>
                    <strong>{{ __('content.total_images_uploaded') }}:</strong>
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($totalImages, 0, '.', '') }}"
                        data-decimals="0"></span>
                </p>
                <p class="text-lg text-gray-700">
                    <i class="bi bi-link-45deg mr-2 text-sky-600"></i>
                    <strong>{{ __('content.total_links_created') }}:</strong>
                    <span class="animated-count" data-start="0"
                        data-end="{{ number_format($totalLinks, 0, '.', '') }}"
                        data-decimals="0"></span>
                </p>
            </div>
            <div class="mt-6 border-t border-gray-200 pt-4 text-center">
                <p class="text-sm italic text-gray-500">
                    {{ __('content.stats_update_info') }}
                </p>
            </div>
        </div>
    </div>
</section>