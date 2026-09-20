<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<!-- 2. Otros Plugins -->
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('plugins/datepicker/datepiker_es.js') }}"></script>
<!-- Select2 -->
<script type="text/javascript" src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- 7. Configuración global AJAX -->
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        window.errorHandler = function (xhr, status, error) {
            $('#loading_form').hide();
            $(':button').prop('disabled', false);
            let responseJson = xhr.responseJSON;

            if (xhr.status === 422 && responseJson && responseJson.errors) {
                $.each(responseJson.errors, function (field, messages) {
                    $.each(messages, function (index, message) {
                        toastr.error(message, 'Validación');
                    });
                });
                return;
            }
            if (responseJson && responseJson.debug) {
                toastr.error(responseJson.debug, 'Error de Validación');
                return;
            }
            if (responseJson && responseJson.status === 'error' && responseJson.message) {
                toastr.error(responseJson.debug || responseJson.message, 'Error');
                return;
            }
            if (responseJson && responseJson.message) {
                toastr.error(responseJson.message, 'Error');
                return;
            }
            toastr.error('Ocurrió un error inesperado en el servidor.', 'Error Crítico');
        };
    });
</script>