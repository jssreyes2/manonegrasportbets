<div class="card-footer">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-1 mb-2">
            <button type="submit" class="btn btn-block btn-outline-secondary">
                Enviar
            </button>
        </div>

        @if(isset($route_cancel))
            <div class="col-12 col-md-6 col-lg-1 mb-2">
                <button type="button" class="btn btn-block btn-outline-secondary cancel-form" data-url="{{$route_cancel}}">Cancelar</button>
            </div>
        @endif

        <img src="{{asset('img/loadingfrm.gif')}}" id="loading_form" style="display: none">
    </div>
</div>

