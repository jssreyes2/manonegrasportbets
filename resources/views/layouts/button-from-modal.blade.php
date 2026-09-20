<div class="card-footer">
    <div class="row">

        <div class="form-group  {{$colLg ?? 'col-lg-2'}} col-md-6 col-sm-6 col-12">
            <button type="submit" class="btn btn-block btn-outline-info" id="send_form">
                <i class="fas fa-check-circle"></i>
                {{ auth()->user()->rol_id == \App\Models\Rol::ROL_CUSTOMER ? __t('text.backend.forms.submit', 'Enviar') : 'Enviar' }}
            </button>
        </div>
        
        <div class="form-group  {{$colLg ?? 'col-lg-2'}} col-md-6 col-sm-6 col-12">
            <button type="button" class="btn btn-block btn-outline-secondary cancel-form" data-url="{{$route_cancel}}">
                <i class="fas fa-times"></i>
                {{ auth()->user()->rol_id == \App\Models\Rol::ROL_CUSTOMER ? __t('text.backend.forms.cancel', 'Cancelar') : 'Cancelar' }}
            </button>
        </div>
        <img src="{{asset('img/loadingfrm.gif')}}" id="loading_form" style="display: none">
    </div>
</div>
