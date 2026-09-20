<script type="application/javascript">

    $("body").on('submit', '#profile', function (event) {
        event.preventDefault()
        if ($('#profile').valid()) {

            var formData = new FormData(document.getElementById("profile"));

            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{route('update.profile')}}",
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

    $("body").on('submit', '#customer-profile', function (event) {
        event.preventDefault()
        if ($('#customer-profile').valid()) {

            var formData = new FormData(document.getElementById("customer-profile"));

            $('#loading_form').show();

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{route('update.profile')}}",
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

    $(document).ready(function () {
        
        // Cuando cambia la categoría
        $('#category_id').change(function () {
            let categoryId = $(this).val();
            let subcategorySelect = $('#subcategory_id');
            let selectedIds = [];
            // Limpiar el select de subcategorías
            subcategorySelect.empty();
            subcategorySelect.append('<option value="">Cargando...</option>');

            if (categoryId) {
                // Hacer la petición AJAX para obtener las subcategorías
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{ route("subcategory.getsubcategory") }}', // Cambia esta ruta
                    type: 'POST',
                    data: {
                        category_id: categoryId
                    },
                    success: function (data) {
                        subcategorySelect.empty();

                        if (data.length > 0) {
                            subcategorySelect.append('<option value="">Seleccione una subcategoría...</option>');
                       
                            // Obtener los subcategory_id seleccionados del usuario
                            @if(isset($userSubcategories) && is_array($userSubcategories))
                            let selectedIds = @json(array_column($userSubcategories, 'subcategory_id'));
                            @endif

                            $.each(data, function (key, subcategory) {
                                // Verificar si esta subcategoría debe estar seleccionada (para multiselect)
                                let selected = '';
                                if (selectedIds.includes(subcategory.id)) {
                                    selected = 'selected';
                                }

                                let formattedName = subcategory.name.charAt(0).toUpperCase() +
                                    subcategory.name.slice(1).toLowerCase();

                                subcategorySelect.append('<option value="' + subcategory.id + '" ' +
                                    selected + '>' + formattedName + '</option>');
                            });
                        } else {
                            subcategorySelect.append('<option value="">No hay subcategorías disponibles</option>');
                        }
                    },
                    error: function () {
                        subcategorySelect.empty();
                        subcategorySelect.append('<option value="">Error al cargar subcategorías</option>');
                    }
                });
            } else {
                subcategorySelect.empty();
                subcategorySelect.append('<option value="">Seleccione una categoría primero...</option>');
            }
        });

        // Disparar el evento change si ya hay una categoría seleccionada
        @if(isset($user->category_id))
        $('#category_id').trigger('change');
        @endif
    });
</script>