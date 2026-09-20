<script type="application/javascript">

    $("body").on('submit', '#client-role', function (event) {
        event.preventDefault()
        if ($('#client-role').valid()) {
            var formData = new FormData(document.getElementById("client-role"));
            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{route('save.client.role')}}",
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
                    $(':button').prop('disabled', false);

                    if (response.status == 'success') {
                        toastr.success(response.message)
                        setTimeout(function () {
                            window.location.href = response.route;
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        toastr.error(response.message)
                    }
                },
                error: function (xhr, status, error) {
                    $('#loading_form').hide();
                    $(':button').prop('disabled', false);

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        // Limpia toasts anteriores si es necesario
                        toastr.clear();

                        // Mostrar cada error
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                // Usa el primer mensaje de error para cada campo
                                toastr.error(errors[key][0]);
                            }
                        }

                        // Opcional: Un mensaje general
                        // toastr.error('Por favor, corrija los errores en el formulario');

                    } else {
                        console.error('Error:', error);
                        toastr.error('Ha ocurrido un error inesperado');
                    }
                }
            });
        }
    });
</script>