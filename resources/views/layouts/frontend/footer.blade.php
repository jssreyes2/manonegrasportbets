<!-- Modal Suscripción -->
<div id="modal" class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-md flex items-center justify-center hidden" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="relative bg-[#0a0a0a] border border-lime-400/30 rounded-2xl p-6 sm:p-7 w-full max-w-sm mx-4 shadow-[0_0_60px_rgba(163,230,53,0.15)]">
        <button type="button" onclick="cerrarModal()" class="absolute top-4 right-4 text-neutral-500 hover:text-white" aria-label="Close">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        <div class="w-12 h-12 rounded-xl bg-lime-400/10 border border-lime-400/30 flex items-center justify-center text-lime-400 mb-4">
            <i data-lucide="gift" class="w-6 h-6"></i>
        </div>
        <h3 id="modal-title" class="text-xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.landing.modal_title')}}</h3>
        <p class="text-sm text-neutral-400 mt-1 mb-5">{{__t('text.frontend.landing.modal_text')}}</p>

        <form id="frm-suscription" class="space-y-3" novalidate>
            @csrf
            <input type="text" id="full_name" name="full_name" placeholder="{{__t('text.frontend.footer_full_name','Full Name')}}" required
                   class="w-full px-4 py-2.5 bg-black/50 border border-neutral-700 rounded-lg text-white text-sm focus:border-lime-400 focus:outline-none">

            <input type="email" id="email" name="email" placeholder="{{__t('text.frontend.footer_email','Email')}}" required
                   class="w-full px-4 py-2.5 bg-black/50 border border-neutral-700 rounded-lg text-white text-sm focus:border-lime-400 focus:outline-none">

            <div id="loading_form" class="loading-container" style="display: none;">
                <div class="spinner"></div>
            </div>

            <button type="submit" id="btnSubmit" style="cursor: pointer" class="w-full py-3 font-bold text-sm uppercase tracking-wider btn-neon rounded-lg transition flex items-center justify-center gap-2">
                <span id="btnText">{{__t('text.frontend.footer_subscribe', 'Subscribe')}}</span>
                <!-- Spinner oculto por defecto con Tailwind -->
                <svg id="loadingSpinner" class="animate-spin h-5 w-5 text-black hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>

        </form>

        <ul class="mt-4 flex flex-wrap justify-center gap-x-4 gap-y-1 text-[11px] text-neutral-500">
            <li class="flex items-center gap-1"><i data-lucide="check" class="w-3 h-3 text-lime-400"></i>{{__t('text.frontend.landing.free_b1')}}</li>
            <li class="flex items-center gap-1"><i data-lucide="check" class="w-3 h-3 text-lime-400"></i>{{__t('text.frontend.landing.free_b2')}}</li>
        </ul>
    </div>
</div>


<footer class="border-t border-neutral-900 bg-[#050505] pt-16 pb-12 text-sm text-neutral-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Grid del Footer -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-12">

            <!-- Columna 1: Branding, Copete Analítico y Redes Sociales Neón -->
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" alt="La Mano Negra" style="height: 50px; width: 50px;">
                    <span class="text-lg font-black tracking-widest text-white">LA MANO NEGRA</span>
                </div>
                <p class="text-xs text-neutral-400 leading-relaxed max-w-sm">
                    {{__t('text.frontend.footer_anticipate_every_move','Stay ahead of every play. We offer our community expert analysis, exclusive information, and predictions backed by solid data.')}}
                </p>

                <!-- Contenedor de Redes Sociales con efecto de brillo -->
                <div class="flex items-center gap-4 pt-2">
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/manonegrasportbets?igsh=dW5pemYybjlwZmJu" target="_blank" rel="La Mano Negra"
                       class="w-10 h-10 rounded-full bg-black border border-red-500/30 flex items-center justify-center text-red-500 shadow-[0_0_15px_rgba(239,68,68,0.2)] hover:shadow-[0_0_25px_rgba(239,68,68,0.5)] hover:border-red-400 hover:text-red-400 transition-all duration-300">
                        <img src="{{ asset('img/instagram.png') }}" alt="La Mano Negra">
                    </a>
                </div>
            </div>

            <!-- Columna 2: Empresa -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white">{{__t('text.frontend.footer_company','Company')}}</h4>
                <ul class="space-y-2.5 text-xs font-semibold">
                    <li><a href="{{route('show.terms-and-conditions')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.footer_terms_and_conditions','Terms and Conditions')}}</a></li>
                    <li><a href="{{route('show.who-we-are')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.menu_about_us','About Us')}}</a></li>
                    <li><a href="{{route('show.frequently-asked-questions')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.footer_questions','Frequently Asked Questions')}}</a></li>
                    <li><a href="{{route('show.sports-news')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.footer_sports_news','Sports News')}} </a></li>
                </ul>
            </div>

            <!-- Columna 3: Cuenta -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white">{{__t('text.frontend.menu_my_account', 'My Account')}}</h4>
                <ul class="space-y-2.5 text-xs font-semibold">
                    <li><a href="{{route('show.login-customer')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.menu_login', 'Login')}}</a></li>
                    <li><a href="{{route('show.register')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.menu_sign_up', 'Sign up')}}</a></li>
                    <li><a href="{{route('show.comments')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.footer_comments', 'Comments')}}</a></li>
                    <li><a href="{{route('show.plans')}}" class="hover:text-lime-400 transition-colors">{{__t('text.frontend.menu_plans', 'Plans')}}</a></li>
                </ul>
            </div>

            <!-- Columna 4: Suscripción con botón gradiente rosa-naranja -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-white">{{__t('text.frontend.footer_chance', "Don't miss the opportunity.")}}</h4>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    {{__t('text.frontend.footer_your_free_pick', "Subscribe and get your free pick!")}}
                </p>
                <div class="pt-2">
                    <!-- Botón Degradado con sombra neón e icono de flecha -->
                    <a id="btnSuscribir" href="#" data-open-freepick
                       class="btn-neon btn-shine inline-flex items-center gap-2 font-bold uppercase tracking-wider text-xs px-6 py-3.5 rounded-full transition-all duration-300">
                        {{__t('text.frontend.footer_subscribe', 'Subscribe')}}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Juego responsable -->
        <div class="flex items-start gap-3 border border-neutral-900 rounded-xl p-4 text-[11px] leading-relaxed text-neutral-500">
            <span class="shrink-0 w-8 h-8 rounded-full border border-red-500/40 text-red-400 font-black text-[10px] flex items-center justify-center">+18</span>
            <p>{{__t('text.frontend.landing.responsible')}}</p>
        </div>

        <!-- Divisor de base y marca registrada -->
        <div class="border-t border-neutral-900 pt-8 mt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] text-neutral-600 tracking-wide text-center sm:text-left gap-4">
            <p class="font-bold text-neutral-500 uppercase tracking-widest">LA MANO NEGRA - SPORT INSIGHTS</p>
            <p>&copy; {{ date('Y') }} La Mano Negra. {{__t('text.frontend.footer_all_rights_reserved', 'All rights reserved.')}}</p>
        </div>

    </div>
</footer>

<script type="text/javascript">
        $(document).ready(function () {
            $('#frm-suscription').on('submit', function (event) {
                event.preventDefault();
                var form = this;

                // --- Validación manual con toastr ---
                var errors = [];

                var fullName = form.full_name.value.trim();
                if (!fullName) {
                    errors.push('Full name is required');
                } else if (fullName.length < 3) {
                    errors.push('Full name is too short');
                }

                var email = form.email.value.trim();
                if (!email) {
                    errors.push('Email is required');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push('Enter a valid email');
                }

                if (errors.length > 0) {
                    toastr.error(errors[0]);
                    return false;
                }

                // --- UI: mostrar loading y spinner del botón ---
                $('#loading_form').css('display', 'flex');
                $('#btnSubmit').prop('disabled', true);
                $('#btnText').text('...');
                $('#loadingSpinner').removeClass('hidden');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{ route('create-user-suscription') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: new FormData(form),
                    success: function (response) {
                        // Restaurar UI
                        $('#loading_form').hide();
                        $('#btnSubmit').prop('disabled', false);
                        $('#btnText').text("{{__t('text.frontend.footer_subscribe', 'Subscribe')}}");
                        $('#loadingSpinner').addClass('hidden');

                        if (response.status === 'success') {
                            toastr.success(response.message);
                            form.reset();
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Restaurar UI
                        $('#loading_form').hide();
                        $('#btnSubmit').prop('disabled', false);
                        $('#btnText').text("{{__t('text.frontend.footer_subscribe', 'Subscribe')}}");
                        $('#loadingSpinner').addClass('hidden');

                        // Errores 422 de Laravel
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var firstError = Object.values(xhr.responseJSON.errors)[0];
                            toastr.error(Array.isArray(firstError) ? firstError[0] : firstError);
                            return;
                        }

                        if (typeof window.errorHandler === 'function') {
                            window.errorHandler(xhr, status, error);
                        } else {
                            toastr.error('Connection error');
                        }
                    }
                });
            });

        });

        // Función global para cerrar el modal (asociada al botón ✕ dentro del modal)
        function cerrarModal() {
            $('#modal').addClass('hidden');
        }

        // Opcional: Cerrar el modal haciendo clic fuera de la caja de contenido (backdrop)
        $('#modal').on('click', function (e) {
            if ($(e.target).is('#modal')) {
                $(this).addClass('hidden');
            }
        });
    </script>