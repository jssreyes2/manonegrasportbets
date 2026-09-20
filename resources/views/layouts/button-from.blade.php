<div class="card-footer">
    <div class="row">
        <div class="col-md-1">
            <button type="submit" class="btn btn-block btn-outline-secondary">
                Enviar
            </button>
        </div>

        @if(isset($route_cancel))
        <div class="col-md-1">
            <a href="{{$route_cancel}}" class="btn btn-block btn-outline-secondary">
                Cancelar
            </a>
        </div>
        @endif

        <img src="{{asset('img/loadingfrm.gif')}}" id="loading_form" style="display: none">
    </div>
</div>
