<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($category))
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
                    <form role="form" id="frm-category">

                        @if(isset($category))
                            <input type="hidden" id="route" name="route" value='{{route('category.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($category) ? $category->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('category.store')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="name">Nombre *</label>
                                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="30" autocomplete="off" value='{{(isset($category) ? $category->name : '')}}'>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="destination">Destino *</label>
                                    <select class='form-control' id='destination' name="destination">
                                        <option value='{{\App\Models\Category::DESTINATION_WEB}}' {{((isset($category) and $category->destination==\App\Models\Category::DESTINATION_WEB) ?  'selected': '')}}>
                                            {{\App\Models\Category::DESTINATION_WEB}}
                                        </option>

                                        <option value='{{\App\Models\Category::DESTINATION_BACKEND}}' {{((isset($category) and $category->destination==\App\Models\Category::DESTINATION_BACKEND) ?  'selected': '')}}>
                                            {{\App\Models\Category::DESTINATION_BACKEND}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="description">Descipción *</label>
                                    <input type="text" class="form-control required input_string" id="description" name="description" maxlength="191" autocomplete="off" value='{{(isset($category) ? $category->description : '')}}'>
                                </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    @include('layouts.select_is_active', ['item' =>$category ?? null])
                                </div>
                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('category.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>