{{-- Testimonios: comentarios que el admin publicó desde Contenido Web > Comentarios. Recibe $testimonials --}}
@if(isset($testimonials) && $testimonials->isNotEmpty())
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12" data-reveal>
                <span class="text-xs font-bold uppercase tracking-widest text-lime-400 block mb-2">{{ __t('text.frontend.ux.testimonials_kicker') }}</span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white uppercase">{{ __t('text.frontend.ux.testimonials_title') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($testimonials as $testimonial)
                    @php
                        // Solo nombre e inicial del apellido: no se publica el nombre completo del cliente
                        $parts = preg_split('/\s+/', trim((string)$testimonial->full_name));
                        $name  = mb_convert_case($parts[0] ?? '', MB_CASE_TITLE) . (isset($parts[1]) ? ' ' . mb_strtoupper(mb_substr($parts[1], 0, 1)) . '.' : '');
                    @endphp
                    <figure class="flex flex-col rounded-2xl border border-neutral-800 bg-neutral-950/70 p-6" data-reveal>
                        <i data-lucide="quote" class="w-6 h-6 text-lime-400/70 mb-3"></i>
                        <blockquote class="flex-1 text-sm leading-relaxed text-neutral-200">
                            “{{ \Illuminate\Support\Str::limit(trim((string)$testimonial->comment), 280) }}”
                        </blockquote>
                        <figcaption class="mt-5 flex items-center gap-3">
                            <span class="w-9 h-9 rounded-full bg-lime-400/10 border border-lime-400/30 text-lime-300 font-bold flex items-center justify-center">
                                {{ mb_strtoupper(mb_substr($name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-semibold text-white">{{ $name }}</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('show.comments') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-lime-400 hover:underline">
                    <i data-lucide="message-square-plus" class="w-4 h-4"></i> {{ __t('text.frontend.ux.testimonials_cta') }}
                </a>
            </div>
        </div>
    </section>
@endif
