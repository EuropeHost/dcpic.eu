@extends('layouts.app')

@section('content')
    <section
        id="hero"
        x-data="{ show: false }"
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
            class="pointer-events-none absolute -left-32 -top-40 h-96 w-96
                   animate-pulse-fast rounded-full bg-indigo-600 opacity-30
                   blur-3xl"
        ></span>
        <span
            class="pointer-events-none absolute -right-24 top-1/3 h-80 w-80
                   animate-bounce-slow rounded-full bg-sky-500 opacity-40
                   mix-blend-lighten blur-2xl"
        ></span>

        <div class="relative z-10 px-6 text-center">
            <h1
                x-show="show"
                x-transition.duration.800ms
                class="text-5xl font-extrabold tracking-tight text-white
                       drop-shadow-xl sm:text-6xl md:text-7xl"
            >
                {!! __('content.home_title') !!}
            </h1>

            <p
                x-show="show"
                x-transition.delay.200ms.duration.800ms
                class="mx-auto mt-6 max-w-3xl text-xl text-white/90 sm:text-2xl
                       md:text-3xl"
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
                           py-4 text-base font-semibold text-white sm:text-lg"
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
                           py-4 text-base font-semibold text-white sm:text-lg"
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
            <div class="feature-card sm:col-span-2 lg:col-span-1">
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

	<section
	    id="stats"
	    class="home mx-auto flex min-h-screen w-full max-w-7xl flex-col
	           items-center justify-center px-4 py-24"
	>
	    <div class="grid w-full grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
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
	
	        <div class="stat-card transform rounded-xl border bg-white p-8 shadow-lg
	                    transition duration-300 hover:scale-105 hover:shadow-xl
	                    md:col-span-2 lg:col-span-1">
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
	                                class="avatar h-10 w-10 rounded-full border-2 border-sky-400 object-cover" />
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
	    </div>
	
	    <div class="stat-card mx-auto mt-12 w-full transform rounded-xl border bg-white p-8 shadow-lg transition duration-300">
	        <h2 class="mb-4 text-center text-2xl font-bold text-gray-800">
	            {{ __('content.top_image_users') }}
	        </h2>
	        @if ($topImageUsers->isNotEmpty())
	            <ul class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
	                @foreach ($topImageUsers as $index => $user)
	                    <li class="user-item flex items-center space-x-3 rounded-lg bg-gray-50 p-2 transition
	                               duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm">
	                        <div class="rank flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
	                                    bg-sky-100 text-lg font-bold text-sky-600">
	                            {{ $index + 1 }}
	                        </div>
	                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
	                            class="h-10 w-10 rounded-full border-2 border-sky-400 object-cover" />
	                        <div class="min-w-0 flex-grow text-left">
	                            <p class="truncate font-semibold text-gray-800">{{ $user->name }}</p>
	                            <p class="text-sm text-gray-600">
	                                <span class="animated-count" data-start="0"
	                                    data-end="{{ $user->image_count }}"
	                                    data-decimals="0"></span> {{ __('content.images') }}
	                            </p>
	                        </div>
	                    </li>
	                @endforeach
	            </ul>
	        @else
	            <p class="text-center text-gray-600">
	                {{ __('content.no_top_image_users') }}
	            </p>
	        @endif
	    </div>
	
	    <div class="stat-card mx-auto mt-12 w-full transform rounded-xl border bg-white p-8 shadow-lg transition duration-300">
	        <h2 class="mb-4 text-center text-2xl font-bold text-gray-800">
	            {{ __('content.top_link_users') }}
	        </h2>
	        @if ($topLinkUsers->isNotEmpty())
	            <ul class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
	                @foreach ($topLinkUsers as $index => $user)
	                    <li class="user-item flex items-center space-x-3 rounded-lg bg-gray-50 p-2 transition
	                               duration-200 hover:scale-[1.02] hover:bg-gray-100 hover:shadow-sm">
	                        <div class="rank flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
	                                    bg-sky-100 text-lg font-bold text-sky-600">
	                            {{ $index + 1 }}
	                        </div>
	                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
	                            class="h-10 w-10 rounded-full border-2 border-sky-400 object-cover" />
	                        <div class="min-w-0 flex-grow text-left">
	                            <p class="truncate font-semibold text-gray-800">{{ $user->name }}</p>
	                            <p class="text-sm text-gray-600">
	                                <span class="animated-count" data-start="0"
	                                    data-end="{{ $user->link_count }}"
	                                    data-decimals="0"></span> {{ __('content.links') }}
	                            </p>
	                        </div>
	                    </li>
	                @endforeach
	            </ul>
	        @else
	            <p class="text-center text-gray-600">
	                {{ __('content.no_top_link_users') }}
	            </p>
	        @endif
	    </div>
	</section>

    @push('scripts')
        <script>
            const animateCount = (el, dur = 2500) => {
                const s = +el.dataset.start,
                    e = +el.dataset.end,
                    dec = +el.dataset.decimals;
                let st = null;
                const step = (t) => {
                    st ??= t;
                    const p = Math.min((t - st) / dur, 1);
                    el.textContent = (s + (e - s) * p).toFixed(dec);
                    p < 1 && requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            };

            const stars = () => {
                const c = document.getElementById('stars');
                if (!c) return;
                const ctx = c.getContext('2d');
                let w, h, f;
                const resize = () => {
                    w = c.width = innerWidth;
                    h = c.height = document.getElementById('hero').offsetHeight;
                    f = Array.from({ length: Math.min(w, 180) }, () => ({
                        x: Math.random() * w,
                        y: Math.random() * h,
                        r: Math.random() * 1.2 + 0.2,
                        v: Math.random() * 0.6 + 0.2
                    }));
                };
                const draw = () => {
                    ctx.clearRect(0, 0, w, h);
                    ctx.fillStyle = '#fff';
                    f.forEach((p) => {
                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                        ctx.fill();
                        p.y += p.v;
                        if (p.y > h) p.y = 0;
                    });
                    requestAnimationFrame(draw);
                };
                resize();
                addEventListener('resize', resize);
                draw();
            };

            const tilt = (e) => {
                document
                    .querySelectorAll('.discord-login-btn')
                    .forEach((btn) => {
                        const r = btn.getBoundingClientRect();
                        if (
                            e.clientX < r.left ||
                            e.clientX > r.right ||
                            e.clientY < r.top ||
                            e.clientY > r.bottom
                        ) {
                            btn.style.transform = '';
                            return;
                        }
                        const x = (e.clientX - r.left - r.width / 2) / 15;
                        const y = (e.clientY - r.top - r.height / 2) / 15;
                        btn.style.transform = `rotateX(${-y}deg) rotateY(${x}deg)`;
                    });
            };

            const setupStatAnimations = () => {
                const statsSection = document.getElementById('stats');
                if (!statsSection) return;

                const observer = new IntersectionObserver(
                    (entries, observer) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                document
                                    .querySelectorAll('.animated-count')
                                    .forEach((el) => animateCount(el));

                                document
                                    .querySelectorAll('.stat-card')
                                    .forEach((card, index) => {
                                        card.style.animationDelay = `${0.1 * index}s`;
                                        card.classList.add(
                                            'animate-slide-up-custom'
                                        );
                                    });

                                document
                                    .querySelectorAll('.user-item')
                                    .forEach((item, index) => {
                                        item.style.animationDelay = `${0.05 * index}s`;
                                        item.classList.add(
                                            'animate-slide-up-custom'
                                        );
                                    });

                                observer.unobserve(statsSection);
                            }
                        });
                    },
                    { threshold: 0.1 }
                );

                observer.observe(statsSection);
            };

            window.addEventListener('preloader:done', () => {
                stars();
                document.addEventListener('pointermove', tilt, {
                    passive: true
                });
                setupStatAnimations();
            });

            window.addEventListener('load', () => {
                setTimeout(() => {
                    if (!window._preloaderDone) {
                        window.dispatchEvent(new Event('preloader:done'));
                        window._preloaderDone = true;
                    }
                }, 1500);
            });
        </script>
    @endpush
@endsection
