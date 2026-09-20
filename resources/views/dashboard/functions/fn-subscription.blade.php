<script>
    $(document).ready(function () {


        $("body").on('submit', '#frm-report-payment', function (event) {
            event.preventDefault()
            if ($('#frm-report-payment').valid()) {

                var formData = new FormData(document.getElementById("frm-report-payment"));

                $('#loading_form').show();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    url: "{{route('save.pay.subscription')}}",
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
                                window.location.href = "{{route('subscription')}}";
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


        // Mostrar mensaje de plan activo si existe
        @if(isset($activePlan) && $activePlan && isset($remainingDays) && $remainingDays <= 7)
        toastr.warning(
            'Tu plan activo vence en <strong>{{ $remainingDays }} días</strong>. ¡Renueva para no perder el servicio!',
            '⚠️ Próximo a vencer',
            {
                closeButton: true,
                progressBar: true,
                timeOut: 10000,
                extendedTimeOut: 5000,
                positionClass: 'toast-top-right',
                preventDuplicates: true
            }
        );
        @endif

        // Animación al hacer hover en las tarjetas
        $('.card').hover(
            function () {
                $(this).find('.btn:not(:disabled)').addClass('shadow');
            },
            function () {
                $(this).find('.btn:not(:disabled)').removeClass('shadow');
            }
        );


        $('.btn-select-plan').on('click', function () {
            const planId = $(this).data('plan-id');


            $.ajax({
                url: "{{ route('pay.subscription') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    plan_id: planId
                },
                success: function (response) {
                    window.location.href = response.redirect_url || '/';
                },
                error: function (xhr) {
                    toastr.error('Error al procesar la solicitud');
                }
            });
        });
        

        $('.btn-select-plan-free').on('click', function () {
            const planId = $(this).data('plan-id');
            const rolId = $(this).closest('.card-body').find('.rol-select').val();
            const loadingImg = $(this).closest('.card-body').find('img[id^="loading_form_"]');

            if (!rolId) {
                toastr.error('Por favor seleccione un tipo de usuario');
                return;
            }

            if (!confirm('¿Está seguro de seleccionar este plan?')) {
                return;
            }

            loadingImg.show();

            $.ajax({
                url: "{{ route('save.pay.subscription') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    plan_id: planId,
                    rol_id: rolId
                },
                beforeSend: function () {
                   // $(':button').prop('disabled', true);
                },
                success: function (response) {

                    loadingImg.hide();

                    if (response.status == 'success') {
                        toastr.success(response.message)

                        setTimeout(function () {
                            window.location.href = response.route;
                        }, 1000);
                    }

                    if (response.status == 'fail') {
                        $(':button').prop('disabled', false);
                        toastr.error(response.message)
                    }

                },
                error: function (xhr) {
                    toastr.error('Error al procesar la solicitud');
                }
            });
        });
    });
</script>
