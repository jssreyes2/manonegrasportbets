<x-admin.modal-frm-default>
    <form role="form" id="user">
        <input type="hidden" id="edit" name="edit" value='{{(isset($user) ? true : false)}}'>
        @csrf

        @if(isset($user))
            <input type="hidden" id="route" name="route" value='{{route('user.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($user) ? $user->id : '')}}'>

        @else
            <input type="hidden" id="route" name="route" value='{{route('user.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="email">Correo electrónico *</label>
                    <input type="text" class="form-control required" id="email" name="email" autocomplete="off" value='{{(isset($user) ? $user->email : '')}}'>
                </div>

                @if(!isset($user))
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                        <label for="password">Contraseña *</label>
                        <input type="password" class="form-control required" id="password" name="password" autocomplete="off" maxlength="15">
                    </div>
                @endif


                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>(isset($user) ? $user : null)])
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="rol_id">rol *</label>
                    <select class='form-control' id='rol_id' name="rol_id">
                        @foreach($roles as $item)
                            <option value='{{$item->id}}' {{(isset($user) and $user->rol_id==$item->id) ? 'selected': ''}}>
                                {{$item->name}}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <!-- Contenedor para los mensajes de error -->
                    <div id="error-messages" style="color: red;"></div>
                </div>

            </div>
        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('user.index')])
    </form>
</x-admin.modal-frm-default>