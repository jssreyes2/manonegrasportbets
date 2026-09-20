<script type="application/javascript">

    $("body").on('submit', '#frm-static-page', function (event) {
        event.preventDefault()
        if ($('#frm-static-page').valid()) {

            var formData = new FormData(document.getElementById("frm-static-page"));

            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: $('#route').val(),
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
                            window.location.href = "{{route('staticpage.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'success' && response.edit) {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('staticpage.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message)
                    }
                }, error: function (xhr, status, error) {
                    // Manejo del error
                    var errors = xhr.responseJSON.errors;

                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {

                            if (errors[key][0] === 'validation.unique') {
                                toastr.error('Ha ocurrido un error. la respuesta es obligatoria');
                                setTimeout(function () {
                                    $(':button').prop('disabled', false);
                                    $('#loading_form').hide();
                                }, 1000);
                                return;
                            }
                        }
                    }
                    toastr.error('Ha ocurrido un error. Por favor, verifique que todos los campos obligatorios estén completos e intente nuevamente');
                    setTimeout(function () {
                        $(':button').prop('disabled', false);
                        $('#loading_form').hide();
                    }, 1000);
                }
            });
        }
    });

    $("body").on('change', '#type', function () {
        if ($(this).val() == "{{\App\Models\StaticPage::TYPE_BLOG}}") {
            $('.div_photo_content').show();
            return;
        }
        $('.div_photo_content').hide();
    });
</script>