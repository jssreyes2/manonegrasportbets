@extends('layouts.frontend.heard')

@section('content')
    <main class="flex-1 flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-xl">

            <!-- CONTENEDOR CENTRAL -->
            <div class="bg-neutral-900/40 border border-neutral-800/80 rounded-2xl p-6 sm:p-8 backdrop-blur-md relative overflow-hidden shadow-2xl">

                <!-- Encabezado -->
                <div class="mb-8 text-center">
                    <span class="text-[10px] font-mono tracking-widest text-lime-400 uppercase block mb-1">{{__t('text.frontend.footer_comments', 'COMMENTS')}} </span>
                    <h1 class="text-2xl font-black text-white uppercase tracking-tight">{{__t('text.frontend.comments_opinion', 'Your opinion matters to us!')}}</h1>
                    <p class="text-neutral-400 text-xs mt-2" style="color: yellow; font-size: 15px;"><b>{{__t('text.frontend.comments_share_your_experience', 'Share your experience with us and help us improve every day.')}} </b></p>
                </div>

                <form id="comment" class="space-y-6">
                  
                    <!-- SECCIÓN: CREDENCIALES DE ACCESO -->
                    <div class="space-y-4">

                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="space-y-1.5">
                                <label for="full_name" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.frontend.footer_full_name', 'Full Name')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <input type="text" id="full_name" name="full_name" required class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono">
                                </div>
                            </div>
                        </div>

            
                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="space-y-1.5">
                                <label for="email" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.frontend.footer_email', 'Email')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <input type="email" id="email" name="email" placeholder="customer@gmail.com" required class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
                            <div class="space-y-1.5">
                                <label for="comment" class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block">{{__t('text.frontend.footer_comments', 'COMMENTS')}}</label>
                                <div class="relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3 py-2.5 transition-all neon-border-focus">
                                    <textarea id="comment" name="comment" required class="w-full bg-transparent text-sm text-white placeholder-neutral-700 focus:outline-none font-mono" style="height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 pt-1">
                            <label class="flex items-start gap-3 cursor-pointer select-none">
                                <span class="text-[11px] text-neutral-400 font-mono leading-normal">
                               {{__t('text.frontend.comments_text_valid_email', 'Your email address must be valid so that we can send you a reply. Thank you for choosing us.')}}
                            </span>
                            </label>
                        </div>
                    </div>

                    <div id="loading_form" class="loading-container" style="display: none;">
                        <div class="spinner"></div>
                    </div>

                    <!-- BOTÓN DE ACCIÓN -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 btn-neon font-bold uppercase tracking-wider text-xs px-5 py-4 rounded-xl transition-all font-sans">
                        {{__t('text.frontend.comments_form_button', 'Comment')}}
                    </button>
                </form>

            </div>

        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $("body").on('submit', '#comment', function (event) {
            event.preventDefault()
            if ($('#comment').valid()) {

                var formData = new FormData(document.getElementById("comment"));
                formData.append("source", "backend");
                $('#loading_form').css('display', 'flex');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{ route('save.comment') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        $(':button').prop('disabled', true);
                    },
                    success: function (response) {

                        $('#loading_form').hide();

                        if (response.status == 'success') {
                            toastr.success(response.message)
                            setTimeout(function () {
                                window.location.href = "{{route('show.comments')}}";
                            }, 2000);
                        }

                        if (response.status == 'fail') {
                            $(':button').prop('disabled', false);
                            toastr.error(response.message)
                        }
                    }, error: function (xhr, status, error) {
                        window.errorHandler(xhr, status, error);
                    }
                });
            }
        });
    </script>
@endsection