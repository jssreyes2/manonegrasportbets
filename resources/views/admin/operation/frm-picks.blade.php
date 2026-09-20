<x-admin.modal-frm-default>

    <form role="form" id="frm-pick">
        <input type="hidden" name="route" id="route" value="{{route('pick.store')}}">
        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="source">Origen *</label>
                    <select class='form-control required inputform' id='source' name="source">

                        <option value=''>
                            Seleccione...
                        </option>

                        @foreach($sources AS $key=>$source)
                            <option value='{{$source}}'>
                                {{$source}}
                            </option>
                        @endforeach

                    </select>
                </div>


                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="plan_id">Planes *</label>
                    <select class='form-control required inputform' id='plan_id' name="plan_id">

                        <option value=''>
                            Seleccione...
                        </option>

                        @foreach($plans AS $item)
                            <option value='{{$item->id}}'>
                                {{$item->name}}
                            </option>
                        @endforeach

                    </select>
                </div>


                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="body">Contenido *</label>
                    <textarea id="summernote" name="body" class="summernote"></textarea>
                </div>

            </div>

            <div class="col-12 alert-pick" style="display: none;">
                <div class="alert alert-default-warning alert-dismissible">
                    <h5><i class="icon fas fa-exclamation-triangle message_pick"></i></h5>
                </div>
            </div>
            <div class="col-12 alert-pick-success" style="display: none;">
                <div class="alert alert-default-success alert-dismissible">
                    <h5><i class="icon fas fa-check message_pick_success"></i></h5>
                </div>
            </div>

        </div>


        @include('layouts.button-from-modal', ['route_cancel' => route('pick.index')])
    </form>

</x-admin.modal-frm-default>

<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="application/javascript">
    $('#summernote').summernote({
        height: 150, // Altura en píxeles
        minHeight: 150, // Altura mínima
        maxHeight: 150, // Altura máxima
        focus: true
    });


    $('#source').on('change', function () {
        $('#plan_id').val('');
    });

    $('#plan_id').on('change', function () {
        var planName = $(this).find('option:selected').text();
        var planId = $(this).val();

        if (planId && planId !== '' && planName !== 'Seleccione...') {
            $('#summernote').summernote('code', '<p><strong>Plan: ' + planName + '</strong></p>');
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{route('verify.pick')}}",
            cache: false,
            dataType: 'json',
            data: {plan_id: $('#plan_id').val(), source: $('#source').val()},
            success: function (response) {

                $('#send_form').prop('disabled', false);
                $('.alert-pick, .alert-pick-success').hide();

                if ($('#source').val() === 'SUSCRIPTION') {
                    if (response.status) {
                        $('#send_form').prop('disabled', true);
                        $('.message_pick').html(' Opps!! Debe actualizar el estatus de un PICK que esta por definir para poder enviar un pick de un plan ÉLITE.');
                        $('.alert-pick').show();
                    }

                    if (!response.subscription) {
                        $('.message_pick').html(' Opps!! No existe suscripciones activas para el plan seleccionado.');
                        $('.alert-pick').show();
                        $('#send_form').prop('disabled', true);
                    } else {
                        $('.message_pick_success').html(' Genial!! Se encontraron ' + response.subscription + ' suscripciones activas.');
                        $('.alert-pick-success').show();
                    }
                }
            }
        });

    });
</script>
