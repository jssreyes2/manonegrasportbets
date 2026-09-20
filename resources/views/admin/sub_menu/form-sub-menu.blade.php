<x-admin.modal-frm-default>
    <form role="form" id="submenu">

        <input type="hidden" id="route_frm" name="route_frm" value='{{route('submenu.update')}}'>
        <input type="hidden" id="id" name="id" value='{{(isset($subMenu) ? $subMenu->id : '')}}'>

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for='id_submenu'>Directorios *</label>
                    <select class='form-control required inputform' id='id_submenu' name='id_submenu'>
                        @foreach($menus AS $item)

                            <option value="{{$item['id']}}" {{ (isset($subMenu) and $item['id']==$subMenu->parent) ?'selected' : ''}}>
                                {{$item['name']}}
                            </option>

                        @endforeach
                    </select>
                </div>


                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="first_name">Nombre *</label>
                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="50" autocomplete="off" value='{{(isset($subMenu) ? $subMenu->name : '')}}'>
                </div>


                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="route">Ruta </label>
                    <input type="text" class="form-control" id="route" name="route" maxlength="100" autocomplete="off" value='{{(isset($subMenu) ? $subMenu->route : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>(isset($subMenu) ? $subMenu : null)])
                </div>
            </div>
        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('submenu.index')])
    </form>
</x-admin.modal-frm-default>