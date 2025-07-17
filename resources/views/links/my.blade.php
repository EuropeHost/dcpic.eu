@extends('layouts.main')

@section('main')
    <div class="bg-white shadow rounded-lg p-8 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('links.my_short_links') }}</h1>

        <form action="{{ route('links.store') }}" method="POST" class="mb-8 p-4 border rounded-lg bg-gray-50">
            @csrf
            <h2 class="text-xl font-semibold mb-3">{{ __('links.create_new_short_link') }}</h2>
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <label for="original_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('links.original_url') }}</label>
                    <input type="url" name="original_url" id="original_url" required placeholder="https://example.com/long/url"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-500 focus:ring-opacity-50">
                    @error('original_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="custom_slug" class="block text-sm font-medium text-gray-700 mb-1">{{ __('links.custom_slug_optional') }}</label>
                    <input type="text" name="custom_slug" id="custom_slug" placeholder="customlink"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-500 focus:ring-opacity-50">
                    <p class="text-xs text-gray-500 mt-1">{{ __('links.slug_requirements') }}</p>
                    @error('custom_slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="px-5 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition">
                    {{ __('links.shorten') }}
                </button>
            </div>
        </form>

        @if($links->isNotEmpty())
            <div class="overflow-x-auto">
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
                        @foreach($links as $link)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('links.show', $link->slug) }}" target="_blank" class="text-sky-600 hover:underline">
                                        {{ env('APP_URL') }}/l/{{ $link->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate" title="{{ $link->original_url }}">
                                    {{ $link->original_url }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($link->visits) }}</td>
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
            <div class="mt-4">
                {{ $links->links('components.custom-pagination') }}
            </div>
        @else
            <p class="text-gray-500">{{ __('links.no_links_yet') }}</p>
        @endif
    </div>
@endsection
