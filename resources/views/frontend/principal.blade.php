@extends('layouts.frontend.heard')

@section('content')

    <main class="py-4">
        <section class="relative py-20 lg:py-32 overflow-hidden flex items-center min-h-[85vh]">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                    <div class="text-center lg:text-left space-y-6 order-2 lg:order-1">
                        <span class="inline-flex items-center gap-2 py-1 px-3 rounded-full text-xs font-semibold bg-lime-950 text-lime-300 border border-lime-800 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span> {{ __t('text.frontend.winners', 'Winners need to be with winners') }}
                        </span>

                        <h1 class="text-4xl sm:text-6xl font-black tracking-tighter text-white uppercase leading-none">
                            {{__t('text.frontend.intelligence', 'Intelligence')}} <br class="hidden sm:block">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">{{ __t('text.frontend.behind_game', 'Behind the Game') }}</span>
                        </h1>

                        <p class="text-base sm:text-lg text-neutral-300 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                            {{__t('text.frontend.we_break_the_sports_matrix', 'We break the sports Matrix. At La Mano Negra, we don t guess; we process the chaos to deliver absolute mathematical precision.')}}
                        </p>

                        <div class="pt-4">
                            <a href="{{route('show.plans')}}" class="btn-neon inline-block px-8 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                                {{__t('text.frontend.explorar_terminal_vip', 'Explore the VIP Terminal')}}
                            </a>
                        </div>
                    </div>

                    <div class="flex justify-center items-center order-1 lg:order-2">
                        <div class="relative w-full max-w-[480px] sm:max-w-[550px] lg:max-w-none group">

                            <div class="absolute -inset-1 bg-gradient-to-r from-lime-500 to-emerald-500 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition duration-1000"></div>

                            <div class="relative rounded-3xl border border-neutral-800/80 bg-neutral-950 p-2 overflow-hidden shadow-[0_0_50px_rgba(163,230,53,0.05)]">
                                <img src="{{ asset('img/logo-faro.jpg') }}" alt="La Mano Negra Spotlight"
                                     class="w-full h-auto rounded-2xl object-cover grayscale-[10%] contrast-[110%] group-hover:scale-[102%] transition-all duration-700">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-black/10 pointer-events-none"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-24 border-t border-b border-neutral-900 bg-black/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    <div class="space-y-6">
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase mb-4 leading-tight">
                            {{__t('text.frontend.we_are_not_a_casino', 'We are not a casino')}}, <span class="text-lime-400">{{__t('text.frontend.we_are_your_analytical_advantage', 'We are your analytical advantage')}}.</span>
                        </h2>
                        <p class="text-neutral-300 text-sm sm:text-base leading-relaxed">
                            {{__t('text.frontend.we_are_not_a_casino', 'We are not a casino')}}
                            {{__t('text.frontend.we_dont_make_noise', "We pay no heed to media noise or short-term trends. We work with rigorous quantitative models—the same ones used by major investment funds—but apply them in real-time to the world's most liquid sports markets: the NBA, NFL, MLB, and elite soccer")}}
                        </p>
                        <p class="text-neutral-300 text-sm sm:text-base leading-relaxed border-l-2 border-lime-500 pl-4 bg-lime-950/20 py-2">
                            {{__t('text.frontend.statistical_advantage', 'Through La Mano Negra, we offer you access to a statistical edge that was traditionally available to only 1% of the market. Our goal is clear: to provide you with accurate, verified data so you can make your own decisions and place bets with better information.')}}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-neutral-900/50 p-6 rounded-2xl neon-border">
                            <div class="text-lime-400 mb-3"><i data-lucide="cpu" class="w-6 h-6"></i></div>
                            <span class="text-4xl font-black text-white font-mono block mb-1 tracking-tight">+10M</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-lime-300 opacity-80">{{__t('text.frontend.bets_evaluated_every', 'bets evaluated every 24 hours')}}</span>
                        </div>
                        <div class="bg-neutral-900/50 p-6 rounded-2xl neon-border">
                            <div class="text-lime-400 mb-3"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
                            <span class="text-4xl font-black text-white font-mono block mb-1 tracking-tight">100%</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-lime-300 opacity-80">{{__t('text.frontend.transparently_documented_results', 'transparently documented results')}}</span>
                        </div>
                        <div class="bg-neutral-900/50 p-6 rounded-2xl neon-border">
                            <div class="text-lime-400 mb-3"><i data-lucide="zap" class="w-6 h-6"></i></div>
                            <span class="text-4xl font-black text-white font-mono block mb-1 tracking-tight">0.3s</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-lime-300 opacity-80">{{__t('text.frontend.your_edge_over_the_market', 'your edge over the market')}}</span>
                        </div>
                        <div class="bg-neutral-900/50 p-6 rounded-2xl neon-border">
                            <div class="text-lime-400 mb-3"><i data-lucide="globe" class="w-6 h-6"></i></div>
                            <span class="text-4xl font-black text-white font-mono block mb-1 tracking-tight">12</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-lime-300 opacity-80">{{__t('text.frontend.proven_profit_engines', 'proven profit engines')}}</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{__t('text.frontend.high_tech_fundamentals', 'High-Tech Fundamentals')}}</span>
                    <h2 class="text-4xl font-black tracking-tight text-white uppercase">{{__t('text.frontend.algorithmic_principles', 'Algorithmic Principles')}}</h2>
                    <p class="mt-4 text-neutral-400 text-sm max-w-xl mx-auto">{{__t('text.frontend.the_unshakable', 'The unshakable foundations of our predictive technology applied to athletic performance')}}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 bg-neutral-900/50 rounded-2xl border border-neutral-800/60 transition-all duration-300 neon-glow-hover text-center md:text-left">
                        <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 mx-auto md:mx-0 mb-6 neon-border">
                            <i data-lucide="eye" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.radical_transparency', 'Radical Transparency')}}</h3>
                        <p class="text-xs text-neutral-300 leading-relaxed">
                            {{__t('text.frontend.we_hide_nothing', 'We hide nothing. Every forecast and metric issued is archived in our public, immutable record. We present both successes and failures with the same analytical honesty.')}}
                        </p>
                    </div>
                    <div class="p-8 bg-neutral-900/50 rounded-2xl border border-neutral-800/60 transition-all duration-300 neon-glow-hover text-center md:text-left">
                        <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 mx-auto md:mx-0 mb-6 neon-border">
                            <i data-lucide="binary" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.quantitative_rigor', 'QUANTITATIVE RIGOR')}}</h3>
                        <p class="text-xs text-neutral-300 leading-relaxed">
                            {{__t('text.frontend.we_eliminate_the_emotional_factor', 'We eliminate the emotional factor. Our predictions stem from pure data models: dynamic statistical analysis, scenario simulation, and automated adjustments based on historical performance and fatigue')}}
                        </p>
                    </div>
                    <div class="p-8 bg-neutral-900/50 rounded-2xl border border-neutral-800/60 transition-all duration-300 neon-glow-hover text-center md:text-left">
                        <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 mx-auto md:mx-0 mb-6 neon-border">
                            <i data-lucide="trending-up" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.sustained_growth', 'Sustained Growth')}}</h3>
                        <p class="text-xs text-neutral-300 leading-relaxed">
                            {{__t('text.frontend.we_develop_analysts', "We develop analysts, not impulsive bettors. Our goal does not hinge on a single day's luck, but rather on building intelligent bankroll management to maximize long-term returns.")}}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative py-20 border-t border-neutral-900 overflow-hidden bg-gradient-to-br from-black via-lime-950/30 to-black">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-lime-400 via-emerald-400 to-lime-400 shadow-xl shadow-lime-500/50"></div>

            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <h3 class="text-2xl sm:text-3xl font-black text-white uppercase mb-4 tracking-tighter">{{__t('text.frontend.read_for_operation', 'Ready to trade with the advantage of La Mano Negra?')}}</h3>
                <p class="text-neutral-200 text-xs sm:text-sm mb-10 max-w-xl mx-auto">{{__t('text.frontend.join_the_terminal', 'Join the VIP terminal and gain instant access to the automated projections from our elite algorithm.')}}</p>
                <a href="{{route('show.register')}}" class="inline-block btn-neon font-bold uppercase tracking-wider text-xs px-10 py-5 rounded-xl transition-all shadow-2xl shadow-lime-500/50">
                    {{__t('text.frontend.menu_sign_up', 'Sign up')}}
                </a>
            </div>
        </section>
    </main>

@endsection