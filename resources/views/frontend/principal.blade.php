@extends('layouts.frontend.heard')

@guest
    @section('body_attrs', 'data-freepick-auto')
@endguest

@section('content')
    @php $L = fn($key) => __t('text.frontend.landing.' . $key); @endphp
    <main>
        {{-- ============ HERO CON VIDEO (Contenido Web > Banner principal) ============ --}}
        <section class="tbh-hero relative overflow-hidden flex items-center min-h-[calc(100svh-5rem)] md:min-h-[min(88vh,920px)] py-20">
            {{-- Fondo: imagen inmediata y, encima, el video cuando ya puede reproducirse --}}
            <div class="absolute inset-0" aria-hidden="true">
                <picture>
                    <source media="(max-width: 767px)" srcset="{{ $hero->url('poster_mobile') }}">
                    <img src="{{ $hero->url('poster') }}" alt="" class="tbh-hero-media" fetchpriority="high">
                </picture>
                @if($hero->show_video)
                    <video class="tbh-hero-media tbh-hero-video" muted loop playsinline preload="none" disablepictureinpicture
                           data-sources-desktop="{{ json_encode($hero->sources('desktop')) }}"
                           data-sources-mobile="{{ json_encode($hero->sources('mobile')) }}"></video>
                @endif
                <div class="absolute inset-0 bg-black" style="opacity: {{ $hero->overlay / 100 }}"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/20 to-transparent hidden lg:block"></div>
                <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#050505] to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="max-w-2xl mx-auto lg:mx-0 text-center lg:text-left space-y-6" data-reveal>
                    <span class="inline-flex items-center gap-2 py-1 px-3 rounded-full text-xs font-semibold bg-black/50 backdrop-blur text-lime-300 border border-lime-800 uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span> {{ __t('text.frontend.winners', 'Winners need to be with winners') }}
                    </span>

                    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tighter text-white uppercase leading-none drop-shadow-[0_4px_24px_rgba(0,0,0,0.6)]">
                        {{__t('text.frontend.intelligence', 'Intelligence')}} <br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">{{ __t('text.frontend.behind_game', 'Behind the Game') }}</span>
                    </h1>

                    <p class="text-base sm:text-lg text-neutral-200 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        {{__t('text.frontend.we_break_the_sports_matrix', 'We break the sports Matrix. At La Mano Negra, we don t guess; we process the chaos to deliver absolute mathematical precision.')}}
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <a href="{{route('show.plans')}}" class="btn-neon btn-shine inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                            <i data-lucide="zap" class="w-4 h-4"></i> {{ $L('hero_cta_plans') }}
                        </a>
                        @guest
                            <button type="button" data-open-freepick class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-xs font-bold uppercase tracking-wider border border-white/30 bg-black/40 backdrop-blur text-white hover:border-lime-400 hover:text-lime-300 transition-all cursor-pointer">
                                <i data-lucide="gift" class="w-4 h-4"></i> {{ $L('hero_cta_free') }}
                            </button>
                        @endguest
                    </div>

                    <p class="text-xs font-mono text-lime-300">{{ $L('hero_from_price') }}</p>

                    <ul class="flex flex-wrap justify-center lg:justify-start gap-x-6 gap-y-2 pt-2 text-xs text-neutral-300">
                        {{-- Estado real: solo dice "publicados" si hoy ya salió un pick de suscripción --}}
                        <li class="flex items-center gap-1.5 font-semibold {{ $picksPublishedToday ? 'text-lime-300' : 'text-neutral-200' }}">
                            <span class="relative flex w-2 h-2">
                                @if($picksPublishedToday)
                                    <span class="absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75 animate-ping"></span>
                                @endif
                                <span class="relative inline-flex w-2 h-2 rounded-full {{ $picksPublishedToday ? 'bg-lime-400' : 'bg-amber-400' }}"></span>
                            </span>
                            {{ $picksPublishedToday ? $L('hero_badge_live') : $L('hero_badge_soon') }}
                        </li>
                        <li class="flex items-center gap-1.5"><i data-lucide="lock" class="w-3.5 h-3.5 text-lime-400"></i>{{ $L('hero_trust_secure') }}</li>
                        <li class="flex items-center gap-1.5"><i data-lucide="zap" class="w-3.5 h-3.5 text-lime-400"></i>{{ $L('hero_trust_instant') }}</li>
                        <li class="flex items-center gap-1.5"><i data-lucide="headphones" class="w-3.5 h-3.5 text-lime-400"></i>{{ $L('hero_trust_support') }}</li>
                    </ul>
                </div>
            </div>

            {{-- Indicador para seguir bajando --}}
            <a href="#after-hero" class="tbh-hero-scroll absolute bottom-6 left-1/2 -translate-x-1/2 z-10 hidden md:flex flex-col items-center gap-1 text-[10px] uppercase tracking-widest text-neutral-400 hover:text-lime-300">
                {{ $L('hero_scroll') }}
                <i data-lucide="chevron-down" class="w-5 h-5"></i>
            </a>

            @if($hero->show_video)
                <button type="button" class="tbh-hero-toggle absolute bottom-6 right-4 sm:right-6 z-10 hidden w-10 h-10 rounded-full border border-white/25 bg-black/50 backdrop-blur text-white hover:border-lime-400 hover:text-lime-300 items-center justify-center cursor-pointer"
                        aria-pressed="false" aria-label="{{ $L('hero_pause') }}" data-label-pause="{{ $L('hero_pause') }}" data-label-play="{{ $L('hero_play') }}">
                    <i data-lucide="pause" class="w-4 h-4" data-icon-pause></i>
                    <i data-lucide="play" class="w-4 h-4 hidden" data-icon-play></i>
                </button>
            @endif
        </section>

        <span id="after-hero"></span>
        {{-- ============ TICKER DE DEPORTES ============ --}}
        @php $sports = ['⚽ ' . $L('ticker_football'), '🏀 NBA', '🏈 NFL', '⚾ MLB', '🥊 UFC', '🎾 ' . $L('ticker_tennis'), '📊 ' . $L('ticker_asian'), '⚡ ' . $L('ticker_live')]; @endphp
        <section class="border-y border-neutral-900 bg-black/40 py-5 marquee overflow-hidden" aria-hidden="true">
            <div class="marquee-track">
                @foreach(array_merge($sports, $sports) as $sport)
                    <span class="mx-8 text-sm font-bold uppercase tracking-widest text-neutral-500 whitespace-nowrap">{{ $sport }}</span>
                @endforeach
            </div>
        </section>

        {{-- ============ PROPUESTA DE VALOR + CONTADORES ============ --}}
        <section class="py-24 border-b border-neutral-900 bg-black/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    <div class="space-y-6" data-reveal>
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase mb-4 leading-tight">
                            {{__t('text.frontend.we_are_not_a_casino', 'We are not a casino')}}, <span class="text-lime-400">{{__t('text.frontend.we_are_your_analytical_advantage', 'We are your analytical advantage')}}.</span>
                        </h2>
                        <p class="text-neutral-300 text-sm sm:text-base leading-relaxed">
                            {{__t('text.frontend.we_dont_make_noise', "We pay no heed to media noise or short-term trends. We work with rigorous quantitative models—the same ones used by major investment funds—but apply them in real-time to the world's most liquid sports markets: the NBA, NFL, MLB, and elite soccer")}}
                        </p>
                        <p class="text-neutral-300 text-sm sm:text-base leading-relaxed border-l-2 border-lime-500 pl-4 bg-lime-950/20 py-2">
                            {{__t('text.frontend.statistical_advantage', 'Through La Mano Negra, we offer you access to a statistical edge that was traditionally available to only 1% of the market. Our goal is clear: to provide you with accurate, verified data so you can make your own decisions and place bets with better information.')}}
                        </p>
                    </div>

                    @php
                        $stats = [
                        ['icon' => 'cpu',          'count' => 10,  'prefix' => '+', 'suffix' => 'M', 'decimals' => 0, 'label' => __t('text.frontend.bets_evaluated_every', 'bets evaluated every 24 hours')],
                        ['icon' => 'shield-check', 'count' => 100, 'prefix' => '',  'suffix' => '%', 'decimals' => 0, 'label' => __t('text.frontend.transparently_documented_results', 'transparently documented results')],
                        ['icon' => 'zap',          'count' => 0.3, 'prefix' => '',  'suffix' => 's', 'decimals' => 1, 'label' => __t('text.frontend.your_edge_over_the_market', 'your edge over the market')],
                        ['icon' => 'globe',        'count' => 12,  'prefix' => '',  'suffix' => '',  'decimals' => 0, 'label' => __t('text.frontend.proven_profit_engines', 'proven profit engines')],
                    ];
                    @endphp
                    <div class="grid grid-cols-2 gap-4 sm:gap-6">
                        @foreach($stats as $i => $stat)
                            <div class="bg-neutral-900/50 p-5 sm:p-6 rounded-2xl neon-border neon-glow-hover transition-all" data-reveal style="--reveal-delay: {{ $i * 100 }}ms">
                                <div class="text-lime-400 mb-3"><i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i></div>
                                <span class="text-3xl sm:text-4xl font-black text-white font-mono block mb-1 tracking-tight"
                                      data-count="{{ $stat['count'] }}" data-prefix="{{ $stat['prefix'] }}" data-suffix="{{ $stat['suffix'] }}" data-decimals="{{ $stat['decimals'] }}">{{ $stat['prefix'] . $stat['count'] . $stat['suffix'] }}</span>
                                <span class="text-[11px] sm:text-xs uppercase tracking-wider font-bold text-lime-300 opacity-80">{{ $stat['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>

        {{-- ============ 3 PASOS ============ --}}
        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14" data-reveal>
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $L('steps_kicker') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ $L('steps_title') }}</h2>
                </div>

                @php $steps = [['user-plus', 'step1'], ['credit-card', 'step2'], ['trophy', 'step3']]; @endphp
                <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="hidden md:block absolute top-10 left-[16%] right-[16%] h-px bg-gradient-to-r from-transparent via-lime-400/40 to-transparent"></div>
                    @foreach($steps as $i => [$icon, $key])
                        <div class="relative text-center" data-reveal style="--reveal-delay: {{ $i * 150 }}ms">
                            <div class="relative mx-auto w-20 h-20 rounded-2xl bg-neutral-950 border border-lime-400/40 flex items-center justify-center text-lime-400 shadow-[0_0_30px_rgba(163,230,53,0.15)] mb-6">
                                <i data-lucide="{{ $icon }}" class="w-8 h-8"></i>
                                <span class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-lime-400 text-black text-xs font-black flex items-center justify-center">{{ $i + 1 }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wide mb-2">{{ $L($key . '_title') }}</h3>
                            <p class="text-sm text-neutral-400 max-w-xs mx-auto leading-relaxed">{{ $L($key . '_text') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('show.how-it-works') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-lime-400 hover:text-lime-300">
                        {{ $L('steps_more') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============ PLANES ============ --}}
        <section id="planes" class="py-24 border-y border-neutral-900 bg-black/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14" data-reveal>
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $L('plans_kicker') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ $L('plans_title') }}</h2>
                    <p class="mt-4 text-neutral-400 text-sm">{{ $L('plans_subtitle') }}</p>
                </div>

                @include('frontend.partials.plan-cards')
            </div>
        </section>

        {{-- ============ PRINCIPIOS ============ --}}
        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16" data-reveal>
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{__t('text.frontend.high_tech_fundamentals', 'High-Tech Fundamentals')}}</span>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{__t('text.frontend.algorithmic_principles', 'Algorithmic Principles')}}</h2>
                    <p class="mt-4 text-neutral-400 text-sm max-w-xl mx-auto">{{__t('text.frontend.the_unshakable', 'The unshakable foundations of our predictive technology applied to athletic performance')}}</p>
                </div>

                @php
                    $principles = [
                    ['eye',         __t('text.frontend.radical_transparency', 'Radical Transparency'), __t('text.frontend.we_hide_nothing', 'We hide nothing. Every forecast and metric issued is archived in our public, immutable record. We present both successes and failures with the same analytical honesty.')],
                    ['binary',      __t('text.frontend.quantitative_rigor', 'QUANTITATIVE RIGOR'), __t('text.frontend.we_eliminate_the_emotional_factor', 'We eliminate the emotional factor. Our predictions stem from pure data models: dynamic statistical analysis, scenario simulation, and automated adjustments based on historical performance and fatigue')],
                    ['trending-up', __t('text.frontend.sustained_growth', 'Sustained Growth'), __t('text.frontend.we_develop_analysts', "We develop analysts, not impulsive bettors. Our goal does not hinge on a single day's luck, but rather on building intelligent bankroll management to maximize long-term returns.")],
                ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($principles as $i => [$icon, $title, $text])
                        <div class="p-8 bg-neutral-900/50 rounded-2xl border border-neutral-800/60 transition-all duration-300 neon-glow-hover text-center md:text-left" data-reveal style="--reveal-delay: {{ $i * 120 }}ms">
                            <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 mx-auto md:mx-0 mb-6 neon-border">
                                <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wide mb-3">{{ $title }}</h3>
                            <p class="text-xs text-neutral-300 leading-relaxed">{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ COMPARATIVA ============ --}}
        <section class="py-24 border-y border-neutral-900 bg-black/30">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14" data-reveal>
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $L('compare_kicker') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ $L('compare_title') }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-7 rounded-2xl border border-red-500/20 bg-red-950/10" data-reveal>
                        <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-red-400 mb-6">
                            <i data-lucide="x-circle" class="w-5 h-5"></i> {{ $L('compare_without') }}
                        </h3>
                        <ul class="space-y-4">
                            @foreach(['w1', 'w2', 'w3', 'w4'] as $item)
                                <li class="flex items-start gap-3 text-sm text-neutral-400">
                                    <i data-lucide="x" class="w-4 h-4 mt-0.5 shrink-0 text-red-400/80"></i>{{ $L('compare_' . $item) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-7 rounded-2xl border border-lime-400/40 bg-lime-950/20 shadow-[0_0_40px_rgba(163,230,53,0.08)]" data-reveal style="--reveal-delay: 150ms">
                        <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-lime-400 mb-6">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i> {{ $L('compare_with') }}
                        </h3>
                        <ul class="space-y-4">
                            @foreach(['c1', 'c2', 'c3', 'c4'] as $item)
                                <li class="flex items-start gap-3 text-sm text-neutral-200">
                                    <i data-lucide="check" class="w-4 h-4 mt-0.5 shrink-0 text-lime-400"></i>{{ $L('compare_' . $item) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ RESULTADOS VERIFICABLES Y TESTIMONIOS ============ --}}
        @include('frontend.partials.results')
        @include('frontend.partials.testimonials')

        {{-- ============ PICK GRATIS (LEAD MAGNET) ============ --}}
        @guest
            <section class="py-24">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="relative overflow-hidden rounded-3xl border border-lime-400/30 bg-gradient-to-br from-lime-950/40 via-black to-black p-8 sm:p-12" data-reveal>
                        <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full bg-lime-400/10 blur-3xl pointer-events-none"></div>
                        <div class="relative grid grid-cols-1 md:grid-cols-[1fr_auto] gap-8 items-center">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $L('free_kicker') }}</span>
                                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white uppercase mb-3">{{ $L('free_title') }}</h2>
                                <p class="text-neutral-300 text-sm leading-relaxed max-w-xl">{{ $L('free_text') }}</p>
                                <ul class="flex flex-wrap gap-x-5 gap-y-2 mt-5 text-xs text-neutral-400">
                                    @foreach(['free_b1', 'free_b2', 'free_b3'] as $item)
                                        <li class="flex items-center gap-1.5"><i data-lucide="check" class="w-3.5 h-3.5 text-lime-400"></i>{{ $L($item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" data-open-freepick class="btn-neon btn-shine inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-xs font-bold uppercase tracking-wider transition-all cursor-pointer">
                                <i data-lucide="gift" class="w-4 h-4"></i> {{ $L('free_cta') }}
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        @endguest

        {{-- ============ FAQ ============ --}}
        @if($faqs->isNotEmpty())
            <section class="py-24 border-t border-neutral-900">
                <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12" data-reveal>
                        <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ $L('faq_kicker') }}</span>
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ $L('faq_title') }}</h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($faqs as $item)
                            <details class="group bg-neutral-900/30 border border-neutral-800/80 rounded-xl open:border-lime-400/40 transition-colors" data-reveal>
                                <summary class="flex justify-between items-center p-5 cursor-pointer select-none list-none">
                                    <h3 class="text-sm sm:text-base font-bold text-white pr-4">{{ $item->question }}</h3>
                                    <i data-lucide="chevron-down" class="w-5 h-5 text-lime-400 shrink-0 group-open:rotate-180 transition-transform duration-300"></i>
                                </summary>
                                <div class="px-5 pb-5 border-t border-neutral-800/40 pt-4 text-sm text-neutral-400 leading-relaxed space-y-2">
                                    {!! $item->answer !!}
                                </div>
                            </details>
                        @endforeach
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('show.frequently-asked-questions') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-lime-400 hover:text-lime-300">
                            {{ $L('faq_more') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        {{-- ============ CTA FINAL ============ --}}
        <section class="relative py-20 border-t border-neutral-900 overflow-hidden bg-gradient-to-br from-black via-lime-950/30 to-black">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-lime-400 via-emerald-400 to-lime-400 shadow-xl shadow-lime-500/50"></div>

            <div class="max-w-4xl mx-auto px-4 text-center relative z-10" data-reveal>
                <h3 class="text-2xl sm:text-3xl font-black text-white uppercase mb-4 tracking-tighter">{{__t('text.frontend.read_for_operation', 'Ready to trade with the advantage of La Mano Negra?')}}</h3>
                <p class="text-neutral-200 text-xs sm:text-sm mb-10 max-w-xl mx-auto">{{__t('text.frontend.join_the_terminal', 'Join the VIP terminal and gain instant access to the automated projections from our elite algorithm.')}}</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @guest
                        <a href="{{route('show.register')}}" class="btn-neon btn-shine inline-flex items-center justify-center gap-2 font-bold uppercase tracking-wider text-xs px-10 py-5 rounded-xl transition-all shadow-2xl shadow-lime-500/50">
                            <i data-lucide="user-plus" class="w-4 h-4"></i> {{__t('text.frontend.menu_sign_up', 'Sign up')}}
                        </a>
                    @endguest
                    <a href="{{route('show.plans')}}" class="inline-flex items-center justify-center gap-2 font-bold uppercase tracking-wider text-xs px-10 py-5 rounded-xl border border-neutral-700 text-white hover:border-lime-400 hover:text-lime-300 transition-all">
                        {{ $L('final_cta_plans') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        // Video del banner: elige la versión móvil o de escritorio, respeta "reducir movimiento" y
        // "ahorro de datos" (solo imagen) y se pausa cuando sale de la pantalla.
        (function () {
            var video = document.querySelector('.tbh-hero-video');
            var toggle = document.querySelector('.tbh-hero-toggle');
            if (!video) return;

            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var saveData = navigator.connection && navigator.connection.saveData;
            if (reduceMotion || saveData) {
                video.remove();
                if (toggle) toggle.remove();
                return;
            }

            var isMobile = window.matchMedia('(max-width: 767px)').matches;
            var sources = JSON.parse(video.dataset[isMobile ? 'sourcesMobile' : 'sourcesDesktop']);
            sources.forEach(function (item) {
                var source = document.createElement('source');
                source.src = item.src;
                source.type = item.type;
                video.appendChild(source);
            });

            var pausedByUser = false;

            function setIcons(playing) {
                if (!toggle) return;
                toggle.setAttribute('aria-pressed', playing ? 'false' : 'true');
                toggle.setAttribute('aria-label', playing ? toggle.dataset.labelPause : toggle.dataset.labelPlay);
                toggle.querySelector('[data-icon-pause]').classList.toggle('hidden', !playing);
                toggle.querySelector('[data-icon-play]').classList.toggle('hidden', playing);
            }

            video.addEventListener('playing', function () {
                video.classList.add('is-playing');
                if (toggle) toggle.classList.replace('hidden', 'flex');
                setIcons(true);
            });
            video.addEventListener('pause', function () { setIcons(false); });

            video.load();
            video.play().catch(function () { /* autoplay bloqueado: queda la imagen */ });

            if (toggle) {
                toggle.addEventListener('click', function () {
                    if (video.paused) {
                        pausedByUser = false;
                        video.play();
                    } else {
                        pausedByUser = true;
                        video.pause();
                    }
                });
            }

            // Fuera de pantalla no se reproduce (ahorra batería y CPU)
            if ('IntersectionObserver' in window) {
                new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            if (!pausedByUser) video.play().catch(function () {});
                        } else {
                            video.pause();
                        }
                    });
                }, {threshold: 0.1}).observe(video);
            }
        })();
    </script>
@endsection
