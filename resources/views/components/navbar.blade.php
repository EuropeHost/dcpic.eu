<nav class="bg-white shadow-md px-4 py-3 flex justify-between items-center">
    <a href="{{ route('home') }}" class="text-lg font-bold text-blue-600 hover:text-sky-600">
        DCPic.eu
    </a>

    <div class="flex items-center space-x-4">

        @auth
            <a href="{{ route('images.my') }}" class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
                <i class="bi bi-images"></i>
                <span>{{ __('My Images') }}</span>
            </a>

            <a href="{{ route('images.recent') }}" class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
                <i class="bi bi-clock-history"></i>
                <span>{{ __('Recent Uploads') }}</span>
            </a>

            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-sky-600 font-medium flex items-center space-x-1">
                <i class="bi bi-speedometer"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        @endauth

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center text-sm focus:outline-none">
                <img src="{{ asset('img/SetLocale/' . app()->getLocale() . '.png') }}"
                     class="w-5 h-3 mr-1" alt="{{ app()->getLocale() }}">
                <i class="bi bi-chevron-down text-xs"></i>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-28 bg-white border rounded shadow-lg z-50">
                @foreach(File::directories(resource_path('lang')) as $langDir)
                    @php $lang = basename($langDir); @endphp
                    @if($lang !== app()->getLocale())
                        <form method="POST" action="{{ route('set-locale') }}">
                            @csrf
                            <input type="hidden" name="locale" value="{{ $lang }}">
                            <button type="submit" class="flex items-center px-3 py-2 hover:bg-gray-100 text-sm w-full">
                                <img src="{{ asset('img/SetLocale/' . $lang . '.png') }}" class="w-5 h-3 mr-2" alt="{{ $lang }}">
                                {{ strtoupper($lang) }}
                            </button>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 hover:underline text-sm flex items-center space-x-1">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ __('Logout') }}</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-sky-600 hover:underline flex items-center space-x-1">
                <i class="bi bi-discord"></i>
                <span>{{ __('Login') }}</span>
            </a>
        @endauth

    </div>
</nav>
