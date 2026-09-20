<x-admin.modal-frm-default>
    <form role="form" id="frm-faq">

        @if(isset($faq))
            <input type="hidden" id="route" name="route" value='{{route('faq.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($faq) ? $faq->id : '')}}'>
        @else
            <input type="hidden" id="route" name="route" value='{{route('faq.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="question">Pregunta *</label>
                    <input type="text" class="form-control required input_string" id="question" name="question" maxlength="200" autocomplete="off" value='{{(isset($faq) ? $faq->question : '')}}'>
                </div>

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="answer">Respuesta *</label>
                    <textarea id="summernote" name="answer">{{(isset($faq) ? $faq->answer : '')}}</textarea>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>$faq ?? null])
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="orden">Posición *</label>
                    <input type="text" class="form-control required input_number" id="orden" name="orden" maxlength="5" autocomplete="off" value='{{(isset($faq) ? $faq->orden : '')}}'>
                </div>

                <x-admin.select-language
                        :form="true"
                        :item="$faq ?? null"
                />
            </div>

        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('faq.index')])
    </form>
</x-admin.modal-frm-default>


<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="application/javascript">
    $('#summernote').summernote({
        height: 200, // Altura en píxeles
        minHeight: 200, // Altura mínima
        maxHeight: 500, // Altura máxima
        focus: true
    });
</script>