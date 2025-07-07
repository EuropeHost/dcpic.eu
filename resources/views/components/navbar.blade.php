<nav class="bg-white shadow-md px-4 py-3 flex justify-between items-center">
    <a href="{{ route('home') }}"
        class="text-lg font-bold text-blue-600 hover:text-sky-600">
        {{ env('APP_NAME') }}
    </a>

    <div class="flex items-center space-x-4">

        @auth
            @php
                $user = auth()->user();
                $discordId = $user->discord_id;
                $avatarHash = $user->avatar;

                // Determine avatar URL or use a fallback
                $avatarUrl = asset('img/default-avatar.png'); // Default fallback
                if ($discordId && $avatarHash) {
                    $avatarUrl = "https://cdn.discordapp.com/avatars/{$discordId}/{$avatarHash}.png";
                }
            @endphp

            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('images.my') }}"
                    class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
                    <i class="bi bi-images"></i>
                    <span>{{ __('content.my_images') }}</span>
                </a>

                <a href="{{ route('images.recent') }}"
                    class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
                    <i class="bi bi-clock-history"></i>
                    <span>{{ __('content.recent_uploads') }}</span>
                </a>
			@if ($user->role === 'admin')
				
			    <a href="{{ route('admin.dashboard') }}"
			        class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
			        <i class="bi bi-speedometer"></i>
			        <span>{{ __('admin.admin_dashboard') }}</span>
			    </a>
			@endif
            </div>
        @endauth
		
        <div x-data="{ open: false }" class="relative z-20">
            <button @click="open = !open" class="flex items-center text-sm focus:outline-none px-2 py-1 rounded-md hover:bg-gray-100 transition">
                <img src="{{ asset('img/SetLocale/' . app()->getLocale() . '.png') }}"
                     class="w-8 h-5 mr-1" alt="{{ app()->getLocale() }}">
                <i class="bi bi-chevron-down text-xs"></i>
            </button>

            <div x-show="open" @click.away="open = false" x-transition.origin.top-right
                 class="absolute right-0 mt-2 w-20 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden">
                @foreach(File::directories(resource_path('lang')) as $langDir)
                    @php $lang = basename($langDir); @endphp
                    @if($lang !== app()->getLocale())
                        <form method="POST" action="{{ route('set-locale') }}">
                            @csrf
                            <input type="hidden" name="locale" value="{{ $lang }}">
                            <button type="submit" class="flex items-center px-3 py-2 hover:bg-gray-100 text-sm w-full text-left">
                                <img src="{{ asset('img/SetLocale/' . $lang . '.png') }}" class="w-7 h-5 mr-1" alt="{{ $lang }}">
                                {{ strtoupper($lang) }}
                            </button>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>

        @auth
            <div x-data="{ open: false }" class="relative z-30">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none px-2 py-1 rounded-md hover:bg-gray-100 transition">
                    <img src="{{ $avatarUrl }}" alt="User Avatar"
                        class="rounded-full w-8 h-8 object-cover border border-gray-200">
                    <span class="hidden md:inline text-gray-700 font-medium">{{ $user->name }}</span>
                    <i class="bi bi-chevron-down text-xs"></i>
                </button>

                <div x-show="open" @click.away="open = false" x-transition.origin.top-right
                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden">
                    <a href="{{ route('dashboard') }}"
                        class="block text-gray-700 hover:bg-gray-100 hover:text-sky-600 font-medium flex items-center space-x-2 text-sm px-4 py-2">
                        <i class="bi bi-speedometer"></i>
                        <span>{{ __('content.dashboard') }}</span>
                    </a>

                    <div class="md:hidden">
                        <a href="{{ route('images.my') }}"
                            class="block text-gray-700 hover:bg-gray-100 hover:text-sky-600 font-medium flex items-center space-x-2 text-sm px-4 py-2">
                            <i class="bi bi-images"></i>
                            <span>{{ __('content.my_images') }}</span>
                        </a>

                        <a href="{{ route('images.recent') }}"
                            class="block text-gray-700 hover:bg-gray-100 hover:text-sky-600 font-medium flex items-center space-x-2 text-sm px-4 py-2">
                            <i class="bi bi-clock-history"></i>
                            <span>{{ __('content.recent_uploads') }}</span>
                        </a>
                    </div>
					
					@if ($user->role === 'admin')
					    <a href="{{ route('admin.dashboard') }}"
					        class="block text-gray-700 hover:bg-gray-100 hover:text-sky-600 font-medium flex items-center space-x-2 text-sm px-4 py-2">
					        <i class="bi bi-speedometer"></i>
					        <span>{{ __('admin.admin_dashboard') }}</span>
					    </a>
					@endif
					
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-sm text-red-500 text-left">
                            <i class="bi bi-box-arrow-right mr-2"></i> {{ __('content.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
                class="text-sky-600 hover:underline flex items-center space-x-1">
                <i class="bi bi-discord"></i>
                <span>{{ __('content.login') }}</span>
            </a>
        @endauth

    </div>
</nav>
