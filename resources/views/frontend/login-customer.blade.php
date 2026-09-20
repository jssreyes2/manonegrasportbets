@extends('layouts.frontend.heard')

@section('content')
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <!-- CONTENEDOR DEL FORMULARIO -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">
           
                <!-- Encabezado del Formulario -->
                <div class="mb-6 text-center">
                    <span class="text-[10px] font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.login_customer_authentication', 'AUTHENTICATION')}} </span>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.menu_login', 'Login')}}</h1>
                    <p class="text-neutral-400 text-xs mt-1">{{__t('text.frontend.login_customer_access_credentials', 'Enter your login credentials.')}}</p>
                </div>
                

                <form id="login" class="space-y-4" novalidate>
                    <!-- Campo: ID de Operador -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.backend.forms.email', 'Email')}}</label>
                        <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3.5 py-3 transition-all neon-border-focus">
                            <i data-lucide="user" class="w-4 h-4 text-neutral-500 shrink-0 mr-3"></i>
                            <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="user@gmail.com"
                                    required
                                    class="w-full bg-transparent text-sm text-white placeholder-neutral-600 focus:outline-none font-mono"
                            >
                        </div>
                    </div>

                    <!-- Campo: Llave de Seguridad -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.backend.forms.password', 'Password')}}</label>
                        </div>
                        <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3.5 py-3 transition-all neon-border-focus">
                            <i data-lucide="lock" class="w-4 h-4 text-neutral-500 shrink-0 mr-3"></i>
                            <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••••••"
                                    required
                                    class="w-full bg-transparent text-sm text-white placeholder-neutral-600 focus:outline-none font-mono tracking-widest"
                            >
                        </div>
                    </div>

                    <div id="loading_form" class="loading-container" style="display: none;">
                        <div class="spinner"></div>
                    </div>

                    <!-- Botón de Envío -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl transition-all font-sans mt-2">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> {{__t('text.frontend.login_customer_authenticate', 'Authenticate and Access')}}
                    </button>
                </form>

                <!-- Separador Táctico -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="border-t border-neutral-800/80 w-full"></div>
                    <span class="absolute bg-[#0b0b0b] px-3 font-mono text-[9px] text-neutral-600 uppercase tracking-widest">Ó</span>
                </div>

                <!-- Enlace para Nuevos Registros -->
                <div class="text-center">
                    <p class="text-xs text-neutral-400 font-mono">
                        {{__t('text.frontend.login_customer_you_have_an_account', "Don't you have an account?")}}
                        <a href="{{route('show.register')}}" class="text-lime-400 font-bold hover:underline block sm:inline sm:ml-1 uppercase tracking-tight text-[11px] font-sans">
                            {{__t('text.frontend.menu_sign_up', 'Sign up')}} &rarr;
                        </a>
                    </p>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#login').on('submit', function (event) {
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
                }

                if (errors.length > 0) {
                    toastr.error(errors[0]); // o errors.forEach(...) para mostrar todos
                    return false;
                }

                // --- Todo OK → AJAX ---
                var formData = new FormData(form);
                formData.append("source", "web");
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $('#loading_form').css('display', 'flex');
                $('#login button[type="submit"]').prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: "{{ route('verify.authenticate') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#loading_form').hide();
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = "{{ route('subscription') }}";
                            }, 1000);
                        }

                        if (response.status === 'fail') {
                            $('#loading_form').hide();
                            $('#login button[type="submit"]').prop('disabled', false);
                            toastr.error(response.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loading_form').hide();
                        $('#login button[type="submit"]').prop('disabled', false);

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
    </script>
@endsection