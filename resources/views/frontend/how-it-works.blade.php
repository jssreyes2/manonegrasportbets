@extends('layouts.frontend.heard')

@section('content')
    <main>
        <section class="relative py-24 lg:py-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-flex items-center gap-2 py-1 px-3 rounded-full text-xs font-semibold bg-lime-950 text-lime-300 border border-lime-800 mb-6 uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span> {{__t('text.frontend.how_it_works_operations_manual', 'Operations Manual')}}
                </span>
                <h1 class="text-5xl sm:text-7xl font-black tracking-tighter text-white uppercase mb-8 leading-none">
                    {{__t('text.frontend.how_it_works_join_Now', 'Join Now')}} <br class="hidden sm:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">{{__t('text.frontend.how_it_works_join_text', 'Your Access to the Algorithmic Advantage')}}</span>
                </h1>
                <p class="text-lg sm:text-xl text-neutral-300 max-w-2xl mx-auto leading-relaxed">
                    {{__t('text.frontend.how_it_works_frictionless', 'No friction, no delays. We designed an optimized ecosystem that lets you go from raw data to intelligent execution in a matter of seconds.')}}
                </p>
            </div>
        </section>

        <section class="py-20 border-t border-b border-neutral-900 bg-black/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    <div class="bg-neutral-900/40 p-8 rounded-2xl border border-neutral-800/60 relative overflow-hidden transition-all duration-300 neon-glow-hover flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 neon-border">
                                    <i data-lucide="credit-card" class="w-6 h-6"></i>
                                </div>
                                <span class="text-5xl font-black font-mono text-neutral-800 tracking-tighter select-none">01</span>
                            </div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.how_it_works_choose_plan', 'Choose a plan')}}</h3>
                            <p class="text-sm text-neutral-400 leading-relaxed">
                                {{__t('text.frontend.how_it_works_choose_plan_description', 'Secure, encrypted payment meeting institutional standards in under a minute. Immediate credential activation.')}}
                            </p>
                        </div>
                    </div>

                    <div class="bg-neutral-900/40 p-8 rounded-2xl border border-neutral-800/60 relative overflow-hidden transition-all duration-300 neon-glow-hover flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 neon-border">
                                    <i data-lucide="smartphone" class="w-6 h-6"></i>
                                </div>
                                <span class="text-5xl font-black font-mono text-neutral-800 tracking-tighter select-none">02</span>
                            </div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.login', 'Login')}}</h3>
                            <p class="text-sm text-neutral-400 leading-relaxed">
                                {{__t('text.frontend.how_it_works_login_description', 'No downloads or complex installations. Your daily insights work natively on mobile, tablet, and desktop.')}}
                            </p>
                        </div>
                    </div>

                    <div class="bg-neutral-900/40 p-8 rounded-2xl border border-neutral-800/60 relative overflow-hidden transition-all duration-300 neon-glow-hover flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 neon-border">
                                    <i data-lucide="terminal" class="w-6 h-6"></i>
                                </div>
                                <span class="text-5xl font-black font-mono text-neutral-800 tracking-tighter select-none">03</span>
                            </div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.how_it_works_get_the_analysis', 'Get the analysis')}}</h3>
                            <p class="text-sm text-neutral-400 leading-relaxed">
                                {{__t('text.frontend.how_it_works_get_the_analysis_description_1', 'Instantly access clean metrics and filtered projections. View them at the following path:')}}<span class="text-lime-400 font-mono">
                                   {{__t('text.frontend.how_it_works_get_the_analysis_description_2', 'Account → Daily Insights')}}
                                </span>.
                            </p>
                        </div>
                    </div>

                    <div class="bg-neutral-900/40 p-8 rounded-2xl border border-neutral-800/60 relative overflow-hidden transition-all duration-300 neon-glow-hover flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-8">
                                <div class="w-12 h-12 bg-neutral-900 border border-neutral-800 rounded-xl flex items-center justify-center text-lime-400 neon-border">
                                    <i data-lucide="bell" class="w-6 h-6"></i>
                                </div>
                                <span class="text-5xl font-black font-mono text-neutral-800 tracking-tighter select-none">04</span>
                            </div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-wide mb-3">{{__t('text.frontend.how_it_works_stay_ahead', 'Stay aheade')}}</h3>
                            <p class="text-sm text-neutral-400 leading-relaxed">
                                {{__t('text.frontend.how_it_works_stay_ahead_description', 'Maximize efficiency. Receive critical push notifications, bookmark essential pages, and export historical data extracts.')}}
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Cambiado a una sola columna para que abarque todo el ancho -->
                <div class="w-full space-y-6">
                    <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block">{{__t('text.frontend.how_it_works_real_time_synchronization', 'Real-Time Synchronization')}}</span>

                    <h2 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase leading-tight">
                        {{__t('text.frontend.how_it_works_real_time_synchronization_title_1', "Don't wait for the result:")}}
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">
                   {{__t('text.frontend.how_it_works_real_time_synchronization_title_2', "Get ahead of the payment.")}}
                </span>
                    </h2>

                    <p class="text-neutral-300 text-sm sm:text-base leading-relaxed">
                        {{__t('text.frontend.how_it_works_alerta_analitica', 'What happens when an Analytical Alert is triggered? Our servers scan the global market and performance variables 24/7. The exact second we detect a mathematical inefficiency, the system processes the play and immediately updates your terminal so you can be the first to capitalize on it.')}}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="flex items-start gap-3 bg-neutral-900/50 p-4 rounded-xl border border-neutral-800">
                            <div class="text-lime-400 mt-1"><i data-lucide="check-circle-2" class="w-4 h-4"></i></div>
                            <p class="text-xs sm:text-sm text-neutral-300"><strong class="text-white">{{__t('text.frontend.how_it_works_execution_speed', 'Execution speed')}}</strong>
                                {{__t('text.frontend.how_it_works_execution_speed_description', 'WebSocket connectivity to receive information instantly, without reloading the screen.')}}
                            </p>
                        </div>
                        <div class="flex items-start gap-3 bg-neutral-900/50 p-4 rounded-xl border border-neutral-800">
                            <div class="text-lime-400 mt-1"><i data-lucide="check-circle-2" class="w-4 h-4"></i></div>
                            <p class="text-xs sm:text-sm text-neutral-300"><strong class="text-white">{{__t('text.frontend.how_it_works_clean_data', 'Clean data, higher profits:')}}</strong>
                                {{__t('text.frontend.how_it_works_clean_data_description', 'We filter out 98% of the statistical noise to deliver pure, direct value to you.')}}
                            </p>
                        </div>
                    </div>

                    <!-- Llamado a la acción comercial opcional integrado -->
                    <div class="pt-2">
                        <p class="text-xs sm:text-sm text-lime-400 font-semibold">
                            🚀 {{__t('text.frontend.how_it_works_stop_betting_on_instinct', 'Stop betting on instinct. Use our terminal to hunt down the best opportunities before bookmakers adjust the lines, and always stay one step ahead.')}}
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