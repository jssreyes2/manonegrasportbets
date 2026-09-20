<x-admin.modal-frm-default>
    <form role="form" id="frm-plan">

        @if(isset($plan))
            <input type="hidden" id="route" name="route" value='{{route('plan.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($plan) ? $plan->id : '')}}'>
        @else
            <input type="hidden" id="route" name="route" value='{{route('plan.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="name">Nombre *</label>
                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="30" autocomplete="off" value='{{(isset($plan) ? $plan->name : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="price">Precio *</label>
                    <input type="text" class="form-control required input_number" id="price" name="price" maxlength="10" autocomplete="off" value='{{(isset($plan) ? $plan->price : '')}}'>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="recommended">Recomendado ? *</label>
                    <select class='form-control' id='recommended' name="recommended">
                        <option value='0' {{((isset($item) and empty($item->is_active)) ?  'selected': '')}}>
                            {{convert_option(0)}}
                        </option>

                        <option value='1' {{((isset($item) and $item->recommended==status_register($item->recommended)) ?  'selected': '')}}>
                            {{convert_option(1)}}
                        </option>
                    </select>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="type_plan_id">Tipo *</label>
                    <select class='form-control required inputform' id='type_plan_id' name="type_plan_id">

                        <option value=''>
                            Seleccione...
                        </option>

                        @foreach($typePlans AS $item)
                            <option value='{{$item->id}}' {{((isset($plan) and $plan->type_plan_id==$item->id) ?  'selected': '')}}>
                                {{$item->name}}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>(isset($plan) ? $plan : null)])
                </div>

            </div>

        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('plan.index')])
    </form>
</x-admin.modal-frm-default>