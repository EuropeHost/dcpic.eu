@php
$bgColors = [
    'info' => 'bg-blue-50 border-blue-200 text-blue-900',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-900',
    'danger' => 'bg-red-50 border-red-200 text-red-900',
    'success' => 'bg-green-50 border-green-200 text-green-900',
];

$announcements = [
    [
        'id' => 'alpha',
        'type' => 'info',
        'title' => __('announcement.alpha.title'),
        'message' => __('announcement.alpha.message'),
        'link' => [
            'href' => 'https://github.com/EuropeHost/dcpics.eu',
            'text' => __('announcement.alpha.cta'),
        ],
    ],
    [
        'id' => 'storage',
        'type' => 'success',
        'title' => __('announcement.storage.title'),
        'message' => __('announcement.storage.message'),
        'link' => null,
    ],
	[
	    'id' => 'feedback_request',
	    'type' => 'success',
	    'title' => __('announcement.feedback.title'),
	    'message' => __('announcement.feedback.message'),
	    'link' => [
	        'href' => 'https://github.com/EuropeHost/dcpics.eu/discussions',
	        'text' => __('announcement.feedback.cta'),
	    ],
	],
];
@endphp

@foreach ($announcements as $announcement)
    @if (!session()->has("announcement_dismissed_{$announcement['id']}"))
        <!--div class="w-full {{ $bgColors[$announcement['type']] ?? 'bg-gray-100 text-gray-800' }} border-b text-sm px-4 py-2 flex items-center justify-center gap-2 font-medium shadow-sm z-50 relative">
            @if (!empty($announcement['title']))
                <span class="hidden sm:inline">{{ $announcement['title'] }}</span>
            @endif
            <span>{{ $announcement['message'] }}</span>
            @if (!empty($announcement['link']))
                <a href="{{ $announcement['link']['href'] }}"
                   target="_blank"
                   class="text-blue-600 underline hover:text-blue-800 transition duration-150 ease-in-out">
                    {{ $announcement['link']['text'] }}
                </a>
            @endif

            <form method="POST" action="{{ route('announcement.dismiss', $announcement['id']) }}" class="absolute right-2 top-1/2 -translate-y-1/2">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 transition">&times;</button>
            </form>
        </div->
    @endif
@endforeach
