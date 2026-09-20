<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($subCategory))
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
                    <form role="form" id="frm-sub-category">

                        @if(isset($subCategory))
                            <input type="hidden" id="route" name="route" value='{{route('subcategory.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($subCategory) ? $subCategory->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('subcategory.store')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="category_id">Categorías</label>
                                    <select class='form-control required inputform select2' id='category_id' name="category_id">
                                        <option value=''>
                                            Seleccione...
                                        </option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($subCategory) and $subCategory->category_id==$item->id) ?  'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="name">Nombre *</label>
                                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="30" autocomplete="off" value='{{(isset($subCategory) ? $subCategory->name_subcategory : '')}}'>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    @include('layouts.select_is_active', ['item' =>(isset($subCategory) ? $subCategory : null)])
                                </div>
                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('subcategory.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>