<script type="application/javascript">

    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('summernote-wrapper');
        const textarea = document.getElementById('summernote');

        if (!wrapper || !textarea) return;

        const originalContent = textarea.value;

        function initializeSummernote() {
            if (window.jQuery && typeof jQuery.fn.summernote !== 'undefined') {
                textarea.style.display = 'none';

                jQuery(textarea).summernote({
                    height: 200,
                    minHeight: 200,
                    maxHeight: 500,
                    focus: true,
                    callbacks: {
                        onInit: function () {
                            if (wrapper) {
                                wrapper.classList.add('loaded');
                                wrapper.style.opacity = 1;
                            }
                        }
                    }
                });

                if (originalContent) {
                    jQuery(textarea).summernote('code', originalContent);
                }

                return true;
            }

            return false;
        }

        if (!initializeSummernote()) {
            const interval = setInterval(function () {
                if (initializeSummernote()) {
                    clearInterval(interval);
                }
            }, 100);

            setTimeout(function () {
                clearInterval(interval);
                if (wrapper && !wrapper.classList.contains('loaded')) {
                    wrapper.classList.add('loaded');
                    wrapper.style.opacity = 1;
                    console.warn('Summernote no se cargó, usando textarea normal');
                }
            }, 10000);
        }
    });

    $(document).ready(function () {
                     
        // Ajustar summernote en dispositivos móviles
        function adjustSummernote() {
            if ($(window).width() < 768) {
                $('.summernote').data('config', {
                    height: 150,
                    minHeight: 150,
                    maxHeight: 300,
                    focus: true,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview']]
                    ]
                });
            }
        }

        // Ejecutar al cargar y al redimensionar
        adjustSummernote();
        $(window).resize(adjustSummernote);
    });

</script>