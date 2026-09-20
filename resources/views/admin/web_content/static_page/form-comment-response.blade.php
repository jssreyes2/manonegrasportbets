<x-admin.modal-frm-default>
    <form role="form" id="frm-comment-response">

        @if(isset($contact))
            <input type="hidden" id="id" name="id" value='{{($contact->id??'')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="full_name">Nombres y Apellido *</label>
                    <input type="text" class="form-control required input_string" id="full_name" name="full_name" maxlength="200" autocomplete="off" readonly="readonly" value='{{(isset($contact) ? $contact->full_name : '')}}'>
                </div>

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="comment">Comentario *</label>
                    <textarea id="comment" name="comment" class="form-control" readonly="readonly" style="height:200px!important;">{!!(isset($contact) ? $contact->comment : '')!!}</textarea>
                </div>

                @if(!$contact->answered)
                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                        <label for="response_text">Respuesta *</label>
                        <textarea id="summernote" name="response_text" class="summernote"></textarea>
                    </div>
                @endif
            </div>

        </div>

        @if(!$contact->answered)
            @include('layouts.button-from-modal', ['route_cancel' => route('staticpage.contacts')])
        @endif
    </form>
</x-admin.modal-frm-default>

<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="application/javascript">
    $('#summernote').summernote({
        height: 500, // Altura en píxeles
        minHeight: 100, // Altura mínima
        maxHeight: 200, // Altura máxima
        focus: true
    });
</script>