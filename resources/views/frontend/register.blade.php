@extends('layouts.frontend.heard')

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-xl">

            <!-- CONTENEDOR CENTRAL -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado -->
                <div class="mb-8 text-center">
                    <span class="text-[10px] font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.register_subcription', 'SUBCRIPTION')}}</span>
                    <h1 class="text-2xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.register_customer_resgistration', 'Customer registration')}}</h1>
                    <p class="text-neutral-400 text-xs mt-2" style="color: yellow; font-size: 15px;"><b>{{__t('text.frontend.register_customer_resgistration_title', 'Upon registering, please check your email (Inbox or Spam folder) and click the confirmation link to activate your access to the system.')}}</b></p>
                </div>

                <form id="register" class="space-y-6" novalidate>
                  
                    <!-- SECCIÓN: CREDENCIALES DE ACCESO -->
                    <div class="space-y-4">

                        <!-- Fila Nombre y Usuario -->
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="space-y-1.5">
                                <label for="email" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block"> {{__t('text.backend.forms.email', 'Email')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <input type="email" id="email" name="email" placeholder="customer@gmail.com" required class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono">
                                </div>
                            </div>
                        </div>

                        <!-- Fila Contraseñas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="password" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.backend.forms.password', 'Password')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <input type="password" id="password" name="password" placeholder="••••••••" required class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono tracking-widest">
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.backend.forms.password_confirm', 'Confirm Password')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required
                                           class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono tracking-widest">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CLÁUSULAS & CHECKBOXES -->
                    <div class="space-y-3 pt-1">
                        <label class="flex items-start gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="the_terms" id="the_terms" required class="rounded bg-neutral-900 border-neutral-800 text-lime-400 focus:ring-0 focus:ring-offset-0 w-4 h-4 cursor-pointer accent-lime-400 mt-0.5" value="1">
                            <span class="text-[11px] text-neutral-400 font-mono leading-normal">
                                {{__t('text.frontend.register_customer_title_terms_and_conditions', 'I confirm that I understand the stochastic nature of data analysis and accept the')}}  <a href="{{route('show.terms-and-conditions')}}" class="text-white underline
                                hover:text-lime-400">
                                    {{__t('text.frontend.footer_terms_and_conditions', 'Terms and Conditions')}}
                                </a>.
                            </span>
                        </label>
                    </div>

                    <div id="loading_form" class="loading-container" style="display: none;">
                        <div class="spinner"></div>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-4 rounded-xl transition-all font-sans">
                        {{__t('text.frontend.menu_sign_up', 'Sign up')}}
                    </button>
                </form>

                <!-- Separador estético opcional -->
                <div class="mt-6 text-center">
                    <span class="text-[10px] font-mono text-neutral-600"> {{__t('text.frontend.register_customer_do_you_already_have_an_account', 'Do you already have an account?')}}
                        <a href="{{route('show.login-customer')}}" class="text-lime-400 hover:underline">{{__t('text.frontend.register_customer_access_here', 'Access here')}}</a>
                    </span>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#register').on('submit', function (event) {
                event.preventDefault();
                var form = this;

                // --- Validación manual con toastr ---
                var errors = [];

                var email = form.email.value.trim();
                if (!email) {
                    errors.push('Email is required');
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push('Enter a valid email');
                }

                if (!form.password.value) {
                    errors.push('Password is required');
                } else if (form.password.value.length < 8) {
                    errors.push('Password must be at least 8 characters');
                }

                if (!form.password_confirmation.value) {
                    errors.push('Password confirmation is required');
                } else if (form.password.value !== form.password_confirmation.value) {
                    errors.push('Passwords do not match');
                }

                if (!form.the_terms.checked) {
                    errors.push('You must accept the Terms and Conditions');
                }

                if (errors.length > 0) {
                    // Muestra solo el primer error (más limpio en móvil)
                    toastr.error(errors[0]);
                    return false;

                    // Si prefieres mostrar TODOS, comenta la línea de arriba y usa:
                    // errors.forEach(function (msg) { toastr.error(msg); });
                }

                // --- Todo OK → AJAX ---
                var formData = new FormData(form);
                formData.append("source", "backend");

                $('#loading_form').css('display', 'flex');
                $('#register button[type="submit"]').prop('disabled', true);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{ route('store.register') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    success: function (response) {
                        $('#loading_form').hide();
                        $('#register button[type="submit"]').prop('disabled', false);

                        if (response.status === 'success') {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = "{{ route('show.login-customer') }}";
                            }, 2000);
                        }
                        if (response.status === 'fail') {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loading_form').hide();
                        $('#register button[type="submit"]').prop('disabled', false);

                        // Si Laravel devuelve errores de validación (422)
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
    </script>
@endsection