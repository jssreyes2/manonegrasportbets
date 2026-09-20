<script type="application/javascript">

    // Función para limpiar errores de validación del campo file_pdf
    function clearFileValidationError() {
        const $fileInput = $('#file_pdf');
        $fileInput.removeClass('error');
        $fileInput.next('label.error').remove();
        // También limpiar el error generado por jQuery Validation si existe
        $fileInput.closest('.form-group').find('label.error').not('.custom-file-label').remove();
    }

    // Función para mostrar error en el campo file_pdf
    function showFileValidationError(message) {
        const $fileInput = $('#file_pdf');
        $fileInput.addClass('error');

        // Verificar si ya existe un label de error
        if ($fileInput.next('label.error').length === 0) {
            $fileInput.after(`<label for="file_pdf" generated="true" class="error">${message}</label>`);
        } else {
            $fileInput.next('label.error').text(message);
        }
    }

    // Validación en tiempo real al seleccionar el archivo
    $("body").on('change', '#file_pdf', function () {
        // Limpiar errores previos
        clearFileValidationError();

        const file = this.files[0];

        if (file) {
            // Actualizar el label de Bootstrap
            $(this).next('.custom-file-label').html(file.name);

            // Validar extensión
            const fileExtension = file.name.split('.').pop().toLowerCase();
            const isValidPdf = file.type === 'application/pdf' || fileExtension === 'pdf';

            if (!isValidPdf) {
                toastr.error('Por favor, selecciona un archivo PDF válido.');
                $(this).val('');
                $(this).next('.custom-file-label').html('Seleccionar archivo');
                showFileValidationError('Solo se permiten archivos PDF');
                return;
            }

            // Validar tamaño
            if (file.size > 10 * 1024 * 1024) {
                toastr.error('El archivo PDF no debe superar los 10MB.');
                $(this).val('');
                $(this).next('.custom-file-label').html('Seleccionar archivo');
                showFileValidationError('El archivo no debe superar los 10MB');
                return;
            }

            // Mostrar información del archivo
            let sizeDisplay = file.size >= 1024 * 1024
                ? `${(file.size / (1024 * 1024)).toFixed(2)} MB`
                : `${(file.size / 1024).toFixed(2)} KB`;

            toastr.success(`Archivo válido: ${file.name} (${sizeDisplay})`, 'PDF seleccionado');

        } else {
            $(this).next('.custom-file-label').html('Seleccionar archivo');
            // Si el campo es requerido y se borró el archivo, mostrar error
            // Comenta esto si el archivo es opcional
            // showFileValidationError('Este campo es requerido');
        }
    });

    $("body").on('submit', '#frm-resource', function (event) {
        event.preventDefault()
        if ($('#frm-resource').valid()) {

            var formData = new FormData(document.getElementById("frm-resource"));

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
                            window.location.href = "{{route('resource.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'success' && response.edit) {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('resource.index')}}";
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message)
                    }
                }, error: function (xhr, status, error) {
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

                    } else {
                        toastr.error('Ha ocurrido un error inesperado');
                    }
                }
            });
        }
    });

    $("body").on('click', '.download-button', function(e) {
        e.preventDefault();

        var downloadUrl = $(this).data('url');
        var button = $(this);

        // Mostrar loading
        button.html('<i class="fa fa-spinner fa-spin"></i> Descargando...');
        button.prop('disabled', true);

        // Realizar petición AJAX
        $.ajax({
            url: downloadUrl,
            method: 'GET',
            xhrFields: {
                responseType: 'blob' // Importante para manejar archivos
            },
            success: function(response, status, xhr) {
                // Crear blob y descargar
                var blob = new Blob([response]);
                var link = document.createElement('a');
                var url = window.URL.createObjectURL(blob);

                // Obtener nombre del archivo del header si está disponible
                var filename = '';
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/['"]/g, '');
                }

                link.href = url;
                link.download = filename || 'documento.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);

                // Restaurar botón
                button.html('Descargar');
                button.prop('disabled', false);

                setTimeout(function() {
                    location.reload();
                }, 1000);

            },
            error: function(xhr, status, error) {
                console.error('Error en descarga:', error);
                button.html('Error al descargar');
                button.prop('disabled', false);

                setTimeout(function() {
                    button.html('<i class="fas fa-download"></i> Descargar');
                }, 3000);
            }
        });
    });

    // archivo: js/custom.js o tu archivo JavaScript

    $(document).ready(function() {
        // Función para inicializar el contador en un textarea específico
        function inicializarContador(textareaId, contadorId, maxCaracteres = 255) {
            var textarea = $('#' + textareaId);
            var contador = $('#' + contadorId);

            if (textarea.length === 0) return;

            function actualizarContador() {
                var longitud = textarea.val().length;
                contador.text(longitud);

                if (longitud > maxCaracteres) {
                    contador.addClass('text-danger');
                    contador.removeClass('text-muted');
                    textarea.val(textarea.val().substring(0, maxCaracteres));
                    contador.text(maxCaracteres);
                } else {
                    contador.removeClass('text-danger');
                    contador.addClass('text-muted');
                }

                // Cambiar color cuando se acerca al límite
                if (longitud >= maxCaracteres - 20) {
                    contador.addClass('text-warning');
                } else {
                    contador.removeClass('text-warning');
                }
            }

            // Usar keypress en lugar de input
            textarea.on('keypress', function(e) {
                var longitud = textarea.val().length;
                // Prevenir si ya alcanzó el límite
                if (longitud >= maxCaracteres) {
                    e.preventDefault();
                    return false;
                }
                // Pequeño timeout para actualizar después del keypress
                setTimeout(actualizarContador, 0);
            });

            // También mantener input para otros eventos (paste, etc)
            textarea.on('input', actualizarContador);

            // Inicializar contador
            actualizarContador();
        }

        // Inicializar cuando el modal se abre
        $(document).on('shown.bs.modal', '#modal-form', function() {
            inicializarContador('description', 'contador', 255);
        });

        // También puedes inicializar directamente si el textarea ya existe
        if ($('#description').length) {
            inicializarContador('description', 'contador', 255);
        }
    });

</script>