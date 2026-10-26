@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.menu_login', 'Login'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-md">

            <!-- CONTENEDOR DEL FORMULARIO -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado del Formulario -->
                <div class="mb-6 text-center">
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.login_customer_authentication', 'AUTHENTICATION')}} </span>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.menu_login', 'Login')}}</h1>
                    <p class="text-neutral-400 text-sm mt-1">{{__t('text.frontend.login_customer_access_credentials', 'Enter your login credentials.')}}</p>
                </div>

                @if(session('status'))
                    <div class="mb-4 flex items-start gap-2 rounded-xl border border-lime-400/30 bg-lime-400/5 p-3 text-sm text-lime-200" role="status">
                        <i data-lucide="check-circle-2" class="w-4 h-4 mt-0.5 shrink-0"></i> {{ session('status') }}
                    </div>
                @endif

                {{-- Aviso de correo sin confirmar: se muestra cuando el login responde unverified --}}
                <div id="unverified-box" class="tbh-notice mb-4" role="alert" hidden>
                    <i data-lucide="mail-warning" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <div class="space-y-2">
                        <p id="unverified-text"></p>
                        <button type="button" id="btn-resend" class="font-bold underline hover:text-white">
                            {{ __t('text.frontend.ux.resend_verification') }}
                        </button>
                    </div>
                </div>

                <form id="login" class="space-y-4" novalidate>
                    <x-web.input name="email" type="email" icon="user" :label="__t('text.backend.forms.email', 'Email')"
                                 placeholder="user@gmail.com" required autocomplete="email" inputmode="email" autocapitalize="off" spellcheck="false"/>

                    <div>
                        <x-web.input name="password" type="password" icon="lock" :label="__t('text.backend.forms.password', 'Password')"
                                     placeholder="••••••••" required autocomplete="current-password"/>
                        <div class="mt-2 text-right">
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-lime-400 hover:underline">
                                {{ __t('text.frontend.ux.forgot_password') }}
                            </a>
                        </div>
                    </div>

                    <!-- Botón de Envío -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl transition-all font-sans mt-2 cursor-pointer">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> {{__t('text.frontend.login_customer_authenticate', 'Authenticate and Access')}}
                    </button>
                </form>

                <!-- Separador -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="border-t border-neutral-800/80 w-full"></div>
                    <span class="absolute bg-[#0b0b0b] px-3 text-xs text-neutral-500 uppercase tracking-widest">{{ __t('text.frontend.ux.or') }}</span>
                </div>

                <!-- Enlace para Nuevos Registros -->
                <div class="text-center">
                    <p class="text-sm text-neutral-400">
                        {{__t('text.frontend.login_customer_you_have_an_account', "Don't you have an account?")}}
                        <a href="{{route('show.register')}}" class="text-lime-400 font-bold hover:underline block sm:inline sm:ml-1 uppercase tracking-tight text-xs font-sans">
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
            var form = document.getElementById('login');
            var button = form.querySelector('button[type="submit"]');
            var unverifiedBox = document.getElementById('unverified-box');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                unverifiedBox.hidden = true;

                var valid = TBHForm.validate(form, [
                    {name: 'email', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'email', test: TBHForm.rules.email, message: TBH_I18N.email},
                    {name: 'password', test: TBHForm.rules.required, message: TBH_I18N.required},
                ]);
                if (!valid) return;

                var formData = new FormData(form);
                formData.append("source", "web");
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                TBHForm.loading(button, true, @json(__t('text.frontend.ux.signing_in')));

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
                            window.location.href = response.redirect || "{{ route('customer.home') }}";
                            return;
                        }

                        TBHForm.loading(button, false);

                        // Demasiados intentos: el servidor responde error_time
                        if (response.error_time) {
                            toastr.error(@json(__t('text.frontend.ux.too_many_attempts')));
                            return;
                        }

                        // Correo sin confirmar: se ofrece reenviar el enlace, sin perder lo escrito
                        if (response.unverified) {
                            document.getElementById('unverified-text').textContent = response.message;
                            unverifiedBox.hidden = false;
                            return;
                        }

                        TBHForm.error(form.password, response.message);
                        form.password.select();
                    },
                    error: function (xhr) {
                        TBHForm.loading(button, false);
                        TBHForm.serverErrors(form, xhr);
                    }
                });
            });

            document.getElementById('btn-resend').addEventListener('click', function () {
                var resendButton = this;
                TBHForm.loading(resendButton, true, @json(__t('text.frontend.ux.sending')));

                $.ajax({
                    type: "POST",
                    url: "{{ route('resend.verification') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {email: form.email.value.trim()},
                    dataType: 'json',
                    success: function (response) {
                        TBHForm.loading(resendButton, false);
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        TBHForm.loading(resendButton, false);
                        toastr.error(xhr.status === 429 ? @json(__t('text.frontend.ux.too_many_attempts')) : ((xhr.responseJSON && xhr.responseJSON.message) || TBH_I18N.unexpected));
                    }
                });
            });
        });
    </script>
@endsection
