<!-- Modal Suscripción -->
<div id="modal" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center hidden">
    <div class="bg-[#0a0a0a] border border-neutral-800 rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-white">🎯 Pick Gratis</h3>
            <button onclick="cerrarModal()" class="text-neutral-500 hover:text-white">✕</button>
        </div>


        <form id="frm-suscription" class="space-y-3" novalidate>
            @csrf
            <input type="text" id="full_name" name="full_name" placeholder="{{__t('text.frontend.footer_full_name','Full Name')}}" required
                   class="w-full px-4 py-2.5 bg-black/50 border border-neutral-700 rounded-lg text-white text-sm focus:border-orange-500 focus:outline-none">

            <input type="email" id="email" name="email" placeholder="{{__t('text.frontend.footer_email','Email')}}" required
                   class="w-full px-4 py-2.5 bg-black/50 border border-neutral-700 rounded-lg text-white text-sm focus:border-orange-500 focus:outline-none">

            <div id="loading_form" class="loading-container" style="display: none;">
                <div class="spinner"></div>
            </div>

            <button type="submit" id="btnSubmit" style="cursor: pointer" class="w-full py-2.5 font-bold text-sm text-white bg-gradient-to-r from-pink-500 to-orange-500 rounded-lg hover:opacity-90 transition flex items-center justify-center gap-2">
                <span id="btnText">{{__t('text.frontend.footer_subscribe', 'Subscribe')}}</span>
                <!-- Spinner oculto por defecto con Tailwind -->
                <svg id="loadingSpinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>

        </form>

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
                    <a id="btnSuscribir" style="cursor: pointer"
                       class="inline-flex items-center gap-2 font-bold uppercase tracking-wider text-xs px-6 py-3.5 rounded-full text-white bg-gradient-to-r from-pink-500 to-orange-500 shadow-[0_0_20px_rgba(239,68,68,0.3)]hover:shadow-[0_0_35px_rgba(249,115,22,0.6)] hover:opacity-95 transition-all duration-300">
                        {{__t('text.frontend.footer_subscribe', 'Subscribe')}}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Divisor de base y marca registrada -->
        <div class="border-t border-neutral-900 pt-8 mt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] text-neutral-600 tracking-wide text-center sm:text-left gap-4">
            <p class="font-bold text-neutral-500 uppercase tracking-widest">LA MANO NEGRA - SPORT INSIGHTS</p>
            <p>&copy; 2026 La Mano Negra. {{__t('text.frontend.footer_all_rights_reserved', 'All rights reserved.')}}</p>
        </div>

    </div>
</footer>

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            // Abrir modal al hacer clic en el botón del footer
            $('#btnSuscribir').on('click', function (e) {
                e.preventDefault(); // Evita comportamientos por defecto si es un enlace
                $('#modal').removeClass('hidden');
            });

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