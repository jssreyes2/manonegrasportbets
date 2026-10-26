<script type="application/javascript">
    $(function () {
        var I18N = {{ \Illuminate\Support\Js::from([
            'required'       => __t('text.frontend.ux.v_required'),
            'email'          => __t('text.frontend.ux.v_email'),
            'password_min'   => __t('text.frontend.ux.v_password_min'),
            'password_match' => __t('text.frontend.ux.v_password_match'),
            'photo_type'     => __t('text.backend.customer.photo_bad_type'),
            'photo_size'     => __t('text.backend.customer.photo_too_big'),
            'unexpected'     => __t('text.frontend.ux.error_unexpected'),
            'saving'         => __t('text.frontend.ux.saving'),
            'show_password'  => __t('text.frontend.ux.show_password'),
            'hide_password'  => __t('text.frontend.ux.hide_password'),
        ]) }};
        var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var MAX_PHOTO_BYTES = 10 * 1024 * 1024;

        // ---------- Errores bajo cada campo ----------
        function clearErrors(form) {
            $(form).find('.is-invalid').removeClass('is-invalid').removeAttr('aria-invalid');
            $(form).find('[data-error-for]').text('').removeClass('d-block');
        }

        function showError(form, field, message) {
            var input = $(form).find('[name="' + field + '"]');
            input.addClass('is-invalid').attr('aria-invalid', 'true');
            input.next('.select2').find('.select2-selection').addClass('is-invalid');
            $(form).find('[data-error-for="' + field + '"]').text(message).addClass('d-block');
        }

        function focusFirstError(form) {
            $(form).find('[aria-invalid="true"]').first().trigger('focus');
        }

        function handleAjaxError(form, xhr) {
            var json = xhr.responseJSON;
            if (xhr.status === 422 && json && json.errors) {
                $.each(json.errors, function (field, messages) { showError(form, field, messages[0]); });
                focusFirstError(form);
                return;
            }
            toastr.error((json && json.message) || I18N.unexpected);
        }

        function loading(button, on) {
            var $button = $(button);
            if (on) {
                $button.data('label', $button.html()).prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm mr-1" aria-hidden="true"></span>' + I18N.saving);
            } else {
                $button.prop('disabled', false).html($button.data('label'));
            }
        }

        // Al corregir un campo se quita su error
        $('body').on('input change', '.is-invalid', function () {
            $(this).removeClass('is-invalid').removeAttr('aria-invalid');
            $('[data-error-for="' + this.name + '"]').text('').removeClass('d-block');
        });

        function post(form, url, data, onSuccess) {
            var button = $(form).find('button[type="submit"]');
            loading(button, true);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    loading(button, false);
                    if (response.status === 'success') {
                        onSuccess(response);
                    } else {
                        toastr.error(response.message || I18N.unexpected);
                    }
                },
                error: function (xhr) {
                    loading(button, false);
                    handleAjaxError(form, xhr);
                }
            });
        }

        // ---------- Pestañas: se recuerda la abierta en la URL ----------
        if (location.hash && $('a[href="' + location.hash + '"][data-toggle="tab"]').length) {
            $('a[href="' + location.hash + '"][data-toggle="tab"]').tab('show');
        }
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            history.replaceState(null, '', e.target.getAttribute('href'));
            $('a[data-toggle="tab"]').attr('aria-selected', 'false');
            e.target.setAttribute('aria-selected', 'true');
        });
        $('.js-open-tab').on('click', function (e) {
            e.preventDefault();
            $('a[href="' + this.getAttribute('href') + '"][data-toggle="tab"]').tab('show');
        });

        // ---------- Ojo de contraseña ----------
        $('.js-toggle-password').on('click', function () {
            var input = document.getElementById(this.dataset.target);
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.setAttribute('aria-pressed', show ? 'true' : 'false');
            this.setAttribute('aria-label', show ? I18N.hide_password : I18N.show_password);
            $(this).find('i').toggleClass('fa-eye', !show).toggleClass('fa-eye-slash', show);
        });

        // ---------- Datos personales ----------
        var profileForm = document.getElementById('customer-profile');
        var croppedPhoto = null;

        $('.select2').select2({width: '100%'});

        // Prefijo telefónico según el país elegido
        $('#country_id').on('change', function () {
            var code = $(this).find(':selected').data('code');
            $('#phone-code').text(code ? '+' + code : '+');
        });

        // Valida y recorta la foto en cuadrado (400px, JPEG) antes de subirla
        $('#photo').on('change', function () {
            var file = this.files && this.files[0];
            clearErrors(profileForm);
            croppedPhoto = null;
            if (!file) return;

            if (['image/jpeg', 'image/png'].indexOf(file.type) === -1) {
                showError(profileForm, 'photo', I18N.photo_type);
                this.value = '';
                return;
            }
            if (file.size > MAX_PHOTO_BYTES) {
                showError(profileForm, 'photo', I18N.photo_size);
                this.value = '';
                return;
            }

            var image = new Image();
            image.onload = function () {
                var side = Math.min(image.width, image.height);
                var canvas = document.createElement('canvas');
                canvas.width = canvas.height = Math.min(400, side);
                canvas.getContext('2d').drawImage(
                    image,
                    (image.width - side) / 2, (image.height - side) / 2, side, side,
                    0, 0, canvas.width, canvas.height
                );
                canvas.toBlob(function (blob) {
                    croppedPhoto = blob;
                    document.getElementById('photo-preview').src = URL.createObjectURL(blob);
                }, 'image/jpeg', 0.9);
                URL.revokeObjectURL(image.src);
            };
            image.src = URL.createObjectURL(file);
        });

        $(profileForm).on('submit', function (event) {
            event.preventDefault();
            clearErrors(profileForm);

            var valid = true;
            ['first_name', 'last_name', 'country_id', 'phone'].forEach(function (field) {
                if (!$.trim(profileForm[field].value)) {
                    showError(profileForm, field, I18N.required);
                    valid = false;
                }
            });
            if (!valid) {
                focusFirstError(profileForm);
                return;
            }

            var data = new FormData(profileForm);
            data.delete('photo');
            if (croppedPhoto) {
                data.append('photo', croppedPhoto, 'photo.jpg');
            }

            var wasIncomplete = {{ $user->completed_profile ? 'false' : 'true' }};

            post(profileForm, "{{ route('update.profile') }}", data, function (response) {
                toastr.success(response.message);
                // Perfil recién completado: ya puede usar el resto del panel
                if (wasIncomplete) {
                    setTimeout(function () { window.location.href = "{{ route('customer.home') }}"; }, 900);
                } else if (croppedPhoto) {
                    setTimeout(function () { location.reload(); }, 900);
                }
            });
        });

        // ---------- Seguridad ----------
        var securityForm = document.getElementById('update-password');

        $(securityForm).on('submit', function (event) {
            event.preventDefault();
            clearErrors(securityForm);

            var email = $.trim(securityForm.email.value);
            var password = securityForm.password.value;
            var valid = true;

            if (!EMAIL_RE.test(email)) {
                showError(securityForm, 'email', email ? I18N.email : I18N.required);
                valid = false;
            }
            if (securityForm.current_password && !securityForm.current_password.value) {
                showError(securityForm, 'current_password', I18N.required);
                valid = false;
            }
            if (password && password.length < 8) {
                showError(securityForm, 'password', I18N.password_min);
                valid = false;
            } else if (password && password !== securityForm.password_confirmation.value) {
                showError(securityForm, 'password_confirmation', I18N.password_match);
                valid = false;
            }
            if (!valid) {
                focusFirstError(securityForm);
                return;
            }

            post(securityForm, "{{ route('save.new.password') }}", new FormData(securityForm), function (response) {
                toastr.success(response.message);
                $(securityForm).find('input[type="password"], input[type="text"][id*="password"]').val('');
                if (response.redirect) {
                    setTimeout(function () { window.location.href = response.redirect; }, 2500);
                }
            });
        });

        // ---------- Preferencias ----------
        var preferencesForm = document.getElementById('preferences');

        $(preferencesForm).on('submit', function (event) {
            event.preventDefault();
            post(preferencesForm, "{{ route('profile.preferences') }}", new FormData(preferencesForm), function (response) {
                toastr.success(response.message);
                // El idioma cambia todo el panel: se recarga en la misma pestaña
                setTimeout(function () { location.reload(); }, 700);
            });
        });
    });
</script>
