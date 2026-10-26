@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.ux.check_title'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-16">
        <div class="w-full max-w-lg">
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-10 backdrop-blur-md shadow-2xl text-center">

                <div class="mx-auto mb-6 w-16 h-16 rounded-2xl bg-lime-400/10 border border-lime-400/30 flex items-center justify-center text-lime-400">
                    <i data-lucide="mail-open" class="w-8 h-8"></i>
                </div>

                <h1 class="text-2xl font-black text-white uppercase tracking-tight">{{ __t('text.frontend.ux.check_title') }}</h1>

                <p class="mt-3 text-neutral-300">
                    @if($email)
                        {!! __t('text.frontend.ux.check_text', null, ['email' => '<strong class="text-white break-all">' . e($email) . '</strong>']) !!}
                    @else
                        {{ __t('text.frontend.ux.check_text_generic') }}
                    @endif
                </p>
                <p class="mt-2 text-sm text-neutral-400">{{ __t('text.frontend.ux.check_spam') }}</p>

                {{-- Accesos directos a los buzones más usados --}}
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="https://mail.google.com/mail/u/0/#search/in%3Aanywhere+la+mano+negra" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-neutral-700 px-4 py-3 text-sm font-semibold text-white hover:border-lime-400 hover:text-lime-300">
                        <i data-lucide="external-link" class="w-4 h-4"></i> {{ __t('text.frontend.ux.open_gmail') }}
                    </a>
                    <a href="https://outlook.live.com/mail/0/" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-neutral-700 px-4 py-3 text-sm font-semibold text-white hover:border-lime-400 hover:text-lime-300">
                        <i data-lucide="external-link" class="w-4 h-4"></i> {{ __t('text.frontend.ux.open_outlook') }}
                    </a>
                </div>

                <form id="resend" class="mt-8 space-y-3 text-left" novalidate>
                    @if($email)
                        <input type="hidden" name="email" value="{{ $email }}">
                    @else
                        <x-web.input name="email" type="email" icon="mail" :label="__t('text.backend.forms.email', 'Email')"
                                     required autocomplete="email" inputmode="email" autocapitalize="off"/>
                    @endif

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4"></i> <span>{{ __t('text.frontend.ux.resend_cta') }}</span>
                    </button>
                </form>

                <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-x-6 gap-y-2 text-sm">
                    <a href="{{ route('show.login-customer') }}" class="text-lime-400 font-semibold hover:underline">{{ __t('text.frontend.ux.back_to_login') }}</a>
                    <a href="{{ route('show.register') }}" class="text-neutral-400 hover:text-white">{{ __t('text.frontend.ux.wrong_email') }}</a>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var form = document.getElementById('resend');
            var button = form.querySelector('button[type="submit"]');
            var waitText = @json(__t('text.frontend.ux.resend_wait'));

            // Evita reenvíos seguidos: el botón espera 60 s tras cada envío
            function cooldown(seconds) {
                var original = button.innerHTML;
                button.disabled = true;
                var timer = setInterval(function () {
                    seconds--;
                    button.innerHTML = '<span>' + waitText.replace(':s', seconds) + '</span>';
                    if (seconds <= 0) {
                        clearInterval(timer);
                        button.disabled = false;
                        button.innerHTML = original;
                    }
                }, 1000);
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                if (form.email.type === 'email') {
                    var valid = TBHForm.validate(form, [
                        {name: 'email', test: TBHForm.rules.required, message: TBH_I18N.required},
                        {name: 'email', test: TBHForm.rules.email, message: TBH_I18N.email},
                    ]);
                    if (!valid) return;
                }

                TBHForm.loading(button, true, @json(__t('text.frontend.ux.sending')));

                $.ajax({
                    type: "POST",
                    url: "{{ route('resend.verification') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {email: form.email.value.trim()},
                    dataType: 'json',
                    success: function (response) {
                        TBHForm.loading(button, false);
                        toastr.success(response.message);
                        cooldown(60);
                    },
                    error: function (xhr) {
                        TBHForm.loading(button, false);
                        if (xhr.status === 429) {
                            toastr.error(@json(__t('text.frontend.ux.too_many_attempts')));
                            return;
                        }
                        TBHForm.serverErrors(form, xhr);
                    }
                });
            });
        });
    </script>
@endsection
