@extends('layouts.frontend.heard')

@section('content')
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- SECTION TITLE -->
        <section class="mb-12 text-center md:text-left">
            <div class="bg-neutral-900/30 p-8 rounded-2xl border border-neutral-800/80 backdrop-blur-sm relative overflow-hidden">
                <div class="absolute inset-0 opacity-[0.01]"
                     style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'0 0 20 20\'%3E%3Cg fill=\'%23a3e635\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 0h20L0 20z\'/%3E%3C/g%3E%3C/svg%3E');"></div>

                <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">// {{__t('text.frontend.questions_tactical_knowledge_support', 'Tactical Knowledge Support')}}</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tighter text-white uppercase">
                    {{__t('text.frontend.questions_resolution', 'Resolution of')}} <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-400">{{__t('text.frontend.questions_conflictos_faq', 'Conflicts & FAQ')}}</span>
                </h1>
                <p class="text-neutral-400 text-sm mt-1">{{__t('text.frontend.questions_clear_up_your_doubts', 'Clear up any methodological questions regarding algorithmic flows and the operation of the terminal.')}}</p>
            </div>
        </section>

        <!-- FAQ ACCORDION SECTION -->
        <section class="space-y-4 mb-16">


            @foreach($faqs AS $item)
                <details class="group bg-neutral-900/20 border border-neutral-800/80 rounded-xl transition-all duration-300">
                    <summary class="flex justify-between items-center p-6 cursor-pointer select-none list-none">
                        <h3 class="text-sm sm:text-base font-bold text-white uppercase tracking-tight font-sans pr-4">
                            {{$item->question}}
                        </h3>
                        <span class="text-neutral-500 group-open:rotate-180 transition-transform duration-300 shrink-0">
                        <i data-lucide="chevron-down" class="w-5 h-5 text-lime-400"></i>
                    </span>
                    </summary>
                    <div class="px-6 pb-6 border-t border-neutral-800/40 pt-4 text-xs sm:text-sm text-neutral-400 font-mono leading-relaxed space-y-2">
                        {!! $item->answer !!}
                    </div>
                </details>
            @endforeach

        </section>

        <!-- NEED MORE HELP? -->
        <section class="max-w-2xl mx-auto bg-neutral-900/10 border border-neutral-800/60 rounded-2xl p-6 text-center">
            <div class="w-10 h-10 rounded-xl bg-neutral-950 border border-neutral-800 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="help-circle" class="w-5 h-5 text-lime-400"></i>
            </div>
            <h4 class="text-sm font-bold text-white uppercase mb-1">{{__t('text.frontend.questions_you_havent_found_the_answer', "Haven't you found the answer you were looking for?")}}</h4>
            <p class="text-neutral-500 font-mono text-xs mb-4">{{__t('text.frontend.questions_open_a_ticket', "Open a ticket directly with our on-call analytical technical support team.")}}</p>
            <a href="{{route('show.comments')}}" class="inline-flex items-center gap-2 bg-neutral-900 border border-neutral-800 hover:border-neutral-700 text-white font-bold font-mono uppercase text-[10px] px-4 py-2 rounded-lg transition-all tracking-wider">
                // {{__t('text.frontend.questions_contact_the_help_desk', "Contact the help desk")}} &rarr;
            </a>
        </section>

    </main>
@endsection