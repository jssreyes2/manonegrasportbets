@extends('layouts.frontend.heard')

@section('title', __t('text.frontend.footer_comments', 'Comments'))

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-xl">

            <!-- CONTENEDOR CENTRAL -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado -->
                <div class="mb-6 text-center">
                    <span class="text-xs font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.footer_comments', 'COMMENTS')}}</span>
                    <h1 class="text-2xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.comments_opinion', 'Your opinion matters to us!')}}</h1>
                    <p class="text-neutral-300 text-sm mt-2">{{__t('text.frontend.comments_share_your_experience', 'Share your experience with us and help us improve every day.')}}</p>
                </div>

                {{-- id distinto al del textarea: antes ambos eran "comment" --}}
                <form id="comment-form" class="space-y-4" novalidate>
                    <x-web.input name="full_name" icon="user" :label="__t('text.frontend.footer_full_name', 'Full Name')"
                                 :value="auth()->user()?->profile ? trim(auth()->user()->profile->first_name . ' ' . auth()->user()->profile->last_name) : null"
                                 required autocomplete="name" maxlength="100"/>

                    <x-web.input name="email" type="email" icon="mail" :label="__t('text.frontend.footer_email', 'Email')" :value="auth()->user()?->email"
                                 placeholder="customer@gmail.com" required autocomplete="email" inputmode="email" autocapitalize="off" spellcheck="false"
                                 :hint="__t('text.frontend.comments_text_valid_email', 'Your email address must be valid so that we can send you a reply. Thank you for choosing us.')"/>

                    <div class="space-y-1.5" data-field>
                        <label for="subject" class="tbh-label">{{ __t('text.frontend.ux.subject_label') }}</label>
                        <div class="tbh-field-box relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3.5 py-3 transition-all neon-border-focus">
                            <i data-lucide="tag" class="w-4 h-4 text-neutral-500 shrink-0 mr-3" aria-hidden="true"></i>
                            <select id="subject" name="subject" class="w-full bg-transparent text-sm text-white focus:outline-none [&>option]:bg-neutral-900">
                                @foreach(\App\Models\Comment::SUBJECTS as $subject)
                                    <option value="{{ $subject }}">{{ __t('text.frontend.ux.subject_' . $subject) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p data-error class="tbh-field-error" aria-live="polite" hidden></p>
                    </div>

                    <div class="space-y-1.5" data-field>
                        <div class="flex items-center justify-between">
                            <label for="comment" class="tbh-label">{{__t('text.frontend.footer_comments', 'COMMENTS')}}</label>
                            <span id="comment-count" class="text-xs text-neutral-500 tabular-nums" aria-live="polite">0/{{ \App\Models\Comment::MAX_LENGTH }}</span>
                        </div>
                        <div class="tbh-field-box relative bg-black/60 border border-neutral-800 rounded-xl flex px-3.5 py-3 transition-all neon-border-focus">
                            <textarea id="comment" name="comment" rows="6" required maxlength="{{ \App\Models\Comment::MAX_LENGTH }}"
                                      placeholder="{{ __t('text.frontend.ux.comment_placeholder') }}"
                                      class="w-full bg-transparent text-sm text-white placeholder-neutral-600 focus:outline-none resize-y"></textarea>
                        </div>
                        <p data-error class="tbh-field-error" aria-live="polite" hidden></p>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-4 rounded-xl transition-all font-sans cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4"></i> {{__t('text.frontend.comments_form_button', 'Comment')}}
                    </button>
                </form>

            </div>

        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var form = document.getElementById('comment-form');
            var button = form.querySelector('button[type="submit"]');
            var counter = document.getElementById('comment-count');
            var max = {{ \App\Models\Comment::MAX_LENGTH }};

            form.comment.addEventListener('input', function () {
                var length = this.value.length;
                counter.textContent = length + '/' + max;
                counter.classList.toggle('text-amber-400', length > max * 0.9);
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var valid = TBHForm.validate(form, [
                    {name: 'full_name', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'full_name', test: function (i) { return /^[\p{L}\s]{3,}$/u.test(i.value.trim()); }, message: TBH_I18N.name},
                    {name: 'email', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'email', test: TBHForm.rules.email, message: TBH_I18N.email},
                    {name: 'comment', test: TBHForm.rules.required, message: TBH_I18N.required},
                    {name: 'comment', test: function (i) { return i.value.trim().length >= 10; }, message: TBH_I18N.comment_min},
                ]);
                if (!valid) return;

                TBHForm.loading(button, true, @json(__t('text.frontend.ux.sending')));

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{ route('save.comment') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: new FormData(form),
                    success: function (response) {
                        TBHForm.loading(button, false);

                        if (response.status === 'success') {
                            toastr.success(response.message);
                            form.comment.value = '';
                            counter.textContent = '0/' + max;
                            return;
                        }

                        toastr.error(response.message);
                    },
                    error: function (xhr) {
                        TBHForm.loading(button, false);
                        TBHForm.serverErrors(form, xhr);
                    }
                });
            });
        });
    </script>
@endsection
