<script type="application/javascript">

    $("body").on('submit', '#frm-product', function (event) {
        event.preventDefault()
        if ($('#frm-product').valid()) {

            var formData = new FormData(document.getElementById("frm-product"));

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
                            window.location.href = "{{route('user.create.product')}}";
                        }, 1000);
                    }

                    if (response.status == 'success' && response.edit) {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = "{{route('user.get.products')}}";
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
                            subcategorySelect.empty().append('<option value="">Seleccione una subcategoría...</option>');
                            let selectedId = null;

                            @if(isset($product))
                                selectedId = {{ $product->subcategory_id }};
                            @endif

                            @if(isset($filter['subcategory_id']))
                                selectedId = {{ $filter['subcategory_id']}};
                            @endif
                            
                            $.each(data, function (key, subcategory) {
                                let formattedName = subcategory.name.charAt(0).toUpperCase() +
                                    subcategory.name.slice(1).toLowerCase();

                                let option = new Option(formattedName, subcategory.id, false, subcategory.id == selectedId);
                                subcategorySelect.append(option);
                            });

                            // Forzar actualización si usas Select2 o algún plugin similar
                            if (subcategorySelect.hasClass('select2')) {
                                subcategorySelect.trigger('change');
                            }
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
        @if(isset($product->category_id) || isset($filter['category_id']))
        $('#category_id').trigger('change');
        @endif
    });
</script>