<script type="application/javascript">
    $("body").on('submit', '#parameter', function(event) {
        event.preventDefault();
        if ($('#parameter').valid()) {
            var formData = new FormData(document.getElementById("parameter"));

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
                beforeSend: function() {
                    $(':button').prop('disabled', true);
                },
                success: function(response) {
                    $('#loading_form').hide();

                    if (response.status == 'success') {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading_form').hide();
                    $(':button').prop('disabled', false);
                    toastr.error('Error al enviar el formulario.');
                }
            });
        }
    });
</script>