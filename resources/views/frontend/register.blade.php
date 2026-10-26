@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.menu_sign_up', 'Sign up'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-xl">

            <!-- CONTENEDOR CENTRAL -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado -->
                <div class="mb-6 text-center">
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.register_subcription', 'SUBCRIPTION')}}</span>
                    <h1 class="text-2xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.register_customer_resgistration', 'Customer registration')}}</h1>
                </div>

                <div class="tbh-notice mb-6">
                    <i data-lucide="mail-check" class="w-4 h-4 mt-0.5 shrink-0"></i>
                    <p>{{__t('text.frontend.register_customer_resgistration_title', 'Upon registering, please check your email (Inbox or Spam folder) and click the confirmation link to activate your access to the system.')}}</p>
                </div>

                <form id="register" class="space-y-6" novalidate>

                    <div class="space-y-4">
                        <x-web.input name="email" type="email" icon="mail" :label="__t('text.backend.forms.email', 'Email')"
                                     placeholder="customer@gmail.com" required autocomplete="email" inputmode="email" autocapitalize="off" spellcheck="false" maxlength="191"/>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-web.input name="password" type="password" icon="lock" :label="__t('text.backend.forms.password', 'Password')"
                                         placeholder="••••••••" required autocomplete="new-password" minlength="8">
                                {{-- Medidor de seguridad --}}
                                <div class="space-y-1" aria-live="polite">
                                    <div id="pw-strength" class="tbh-strength" data-level="0"><span></span><span></span><span></span><span></span></div>
                                    <p class="tbh-field-hint">
                                        {{ __t('text.frontend.ux.pw_strength_label') }}: <span id="pw-strength-text">—</span>
                                    </p>
                                </div>
                            </x-web.input>

                            <x-web.input name="password_confirmation" type="password" icon="lock" :label="__t('text.backend.forms.password_confirm', 'Confirm Password')"
                                         placeholder="••••••••" required autocomplete="new-password">
                                <p id="pw-match" class="text-xs text-lime-400 items-center gap-1 hidden" aria-live="polite">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> {{ __t('text.frontend.ux.pw_match_ok') }}
                                </p>
                            </x-web.input>
                        </div>

                        <p class="tbh-field-hint">{{ __t('text.frontend.ux.pw_hint') }}</p>
                    </div>

                    <!-- Términos -->
                    <div data-field class="space-y-1.5">
                        <label class="tbh-field-box flex items-start gap-3 cursor-pointer select-none rounded-lg border border-transparent p-1">
                            <input type="checkbox" name="the_terms" id="the_terms" required value="1"
                                   class="rounded bg-neutral-900 border-neutral-800 w-4 h-4 cursor-pointer accent-lime-400 mt-0.5">
                            <span class="text-xs text-neutral-300 leading-normal">
                                {{__t('text.frontend.register_customer_title_terms_and_conditions', 'I confirm that I understand the stochastic nature of data analysis and accept the')}}
                                @if($terms)
                                    <button type="button" data-open-terms class="text-white underline hover:text-lime-400 cursor-pointer">{{__t('text.frontend.footer_terms_and_conditions', 'Terms and Conditions')}}</button>.
                                @else
                                    <a href="{{route('show.terms-and-conditions')}}" target="_blank" class="text-white underline hover:text-lime-400">{{__t('text.frontend.footer_terms_and_conditions', 'Terms and Conditions')}}</a>.
                                @endif
                            </span>
                        </label>
                        <p data-error class="tbh-field-error" aria-live="polite" hidden></p>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-4 rounded-xl transition-all font-sans cursor-pointer">
                        {{__t('text.frontend.menu_sign_up', 'Sign up')}}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <span class="text-sm text-neutral-400"> {{__t('text.frontend.register_customer_do_you_already_have_an_account', 'Do you already have an account?')}}
                        <a href="{{route('show.login-customer')}}" class="text-lime-400 font-semibold hover:underline">{{__t('text.frontend.register_customer_access_here', 'Access here')}}</a>
                    </span>
                </div>
            </div>

        </div>
    </main>

    @if($terms)
        {{-- Términos en modal: se leen sin perder lo escrito en el formulario --}}
        <dialog id="terms-dialog" class="tbh-dialog m-auto w-[calc(100%-2rem)] max-w-2xl rounded-2xl border border-neutral-800 bg-[#0a0a0a] p-0 text-neutral-300" aria-labelledby="terms-title">
            <div class="flex items-center justify-between border-b border-neutral-800 px-6 py-4">
                <h2 id="terms-title" class="text-sm font-bold uppercase tracking-widest text-white">{{ $terms->title ?? __t('text.frontend.footer_terms_and_conditions', 'Terms and Conditions') }}</h2>
                <button type="button" data-close-terms class="text-neutral-500 hover:text-white" aria-label="{{ __t('text.frontend.ux.close') }}">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="tbh-prose max-h-[60vh] overflow-y-auto px-6 py-4 text-sm leading-relaxed">
                {!! $terms->body !!}
            </div>
            <div class="flex justify-end gap-3 border-t border-neutral-800 px-6 py-4">
                <button type="button" data-close-terms class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider border border-neutral-700 text-neutral-300 hover:text-white cursor-pointer">{{ __t('text.frontend.ux.close') }}</button>
                <button type="button" data-accept-terms class="btn-neon px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider cursor-pointer">{{ __t('text.frontend.ux.accept_terms') }}</button>
            </div>
        </dialog>
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var form = document.getElementById('register');
            var button = form.querySelector('button[type="submit"]');
            var strengthBar = document.getElementById('pw-strength');
            var strengthText = document.getElementById('pw-strength-text');
            var matchText = document.getElementById('pw-match');
            var levels = {{ \Illuminate\Support\Js::from([
                __t('text.frontend.ux.pw_weak'), __t('text.frontend.ux.pw_weak'), __t('text.frontend.ux.pw_fair'),
                __t('text.frontend.ux.pw_good'), __t('text.frontend.ux.pw_strong'),
            ]) }};

            // 0-4: longitud mínima + variedad de caracteres
            function strength(value) {
                if (!value) return 0;
                var score = value.length >= 8 ? 1 : 0;
                if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
                if (/\d/.test(value)) score++;
                if (/[^A-Za-z0-9]/.test(value) || value.length >= 14) score++;
                return Math.max(1, Math.min(4, score));
            }

            function refreshPasswordHints() {
                var level = strength(form.password.value);
                strengthBar.dataset.level = level;
                strengthText.textContent = form.password.value ? levels[level] : '—';

                var matches = form.password_confirmation.value !== '' && form.password.value === form.password_confirmation.value;
                matchText.classList.toggle('hidden', !matches);
                matchText.classList.toggle('flex', matches);
            }

            form.password.addEventListener('input', refreshPasswordHints);
            form.password_confirmation.addEventListener('input', refreshPasswordHints);

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var valid = TBHForm.validate(form, [
                    {name: 'email', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'email', test: TBHForm.rules.email, message: TBH_I18N.email},
                    {name: 'password', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'password', test: function (i) { return TBHForm.rules.min(i, 8); }, message: TBH_I18N.password_min},
                    {name: 'password_confirmation', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'password_confirmation', test: function (i) { return i.value === form.password.value; }, message: TBH_I18N.password_match},
                    {name: 'the_terms', test: TBHForm.rules.required, message: TBH_I18N.terms},
                ]);
                if (!valid) return;

                var formData = new FormData(form);
                formData.append("source", "backend");

                TBHForm.loading(button, true, @json(__t('text.frontend.ux.registering')));

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
                        if (response.status === 'success') {
                            window.location.href = response.redirect || "{{ route('show.login-customer') }}";
                            return;
                        }

                        TBHForm.loading(button, false);
                        toastr.error(response.message);
                    },
                    error: function (xhr) {
                        TBHForm.loading(button, false);
                        TBHForm.serverErrors(form, xhr);
                    }
                });
            });

            // Modal de términos
            var dialog = document.getElementById('terms-dialog');
            if (dialog && dialog.showModal) {
                document.querySelectorAll('[data-open-terms]').forEach(function (btn) {
                    btn.addEventListener('click', function () { dialog.showModal(); });
                });
                dialog.querySelectorAll('[data-close-terms]').forEach(function (btn) {
                    btn.addEventListener('click', function () { dialog.close(); });
                });
                dialog.querySelector('[data-accept-terms]').addEventListener('click', function () {
                    form.the_terms.checked = true;
                    form.the_terms.dispatchEvent(new Event('change', {bubbles: true}));
                    dialog.close();
                });
                // Clic en el fondo cierra el modal
                dialog.addEventListener('click', function (e) { if (e.target === dialog) dialog.close(); });
            }
        });
    </script>
@endsection
