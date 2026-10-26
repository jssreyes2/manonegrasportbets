{{-- Campo de contraseña del panel con botón de ojo. Recibe $name y $autocomplete --}}
<div class="input-group">
    <input type="password" class="form-control" id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $autocomplete }}" maxlength="100">
    <div class="input-group-append">
        <button type="button" class="btn btn-outline-secondary js-toggle-password" data-target="{{ $name }}"
                aria-label="{{ __t('text.frontend.ux.show_password') }}" aria-pressed="false">
            <i class="far fa-eye"></i>
        </button>
    </div>
</div>
<div class="invalid-feedback d-block" data-error-for="{{ $name }}"></div>
