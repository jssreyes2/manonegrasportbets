@foreach ($item['children'] as $item)
    @if ($item['children'] == [])

        @php
            if($idRol){
                $AdditionalPermissions=false;
                $AdditionalPermissions=\App\Repositories\Settings\MenuRepository::getAdditionalPermissions($item['id'], $idRol);
            }
        @endphp

        <tr>
            <td>
                {{$item['name']}}
            </td>

            <td class="text-center">

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="menu_id{{$item['id']}}" name="menu_id[]" class="submenu{{$item['id']}} submenu" value="{{$item['id'].'@'.$item['parent']}}"
                            {{ (isset($arrPermission) and in_array($item['id'], $arrPermission)) ?'checked' : ''}}>
                    <label class="custom-control-label" for="menu_id{{$item['id']}}"></label>
                </div>

            </td>

            {{--            <td>--}}

            {{--                <div class="custom-control custom-switch">--}}
            {{--                    <input type="checkbox" class="custom-control-input" id="new{{$item['id']}}" name="new[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and--}}
            {{--                        $AdditionalPermissions->new==true) ?'checked' : ''}}>--}}
            {{--                    <label class="custom-control-label" for="new{{$item['id']}}">Nuevo</label>--}}
            {{--                </div>--}}

            {{--            </td>--}}

            {{--            <td>--}}

            {{--                <div class="custom-control custom-switch">--}}
            {{--                    <input type="checkbox" class="custom-control-input" id="edit{{$item['id']}}" name="edit[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and--}}
            {{--                        $AdditionalPermissions->edit==true) ?'checked' : ''}}>--}}
            {{--                    <label class="custom-control-label" for="edit{{$item['id']}}">Editar</label>--}}
            {{--                </div>--}}

            {{--            </td>--}}

            {{--            <td>--}}

            {{--                <div class="custom-control custom-switch">--}}
            {{--                    <input type="checkbox" class="custom-control-input" id="delet{{$item['id']}}" name="delet[]" value="{{$item['id']}}" {{ (isset($AdditionalPermissions) and--}}
            {{--                        $AdditionalPermissions->delet==true) ?'checked' : ''}}>--}}
            {{--                    <label class="custom-control-label" for="delet{{$item['id']}}">Eliminar</label>--}}
            {{--                </div>--}}

            {{--            </td>--}}

        </tr>
    @else
        <tr style="font-weight:600">
            <td colspan="6">

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="menu_id{{$item['id']}}" name="menu_id[]" class="submenu{{$item['id']}} submenu" value="{{$item['id'].'@'.$item['parent']}}"
                            {{ (isset($arrPermission) and in_array($item['id'], $arrPermission)) ?'checked' : ''}}>
                    <label class="custom-control-label" for="menu_id{{$item['id']}}">{{$item['name']}} </label>
                </div>

            </td>
        </tr>
        @include('admin.rol.list-submenu-permission-rol', [ 'item' => $item, 'idRol'=> isset($idRol) ? $idRol : '' ])
    @endif
@endforeach

