<x-admin.modal-frm-default>
    <form role="form" id="frm-pick">
        <input type="hidden" name="route" id="route" value="{{route('pick.update')}}">
        <input type="hidden" name="id" value="{{$pick->id}}">
        <div class="card-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="right">Estatus del Pick</label>
                    <select class="form-control required inputform" id="right" name="right">
                        <option value="">Seleccionar estatus...</option>
                        <option value="1">Exitoso</option>
                        <option value="0">Fallido</option>
                    </select>
                    <small class="form-text text-muted">Selecciona el estatus del pick realizado</small>
                </div>
            </div>
        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('pick.index')])
    </form>
</x-admin.modal-frm-default>
