@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.ux.reset_title'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-md">
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md shadow-2xl">

                <div class="mb-6 text-center">
                    <div class="mx-auto mb-4 w-12 h-12 rounded-xl bg-lime-400/10 border border-lime-400/30 flex items-center justify-center text-lime-400">
                        <i data-lucide="lock-keyhole" class="w-6 h-6"></i>
                    </div>
                    <h1 class="text-xl font-black text-white uppercase tracking-tight">{{ __t('text.frontend.ux.reset_title') }}</h1>
                    <p class="text-neutral-400 text-sm mt-2">{{ __t('text.frontend.ux.reset_text') }}</p>
                </div>

                <form id="reset" method="POST" action="{{ route('password.update') }}" class="space-y-4" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <x-web.input name="email" type="email" icon="mail" :label="__t('text.backend.forms.email', 'Email')" :value="$email ?? old('email')"
                                 required autocomplete="email" inputmode="email" autocapitalize="off" readonly/>

                    <x-web.input name="password" type="password" icon="lock" :label="__t('text.backend.customer.new_password')"
                                 :hint="__t('text.frontend.ux.pw_hint')" required autofocus autocomplete="new-password" minlength="8"/>

                    <x-web.input name="password_confirmation" type="password" icon="lock" :label="__t('text.backend.customer.confirm_password')"
                                 required autocomplete="new-password"/>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-3.5 rounded-xl cursor-pointer">
                        <i data-lucide="check" class="w-4 h-4"></i> {{ __t('text.frontend.ux.reset_cta') }}
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        document.getElementById('reset').addEventListener('submit', function (event) {
            var form = this;
            var valid = TBHForm.validate(form, [
                {name: 'password', test: function (i) { return TBHForm.rules.min(i, 8); }, message: TBH_I18N.password_min},
                {name: 'password_confirmation', test: function (i) { return i.value === form.password.value; }, message: TBH_I18N.password_match},
            ]);
            if (!valid) {
                event.preventDefault();
                return;
            }
            TBHForm.loading(form.querySelector('button[type="submit"]'), true, @json(__t('text.frontend.ux.saving')));
        });
    </script>
@endsection
