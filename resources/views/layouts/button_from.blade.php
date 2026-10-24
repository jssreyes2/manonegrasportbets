<div class="card-footer">
    <div class="tbh-form-actions">
        <button type="submit" class="btn btn-outline-info">
            <i class="fas fa-check-circle mr-1"></i> Enviar
        </button>

        @if(isset($route_cancel))
            <button type="button" class="btn btn-outline-secondary cancel-form" data-url="{{$route_cancel}}">Cancelar</button>
        @endif

        <img src="{{asset('img/loadingfrm.gif')}}" id="loading_form" style="display: none">
    </div>
</div>
