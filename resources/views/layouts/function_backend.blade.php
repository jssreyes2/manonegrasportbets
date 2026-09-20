<script type="application/javascript">
    // Usamos una función autoejecutable para blindar el uso de jQuery ($)
    (function ($) {
            // Verificamos de forma segura si select2 existe antes de llamarlo
            if ($.fn.select2) {
                $('.select2').select2();
            } else {
                console.warn("Select2 aún no está disponible en este momento.");
            }

            $("body").on('click', '.btn-close', function () {
                window.location.reload();
            });

            $("body").on('keypress', '.input_string', function (event) {
                var regex = new RegExp("^[a-zA-ZáéíóúAÉÍÓÚÑñ ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });

            $("body").on('keypress', '.input_number', function (event) {
                var regex = new RegExp("^[0-9]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });

            $("body").on('click', '.download-report', function () {
                var url = $(this).attr('data-url')
                window.location.href = url;
            });

            $("body").on('input', '.point_number', function (event) {
                const input = $(this);
                let value = input.val();

                const regex = /^[0-9]*\.?[0-9]*$/;

                if (!regex.test(value)) {
                    value = value.replace(/[^0-9.]/g, '');
                    const dotCount = (value.match(/\./g) || []).length;
                    if (dotCount > 1) {
                        value = value.replace(/\.+$/, '');
                    }
                    input.val(value);
                }
            });

            $("body").on('keypress', '.input_alphanumeric', function (event) {
                var regex = new RegExp("^[a-zA-Z0-9-- ]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });

            $("body").on('click', '.confirm_action', function () {
                var id = $(this).data("id");
                var route_controller = $(this).data("name");
                $('#id_register').val(id);
                $('#route_controller').val(route_controller);
                $('#modal-confirmation').modal('show');
            });

            $("body").on('click', '.cancel-form', function () {
                var routeController = $(this).data("url");
                window.location.href = routeController;
            });

            $("body").on('click', '.close-form-modal', function () {
                $('#modal-confirmation').modal('hide');
            });

            // Corregido el yearRange para evitar errores de sintaxis en jQuery UI
            if ($.fn.datepicker) {
                $('.date').datepicker({
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    yearRange: "1930:" + new Date().getFullYear()
                });
            }
    })(jQuery);

    // Funcion para subir imagen
    $("body").on('change', '#photo', function (event) {
        const file = this.files[0];
        const previewContainer = $('#image-preview-container');

        if (previewContainer.length === 0) {
            $('.form-group.col-6').after(`
            <div class="form-group col-12">
                <label>Vista Previa del Logo:</label>
                <div id="image-preview-container" class="mt-2"></div>
            </div>
        `);
        }

        const container = $('#image-preview-container');
        container.empty();

        if (file) {
            if (!file.type.match('image.*')) {
                toastr.error('Por favor, selecciona un archivo de imagen válido.');
                $(this).val('');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                toastr.error('La imagen no debe superar los 2MB.');
                $(this).val('');
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                container.html(`
                <div class="image-preview-wrapper">
                    <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px; max-width: 200px;">
                    <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-preview">
                        <i class="fas fa-times"></i> Eliminar
                    </button>
                </div>
            `);
            };

            reader.readAsDataURL(file);
        }
    });

    // Eliminar preview
    $("body").on('click', '#remove-preview', function () {
        $('#photo').val('');
        $('#file_pdf').val('');
        $('#image-preview-container').empty();
        $('.custom-file-label').text('Seleccionar archivo');
    });

    // Actualizar el label del file input para foto
    $("body").on('change', '#photo', function () {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').text(fileName || 'Seleccionar archivo');
    });

    // Funcion para subir Archivos PDF
    $("body").on('change', '#file_pdf', function (event) {
        const file = this.files[0];
        const previewContainer = $('#image-preview-container');

        if (previewContainer.length === 0) {
            $('.form-group.col-6').after(`
            <div class="form-group col-12">
                <label>Vista Previa del PDF:</label>
                <div id="image-preview-container" class="mt-2"></div>
            </div>
        `);
        }

        const container = $('#image-preview-container');
        container.empty();

        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();
            const isValidPdf = file.type === 'application/pdf' || fileExtension === 'pdf';

            if (!isValidPdf) {
                toastr.error('Por favor, selecciona un archivo PDF válido.');
                $(this).val('');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                toastr.error('El archivo PDF no debe superar los 10MB.');
                $(this).val('');
                return;
            }

            container.html(`
            <div class="pdf-preview-wrapper">
                <div class="alert alert-info">
                    <i class="fas fa-file-pdf"></i>
                    <strong>${file.name}</strong><br>
                    Tamaño: ${(file.size / 1024 / 1024).toFixed(2)} MB
                </div>
                <button type="button" class="btn btn-sm btn-danger" id="remove-preview">
                    <i class="fas fa-times"></i> Eliminar
                </button>
            </div>
        `);
        }
    });

    // Actualizar el label del file input para PDF
    $("body").on('change', '#file_pdf', function () {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').text(fileName || 'Seleccionar archivo');
    });

    $("body").on('click', '.btn_modal_confirmation', function () {
        var route_controller = $('#route_controller').val();

        $('.loading_modal').show();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: route_controller,
            cache: false,
            dataType: 'json',
            data: {id: $('#id_register').val()},
            beforeSend: function () {
                $(':button').prop('disabled', true);
            },
            success: function (response) {
                $('.loading_modal').hide();

                if (response.status == 'success') {
                    toastr.success(response.message)

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }

                if (response.status == 'fail') {
                    toastr.error(response.message)
                }
            }
        });
    });
</script>