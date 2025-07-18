@extends('layouts.main')

@section('main')
    <div class="bg-white shadow rounded-lg p-8 mb-6" x-data="{
        emailHover: false,
        showRoleModal: false,
        newRole: '{{ $user->role }}',
        showDeleteUserModal: false,
        modalEmailHover: false
    }">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('admin.user_details') }}</h1>

        <div class="flex flex-col sm:flex-row items-start sm:items-center mb-6 bg-gray-50 p-4 rounded-lg border">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-sky-400 mr-6 mb-4 sm:mb-0">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-1">{{ $user->name }}</h2>
                <p
                    class="text-md text-gray-600 transition-all duration-300 mb-1"
                    :class="{ 'filter blur-sm': !emailHover }"
                    @mouseenter="emailHover = true"
                    @mouseleave="emailHover = false">
                    {{ $user->email }}
                </p>
                <p class="text-md text-gray-600 mb-1">{{ __('admin.discord_id_label') }}: <span class="font-mono text-gray-800">{{ $user->discord_id }}</span></p>
                <p class="text-md text-gray-600 capitalize">
                    {{ __('admin.role') }}: <span class="font-bold text-sky-700">{{ $user->role }}</span>
                    @if(auth()->user()->id !== $user->id)
                        <button @click="showRoleModal = true" class="text-blue-500 hover:underline ml-2 text-sm focus:outline-none">
                            <i class="bi bi-pencil-square"></i> {{ __('admin.change_role') }}
                        </button>
                    @endif
                </p>
                <p class="text-md text-gray-600">{{ __('admin.account_created_on') }}: {{ $user->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-5 border">
                <p class="text-lg font-semibold text-gray-700">{{ __('admin.images_uploaded') }}</p>
                <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_count) }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 border">
                <p class="text-lg font-semibold text-gray-700">{{ __('admin.storage_used') }}</p>
                <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->images_sum_size / 1024 / 1024, 2) }} MB</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 border">
                <p class="text-lg font-semibold text-gray-700">{{ __('admin.links_shortened') }}</p>
                <p class="text-3xl font-bold text-sky-600 mt-1">{{ number_format($user->links_count) }}</p>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('admin.user_images') }}</h3>
        @if($userImages->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($userImages as $image)
                    @php
                        $viewRoute = Str::startsWith($image->mime, 'video/')
                            ? route('vid.show.slug', $image)
                            : route('img.show.slug', $image);
                    @endphp

                    <div class="group relative border rounded-lg shadow-sm bg-white overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md">
                        <div class="relative w-full aspect-video flex items-center justify-center bg-gray-100 rounded-t-lg">
                            @if(Str::startsWith($image->mime, 'video/'))
                                <video controls class="absolute inset-0 w-full h-full object-contain rounded-t-lg">
                                    <source src="{{ $viewRoute }}" type="{{ $image->mime }}">
                                    {{ __('content.video_not_supported') }}
                                </video>
                            @else
                                <img src="{{ $viewRoute }}"
                                     alt="{{ $image->original_name }}"
                                     class="absolute inset-0 w-full h-full object-contain rounded-t-lg">
                            @endif
                        </div>

                        <div class="p-3 flex flex-col flex-grow">
                            <div class="text-sm font-medium text-gray-800 truncate mb-2" title="{{ $image->original_name }}">
                                {{ $image->original_name }}
                            </div>
                            <div class="flex-grow"></div>
                            <div class="flex justify-between items-center text-sm mt-2">
                                <a href="{{ $viewRoute }}" target="_blank"
                                   class="inline-flex items-center p-2 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                    <i class="bi bi-eye mr-1"></i> {{ __('content.view') }}
                                </a>
                                <form method="POST" action="{{ route('images.destroy', $image) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-2 rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition">
                                        <i class="bi bi-trash mr-1"></i> {{ __('content.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $userImages->links('components.custom-pagination') }}
            </div>
        @else
            <p class="text-gray-600">{{ __('admin.no_user_images') }}</p>
        @endif

        <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-8">{{ __('admin.user_links') }}</h3> {{-- New lang key --}}
        @if($userLinks->isNotEmpty())
            <div class="overflow-x-auto bg-white border rounded shadow mb-6">
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
                        @foreach($userLinks as $link)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('links.show', $link->slug) }}" target="_blank" class="text-sky-600 hover:underline">
                                        {{ env('APP_URL') }}/l/{{ $link->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 truncate" title="{{ $link->original_url }}">
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
            <div class="mt-8 flex justify-center">
                {{ $userLinks->links('components.custom-pagination') }}
            </div>
        @else
            <p class="text-gray-600 mb-6">{{ __('admin.no_user_links') }}</p> {{-- New lang key --}}
        @endif


        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                <i class="bi bi-arrow-left mr-2"></i> {{ __('admin.back_to_dashboard') }}
            </a>
            @if(auth()->user()->id !== $user->id)
                <button @click="showDeleteUserModal = true" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    <i class="bi bi-person-x mr-2"></i> {{ __('admin.delete_user') }}
                </button>
            @endif
        </div>

        <div x-show="showRoleModal" x-cloak
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4"
             @click.away="showRoleModal = false">
            <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-8" x-data="{ modalEmailHover: false }">
                <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('admin.change_user_role') }}</h3>
                <p class="mb-4 text-gray-600">
                    {{ $user->name }} (<span
                        class="transition-all duration-300"
                        :class="{ 'filter blur-sm': !modalEmailHover }"
                        @mouseenter="modalEmailHover = true"
                        @mouseleave="modalEmailHover = false"
                    >{{ $user->email }}</span>)
                </p>

                <form method="POST" action="{{ route('admin.users.update_role', $user) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-6">
                        <label for="new_role" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.select_new_role') }}</label>
                        <select id="new_role" name="role" x-model="newRole" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-500 focus:ring-opacity-50 px-4 py-2">
                            <option value="user">{{ __('admin.role_user') }}</option>
                            <option value="admin">{{ __('admin.role_admin') }}</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button @click="showRoleModal = false" type="button" class="px-5 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                            {{ __('content.cancel') }}
                        </button>
                        <button type="submit" class="px-5 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                            {{ __('admin.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showDeleteUserModal" x-cloak
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4"
             @click.away="showDeleteUserModal = false">
            <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-8" x-data="{ modalEmailHover: false }">
                <h3 class="text-xl font-bold text-red-700 mb-4">{{ __('admin.confirm_delete_user') }}</h3>
                <p class="mb-6 text-gray-600">
                    {{ __('admin.delete_user_warning', ['user_name' => $user->name]) }} (<span
                        class="transition-all duration-300"
                        :class="{ 'filter blur-sm': !modalEmailHover }"
                        @mouseenter="modalEmailHover = true"
                        @mouseleave="modalEmailHover = false"
                    >{{ $user->email }}</span>)
                </p>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteUserModal = false" type="button" class="px-5 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                        {{ __('content.cancel') }}
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            {{ __('admin.delete_user_confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
