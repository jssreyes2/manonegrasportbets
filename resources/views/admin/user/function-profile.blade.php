<script type="application/javascript">

    $(function () {

        $('.select2').select2();
    });
    

    $("body").on('submit', '#customer-profile', function (event) {
        
        event.preventDefault()
        if ($('#customer-profile').valid()) {

            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{route('update.profile')}}",
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: new FormData(document.getElementById("customer-profile")),
                beforeSend: function () {
                    $(':button').prop('disabled', true);
                },
                success: function (response) {

                    $('#loading_form').hide();

                    if (response.status == 'success') {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('profile')}}";
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message)
                    }

                },  error: function(xhr) {
                    // Tu handler mejorado
                    $('#loading_form').hide();
                    $(':button').prop('disabled', false);

                    toastr.clear();

                    var responseJson = xhr.responseJSON;

                    // Validación 422
                    if (xhr.status === 422 && responseJson && responseJson.errors) {
                        var errors = responseJson.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                toastr.error(errors[key][0], 'Validación');
                            }
                        }
                        return;
                    }

                    // Debug (tu excepción)
                    if (responseJson && responseJson.debug) {
                        toastr.error(responseJson.debug, 'Error de Validación');
                        return;
                    }

                    // Mensaje genérico
                    if (responseJson && responseJson.message) {
                        toastr.error(responseJson.message, 'Error');
                        return;
                    }

                    toastr.error('Ha ocurrido un error inesperado', 'Error Crítico');
                }
            });
        }
    });
</script>