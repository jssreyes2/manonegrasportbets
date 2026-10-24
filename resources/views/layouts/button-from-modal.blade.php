
@php($isCustomer = auth()->user()->rol_id == \App\Models\Rol::ROL_CUSTOMER)
<div class="card-footer">
    <div class="tbh-form-actions">
        <button type="submit" class="btn btn-outline-info" id="send_form">
            <i class="fas fa-check-circle mr-1"></i>
            {{ $isCustomer ? __t('text.backend.forms.submit', 'Enviar') : 'Enviar' }}
        </button>

        <button type="button" class="btn btn-outline-secondary cancel-form" data-url="{{$route_cancel}}">
            <i class="fas fa-times mr-1"></i>
            {{ $isCustomer ? __t('text.backend.forms.cancel', 'Cancelar') : 'Cancelar' }}
        </button>

        <img src="{{asset('img/loadingfrm.gif')}}" id="loading_form" style="display: none">
    </div>
</div>
