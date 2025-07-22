@extends('layouts.app')

@section('content')
    @include('pages.home._hero')

    @include('pages.home._stats')

    @include('pages.home._leaderboards')

    @push('scripts')
        <style>
            html { scroll-behavior: smooth; }

            @keyframes pulseFast {
                0%,100% { transform: scale(1); opacity: .3 }
                50%     { transform: scale(1.15); opacity: .6 }
            }
            @keyframes bounceSlow {
                0%,100% { transform: translateY(0) }
                50%     { transform: translateY(-12px) }
            }
            @keyframes slideUp {
                from { opacity: 0; transform: translateY(40px) }
                to   { opacity: 1; transform: translateY(0)   }
            }
            @keyframes float {
                0%,100% { transform: translateY(0) }
                50%     { transform: translateY(-6px) }
            }

            .animate-pulse-fast  { animation: pulseFast 4s infinite }
            .animate-bounce-slow { animation: bounceSlow 6s infinite }

            .scroll-down-btn {
                display: flex; align-items: center; justify-content: center;
                width: 4rem; height: 4rem; border-radius: 9999px; color: #fff;
                background: linear-gradient(135deg,#5865f2,#7289da);
                box-shadow: 0 4px 18px rgba(88,101,242,.45);
                transition: transform .3s, box-shadow .3s;
                animation: bounceSlow 4s infinite;
            }
            .scroll-down-btn:hover {
                transform: translateY(-4px) scale(1.05);
                box-shadow: 0 8px 24px rgba(88,101,242,.65);
            }

            .feature-card {
                display: flex; align-items: center; gap: 1rem;
                background: rgba(31,41,55,.4); padding: 1rem;
                border-radius: .5rem; backdrop-filter: blur(8px);
                color: #fff; opacity: 0; transform: translateY(40px);
                animation: slideUp .8s forwards, float 6s 1s infinite ease-in-out;
            }
            .feature-card:nth-child(1) { animation-delay: .1s,1.1s; }
            .feature-card:nth-child(2) { animation-delay: .25s,1.25s; }
            .feature-card:nth-child(3) { animation-delay: .4s,1.4s; }
            .feature-card i { transition: transform .3s; }
            .feature-card:hover i { transform: scale(1.15) rotate(6deg); }

            .stat-card {
                opacity: 0; transform: translateY(40px);
                animation: slideUp .8s forwards;
            }
        </style>

        <script>
            const animateCount = (el, dur = 4000) => {
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
                const leaderboardsSection = document.getElementById('leaderboards');

                const observerCallback = (entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            if (entry.target.id === 'stats') {
                                document.querySelectorAll('#stats .animated-count').forEach((el) => animateCount(el));
                                document.querySelectorAll('#stats .stat-card').forEach((card, index) => {
                                    card.style.animationDelay = `${0.1 * index}s`;
                                    card.classList.add(
                                        'animate-slide-up-custom'
                                    );
                                });
                            } else if (entry.target.id === 'leaderboards') {
                                document.querySelectorAll('#leaderboards .animated-count').forEach((el) => animateCount(el));
                                document.querySelectorAll('#leaderboards .user-item').forEach((item, index) => {
                                    item.style.animationDelay = `${0.05 * index}s`;
                                    item.classList.add(
                                        'animate-slide-up-custom'
                                    );
                                });
                            }
                            observer.unobserve(entry.target);
                        }
                    });
                };

                const observer = new IntersectionObserver(observerCallback, { threshold: 0.1 });

                if (statsSection) observer.observe(statsSection);
                if (leaderboardsSection) observer.observe(leaderboardsSection);
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
