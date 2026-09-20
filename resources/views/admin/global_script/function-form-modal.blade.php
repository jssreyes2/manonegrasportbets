<script type="application/javascript">
    @if(isset($route))
    $(document).on('click', '.new_form', function () {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{$route}}",
            cache: false,
            dataType: 'html',
            success: function (response) {
                $('#form-modal').html(response);
                $('#modal-form').modal('show');

                $('.date').datepicker({
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    yearRange: "1930:now()",
                    dropdownParent: $('#modal-form .modal-body')
                });
            }, error: function (xhr, status, error) {
                // Manejo del error
                var errors = xhr.responseJSON.errors;

                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {

                        if (errors[key][0] === 'validation.unique') {
                            toastr.error('Ha ocurrido un error.');
                            return;
                        }
                    }
                }
                toastr.error('Ha ocurrido un error. Por favor, intente nuevamente')
            }
        });
    });
    @endif

    $(document).on('click', '.edit_form', function () {

        let id = $(this).data("id");
        let url = $(this).data("url");

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: url,
            cache: false,
            data: {id: id},
            dataType: 'html',
            success: function (response) {
                $('#form-modal').html(response);
                $('#modal-form').modal('show');

                $('.date').datepicker({
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    yearRange: "1930:now()",
                    dropdownParent: $('#modal-form .modal-body')
                });
            }
        });
    });
</script>
