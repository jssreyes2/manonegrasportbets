<script type="application/javascript">

    function showSubdirectories(type) {
        if (type == 1) {
            $('#selectSubMenu').hide();
            $('.optionsIputMenu').show();
        } else {
            $('#selectSubMenu').show();
            $('.optionsIputMenu').hide();
        }
    }

    $("body").on('submit', '#menu', function (event) {
        event.preventDefault()
        if ($('#menu').valid()) {

            var formData = new FormData(document.getElementById("menu"));

            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: $('#route_frm').val(),
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

                    if (response.status == 'success' && !response.edit) {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('menu.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'success' && response.edit) {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('menu.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message)
                    }
                }, error: function (xhr, status, error) {
                    // Manejo del error
                    console.error('Error:', error);
                    if (xhr.status === 422) {

                        $('#loading_form').hide();
                        $(':button').prop('disabled', false);

                        toastr.error('Ha ocurrido un error. Por favor, verifique que todos los campos obligatorios estén completos e intente nuevamente')
                    }
                }
            });
        }
    });
</script>