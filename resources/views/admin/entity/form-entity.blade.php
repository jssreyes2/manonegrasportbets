<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($entity))
                        Modificar Registro
                    @else
                        Nuevo Registro
                    @endif
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-purple card-outline">
                    <form role="form" id="frm-entity">

                        @if(isset($entity))
                            <input type="hidden" id="route" name="route" value='{{route($parameterEntity['name_route'].'.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($entity) ? $entity->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route($parameterEntity['name_route'].'.store')}}'>
                        @endif

                        <input type="hidden" id="type" name="type" value='{{$parameterEntity['type_entity']}}'>

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-6">
                                    <label for="identification">Cédula *</label>
                                    <input type="text" class="form-control required" id="identification" name="identification" maxlength="30" autocomplete="off" value='{{(isset($entity) ? $entity->identification : '')}}'>
                                </div>

                                <div class="form-group col-6">
                                    <label for="name">Nombre completo *</label>
                                    <input type="text" class="form-control required" id="name" name="name" maxlength="50" autocomplete="off" value='{{(isset ($entity) ? $entity->name: '')}}'>
                                </div>

                                <div class="form-group col-6">
                                    <label for="email">Correo Electrónico *</label>
                                    <input type="text" class="form-control required email" id="email" name="email" maxlength="50" autocomplete="off" value='{{(isset($entity) ? $entity->email : '')}}'>
                                </div>

                                <div class="form-group col-6">
                                    @include('layouts.select_is_active', ['item' =>(isset($entity) ? $entity : null)])
                                </div>

                            </div>
                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route($parameterEntity['name_route'].'.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>