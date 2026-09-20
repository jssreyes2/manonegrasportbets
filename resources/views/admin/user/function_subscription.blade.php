<script>
    $(document).ready(function () {

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

        let whopPopup = null; // Variable global para guardar la referencia de la ventana
        $("body").on('submit', '.frm-plan', function (e) {
            // 1. Mostrar el fondo oscuro (overlay) y el cargando
            $('#whop-overlay').css('display', 'flex');
            $('#cargando').css('display', 'flex');
            $('.div-confirm-pay').hide();

            // 2. Abrir popup y guardarlo en la variable
            whopPopup = window.open('', 'whop_checkout', 'width=640,height=720');

            if (!whopPopup) {
                // Si el navegador bloqueó el popup, ocultamos el overlay y alertamos
                $('#whop-overlay').hide();
                $('#cargando').hide();
                alert('⚠️ Por favor, permite las ventanas emergentes (popups) para continuar con el pago.');
                return false;
            }

            // 3. Simular fin de carga y mostrar el mensaje de confirmación
            setTimeout(() => {
                $('#cargando').hide();
                $('.div-confirm-pay').show(); // Muestra tu caja de confirmación sobre el fondo oscuro
            }, 1500);

            // 4. Al hacer clic en cerrar aviso, cierra el popup, oculta el overlay y recarga la página
            $('#cerrar-overlay').off('click').on('click', function() {
                // Cerrar la ventana emergente si sigue abierta
                if (whopPopup && !whopPopup.closed) {
                    whopPopup.close();
                }

                $('#whop-overlay').hide();
                location.reload(); // Recarga la página completa
            });

            return true; // Permite que el form envíe los datos al target="whop_checkout"
        });
    });
</script>
