{{--
    Utilidades de formularios de la web pública (registro, login, comentarios, recuperar contraseña).
    JS plano e inline: funciona aunque el bundle de Vite no cargue.
    - TBHForm.error(input, msg) / TBHForm.clear(form): error bajo el campo (contenedor [data-field]).
    - TBHForm.serverErrors(form, xhr): pinta los 422 de Laravel campo por campo.
    - TBHForm.loading(button, true|false): spinner dentro del botón.
    - [data-toggle-password="id"]: botón de ojo para mostrar/ocultar la contraseña.
--}}
<script>
    window.TBH_I18N = {{ \Illuminate\Support\Js::from([
        'required'       => __t('text.frontend.ux.v_required'),
        'email'          => __t('text.frontend.ux.v_email'),
        'password_min'   => __t('text.frontend.ux.v_password_min'),
        'password_match' => __t('text.frontend.ux.v_password_match'),
        'terms'          => __t('text.frontend.ux.v_terms'),
        'name'           => __t('text.frontend.ux.v_name'),
        'comment_min'    => __t('text.frontend.ux.v_comment_min'),
        'fix_errors'     => __t('text.frontend.ux.v_fix_errors'),
        'connection'     => __t('text.frontend.ux.error_connection'),
        'unexpected'     => __t('text.frontend.ux.error_unexpected'),
        'show_password'  => __t('text.frontend.ux.show_password'),
        'hide_password'  => __t('text.frontend.ux.hide_password'),
    ]) }};

    window.TBHForm = (function () {
        var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function wrapperOf(input) {
            return input.closest('[data-field]') || input.parentElement;
        }

        function error(input, message) {
            if (!input) return;
            var wrapper = wrapperOf(input);
            var box = wrapper.querySelector('.tbh-field-box') || input.parentElement;
            var slot = wrapper.querySelector('[data-error]');

            if (!slot) {
                slot = document.createElement('p');
                slot.setAttribute('data-error', '');
                slot.className = 'tbh-field-error';
                wrapper.appendChild(slot);
            }

            slot.id = slot.id || (input.id || input.name) + '-error';
            slot.textContent = message;
            slot.hidden = false;
            box.classList.add('is-invalid');
            input.setAttribute('aria-invalid', 'true');
            input.setAttribute('aria-describedby', slot.id);
        }

        function clearField(input) {
            var wrapper = wrapperOf(input);
            var box = wrapper.querySelector('.tbh-field-box') || input.parentElement;
            var slot = wrapper.querySelector('[data-error]');
            if (slot) { slot.textContent = ''; slot.hidden = true; }
            box.classList.remove('is-invalid');
            input.removeAttribute('aria-invalid');
        }

        function clear(form) {
            form.querySelectorAll('input, textarea, select').forEach(clearField);
        }

        // Al escribir de nuevo en un campo marcado se quita su error
        document.addEventListener('input', function (e) {
            if (e.target.getAttribute && e.target.getAttribute('aria-invalid') === 'true') clearField(e.target);
        });
        document.addEventListener('change', function (e) {
            if (e.target.type === 'checkbox' && e.target.getAttribute('aria-invalid') === 'true') clearField(e.target);
        });

        function focusFirstError(form) {
            var first = form.querySelector('[aria-invalid="true"]');
            if (first) first.focus();
        }

        function serverErrors(form, xhr) {
            var json = xhr && xhr.responseJSON;

            if (xhr && xhr.status === 422 && json && json.errors) {
                var unplaced = [];
                Object.keys(json.errors).forEach(function (field) {
                    var messages = [].concat(json.errors[field]);
                    var input = form.querySelector('[name="' + field + '"]');
                    if (input) error(input, messages[0]); else unplaced.push(messages[0]);
                });
                focusFirstError(form);
                if (unplaced.length && window.toastr) toastr.error(unplaced[0]);
                return;
            }

            if (window.toastr) {
                toastr.error((json && json.message) || (xhr && xhr.status === 0 ? TBH_I18N.connection : TBH_I18N.unexpected));
            }
        }

        function loading(button, isLoading, text) {
            if (!button) return;
            if (isLoading) {
                button.dataset.label = button.innerHTML;
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
                button.innerHTML = '<span class="tbh-btn-spinner" aria-hidden="true"></span><span>' + (text || '') + '</span>';
            } else {
                button.disabled = false;
                button.removeAttribute('aria-busy');
                if (button.dataset.label) button.innerHTML = button.dataset.label;
            }
        }

        // Validaciones comunes; cada formulario arma su lista de reglas
        var rules = {
            required: function (input) { return input.type === 'checkbox' ? input.checked : input.value.trim() !== ''; },
            email: function (input) { return EMAIL_RE.test(input.value.trim()); },
            min: function (input, n) { return input.value.length >= n; },
        };

        function validate(form, checks) {
            clear(form);
            var ok = true;
            checks.forEach(function (check) {
                var input = form.querySelector('[name="' + check.name + '"]');
                if (!input || wrapperOf(input).querySelector('[aria-invalid="true"]')) return;
                if (!check.test(input)) { error(input, check.message); ok = false; }
            });
            if (!ok) focusFirstError(form);
            return ok;
        }

        // Botón de ojo
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-toggle-password]');
            if (!btn) return;
            var input = document.getElementById(btn.getAttribute('data-toggle-password'));
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? TBH_I18N.hide_password : TBH_I18N.show_password);
            btn.querySelector('[data-eye-open]').classList.toggle('hidden', show);
            btn.querySelector('[data-eye-closed]').classList.toggle('hidden', !show);
        });

        return {error: error, clear: clear, serverErrors: serverErrors, loading: loading, validate: validate, rules: rules};
    })();
</script>
