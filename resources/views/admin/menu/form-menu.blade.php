<x-admin.modal-frm-default>
    <form role="form" id="menu">

        @if(isset($menu))
            <input type="hidden" id="route_frm" name="route_frm" value='{{route('menu.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($menu) ? $menu->id : '')}}'>
        @else
            <input type="hidden" id="route_frm" name="route_frm" value='{{route('menu.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="type">Tipo *</label>
                    <select class='form-control required inputform' id='type' name='type' onchange="showSubdirectories(this.value)">
                        <option value="">
                            SELECCIONE
                        </option>
                        <option value="1" {{ (isset($menu) and $menu->type==true) ?'selected' : ''}}>
                            {{'DIRECTORIO'}}
                        </option>
                        <option value="2" {{ (isset($menu) and $menu->type==false) ?'selected' : ''}}>
                            {{'ENLACE'}}
                        </option>
                    </select>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12" id="selectSubMenu" style="display: none">
                    <label for='id_submenu'>Directorios *</label>
                    <select class='form-control required inputform' id='id_submenu' name='id_submenu'>
                        @foreach($subMenu AS $item)
                            @php($idmenu=((isset($data) ? $data->id:null)))
                            @if($idmenu!=$item['id'])
                                <option value="{{$item['id']}}" {{ (isset($data) and $item['id']==$data->id) ?'selected' : ''}}>
                                    {{$item['name']}}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="name">Nombre *</label>
                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="50" autocomplete="off" value='{{(isset($menu) ? $menu->name : '')}}'>
                </div>


                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12 optionsIputMenu">
                    <label for="icono">Icono *</label>
                    <input type="text" class="form-control input_string" id="icono" name="icono" maxlength="30" autocomplete="off" value='{{(isset($menu) ? $menu->icono : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="route">Ruta </label>
                    <input type="text" class="form-control" id="route" name="route" maxlength="100" autocomplete="off" value='{{(isset($menu) ? $menu->route : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>(isset($menu) ? $menu : null)])
                </div>

                <x-admin.select-language
                        :form="true"
                        :item="$plan ?? null"
                />
            </div>
        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('menu.index')])
    </form>
</x-admin.modal-frm-default>