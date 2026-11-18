@extends('layouts.app-backend')

@section('content')

    <div id="form-modal"></div>

    {{-- Publicar como testimonio: se guarda la versión en español y en inglés --}}
    <div class="modal fade" id="modal-testimonial" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Publicar como testimonio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Escribe el testimonio en ambos idiomas: la web y los correos mostrarán la versión del idioma del cliente. Deja el original en su idioma y traduce el otro.</p>
                    <div class="form-group">
                        <label for="testimonial_es">Español</label>
                        <textarea id="testimonial_es" class="form-control" rows="4" maxlength="{{ \App\Models\Comment::MAX_LENGTH }}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="testimonial_en">English</label>
                        <textarea id="testimonial_en" class="form-control" rows="4" maxlength="{{ \App\Models\Comment::MAX_LENGTH }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-publish-testimonial"><i class="fas fa-star mr-1"></i>Publicar</button>
                </div>
            </div>
        </div>
    </div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('staticpage.contacts')}}"
            paginate="{{ $contacts->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showBtnNew="false"
    >
        <tr>
            <th style="text-align: center">Acciones</th>
            <th>Nombres y Apellidos</th>
            <th>Correo Electrónico</th>
            <th>Asunto</th>
            <th>Comentario</th>
            <th>Respondido</th>
            <th class="text-center">Testimonio</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($contacts) > 0)
            @foreach($contacts AS $item)
                @php
                    $classStatus='bg-danger';
                        if($item->answered==1){
                            $classStatus='bg-success';
                        }

                @endphp
                <tr>

                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="comment"
                                :comment="true"
                                :edit="false"
                                :delete="true"
                        />

                    </td>

                    <td>{{capitalize_first($item->full_name)}}</td>

                    <td>{{$item->email}}</td>

                    <td>{{ $item->subject ? __t('text.frontend.ux.subject_' . $item->subject) : '—' }}</td>

                    <td>{{ Str::limit($item->comment, 70, '...') }} @if($item->path_file)
                            <a href="{{Storage::url($item->path_file)}}" target="_blank"><i class="fa fas fa-file-pdf"></i></a>
                        @endif</td>

                    <td><span class="badge {{$classStatus}}">{{($item->answered==1)?'SI':'NO'}}</span></td>

                    {{-- Los marcados se muestran como testimonio en la página principal --}}
                    <td class="text-center">
                        <button type="button" class="btn btn-sm {{ $item->is_testimonial ? 'btn-success' : 'btn-outline-secondary' }} js-toggle-testimonial"
                                data-id="{{ $item->id }}" data-published="{{ $item->is_testimonial ? 1 : 0 }}" data-comment="{{ $item->comment }}" title="{{ $item->is_testimonial ? 'Quitar de la web' : 'Publicar en la web' }}">
                            <i class="fas {{ $item->is_testimonial ? 'fa-star' : 'fa-star-half-alt' }} mr-1"></i>{{ $item->is_testimonial ? 'Publicado' : 'Publicar' }}
                        </button>
                    </td>

                    <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif
        </tbody>
    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('comment.response')])
    @include('admin.web_content.static_page.function-comment-response')
    <script type="application/javascript">
        var testimonialButton = null;

        function sendTestimonial(button, extra) {
            button.prop('disabled', true);

            $.post("{{ route('comment.testimonial') }}", $.extend({id: button.data('id'), _token: $('meta[name="csrf-token"]').attr('content')}, extra || {}))
                .done(function (response) {
                    if (response.status === 'fail') {
                        button.prop('disabled', false);
                        toastr.error(response.message);
                        return;
                    }

                    $('#modal-testimonial').modal('hide');
                    toastr.success(response.message);
                    setTimeout(function () { location.reload(); }, 600);
                })
                .fail(function () {
                    button.prop('disabled', false);
                    toastr.error('No se pudo actualizar el comentario.');
                });
        }

        $('body').on('click', '.js-toggle-testimonial', function () {
            var button = $(this);

            // Retirar de la web es directo; publicar pide las dos versiones (ES/EN)
            if (button.data('published') == 1) {
                sendTestimonial(button);
                return;
            }

            testimonialButton = button;
            $('#testimonial_es, #testimonial_en').val(button.data('comment'));
            $('#modal-testimonial').modal('show');
        });

        $('body').on('click', '#btn-publish-testimonial', function () {
            sendTestimonial(testimonialButton, {testimonial_es: $('#testimonial_es').val(), testimonial_en: $('#testimonial_en').val()});
        });
    </script>
@endsection
