<x-admin.modal-frm-default>
    <form role="form" id="rol">

        @if(isset($rol))
            <input type="hidden" id="route" name="route" value='{{route('rol.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($rol) ? $rol->id : '')}}'>
        @else
            <input type="hidden" id="route" name="route" value='{{route('rol.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="name">Nombre *</label>
                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="30" autocomplete="off" value='{{(isset($rol) ? $rol->name : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>(isset($rol) ? $rol : null)])
                </div>

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <h3>Permisos</h3>
                    <div id="accordion">

                        @foreach ($menus as $key => $item)
                            @if ($item['parent'] != 0)
                                @break
                            @endif

                            <div class="card card-teal card-outline">
                                <div class="card-header">
                                    <h4 class="card-title w-100">

                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input submenu{{$item['id']}} submenu" id="menu_id{{$item['id']}}" name="menu_id[]" value="{{$item['id'].'@'.$item['parent']}}"
                                                    {{ (isset($arrPermission) and in_array($item['id'], $arrPermission)) ?'checked' : ''}}>
                                            <label class="custom-control-label" for="menu_id{{$item['id']}}">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne{{$item['id']}}">
                                                    {{$item['name']}}
                                                </a>
                                            </label>
                                        </div>

                                    </h4>
                                </div>

                                <div id="collapseOne{{$item['id']}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th class="text-center">Seleccionar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @include('admin.rol.list-submenu-permission-rol', [ 'item' => $item,  'idRol'=>isset($rol) ? $rol->id : '' ])
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('rol.index')])
    </form>
</x-admin.modal-frm-default>