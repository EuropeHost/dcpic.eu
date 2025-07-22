<section
    id="hero"
    x-data="{ show:false }"
    x-init="
        const nav = document.querySelector('nav');
        const fit = () => {
            $el.style.minHeight =
                'calc(100vh - ' + (nav ? nav.offsetHeight : 0) + 'px)';
        };
        fit();
        window.addEventListener('resize', fit);
        window.addEventListener('preloader:done', () => (show = true));
    "
    class="relative flex flex-col items-center justify-center overflow-hidden
           bg-gray-900"
>
    <canvas id="stars" class="absolute inset-0"></canvas>

    <span
        class="absolute -top-40 -left-32 h-96 w-96 rounded-full
               bg-indigo-600 opacity-30 blur-3xl pointer-events-none
               animate-pulse-fast"
    ></span>
    <span
        class="absolute top-1/3 -right-24 h-80 w-80 rounded-full bg-sky-500
               opacity-40 mix-blend-lighten blur-2xl pointer-events-none
               animate-bounce-slow"
    ></span>

    <div class="relative z-10 px-6 text-center">
        <h1
            x-show="show"
            x-transition.duration.800ms
            class="text-5xl sm:text-6xl md:text-7xl font-extrabold
                   tracking-tight text-white drop-shadow-xl"
        >
            {!! __('content.home_title') !!}
        </h1>

        <p
            x-show="show"
            x-transition.delay.200ms.duration.800ms
            class="mx-auto mt-6 max-w-3xl text-xl sm:text-2xl md:text-3xl
                   text-white/90"
        >
            {!! __('content.home_subtitle') !!}
        </p>

        @guest
            <a
                x-show="show"
                x-transition.delay.400ms.duration.800ms
                href="{{ route('login') }}"
                class="discord-login-btn group relative mt-12 inline-flex
                       items-center justify-center gap-3 rounded-xl px-8
                       py-4 text-base sm:text-lg font-semibold text-white"
            >
                <span
                    class="absolute inset-0 rounded-xl bg-gradient-to-r
                           from-white/20 to-white/5 opacity-0 transition
                           group-hover:opacity-100"
                ></span>
                <i class="bi bi-discord text-2xl"></i>
                {{ __('content.login_with_discord') }}
            </a>
        @else
            <a
                x-show="show"
                x-transition.delay.400ms.duration.800ms
                href="{{ route('dashboard') }}"
                class="discord-login-btn group relative mt-12 inline-flex
                       items-center justify-center gap-3 rounded-xl px-8
                       py-4 text-base sm:text-lg font-semibold text-white"
            >
                <span
                    class="absolute inset-0 rounded-xl bg-gradient-to-r
                           from-white/20 to-white/5 opacity-0 transition
                           group-hover:opacity-100"
                ></span>
                <i class="bi bi-speedometer text-2xl"></i>
                {{ __('content.dashboard') }}
            </a>
        @endguest
    </div>

    <div
        x-show="show"
        x-transition.delay.600ms.duration.800ms
        class="relative z-10 mt-16 grid grid-cols-1 gap-6 px-6 sm:grid-cols-2"
    >
        <div class="feature-card">
            <i class="bi bi-lightning-fill text-3xl text-yellow-400"></i>
            <div>
                <p class="font-bold">{{ __('features.fast_title') }}</p>
                <p class="text-sm opacity-80">
                    {{ __('features.fast_desc') }}
                </p>
            </div>
        </div>
        <div class="feature-card">
            <i class="bi bi-discord text-3xl text-indigo-400"></i>
            <div>
                <p class="font-bold">
                    {{ __('features.discord_title') }}
                </p>
                <p class="text-sm opacity-80">
                    {{ __('features.discord_desc') }}
                </p>
            </div>
        </div>
    </div>

	<div class="absolute bottom-10 left-1/2 -translate-x-1/2">
	    <a href="#stats" class="scroll-down-btn">
	        <i class="bi bi-chevron-double-down text-3xl"></i>
	    </a>
	</div>
</section>
