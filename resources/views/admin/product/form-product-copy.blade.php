<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($staticPage))
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
                    <form role="form" id="frm-product">

                        @if(isset($staticPage))
                            <input type="hidden" id="route" name="route" value='{{route('user.store.product')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($staticPage) ? $staticPage->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('user.update.product')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                @if($staticPage->photo ?? false)
                                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                        <img src="{{ url('storage/blog/' . $staticPage->photo) }}"  style="width: 150px; height: 150px;  object-fit: cover">
                                    </div>
                                @endif

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="name_prod">Nombre *</label>
                                    <input type="text" class="form-control required input_string" id="name_prod" name="name_prod" maxlength="200" autocomplete="off" value='{{(isset($staticPage) ? $staticPage->name_prod : '')}}'>
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="description_prod">Descripción *</label>
                                    <textarea id="summernote" name="description_prod" class="summernote">{{(isset($staticPage) ? $staticPage->description_prod : '')}}</textarea>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="type">Categoría *</label>
                                    <select class='form-control required inputform select2' id='category_id' name="category_id">
                                        <option value=''>
                                            Seleccione...
                                        </option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($user->category_id) and $user->category_id==$item->id) ?  'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                        @include('layouts.select_is_active', ['item' =>$staticPage ?? null])
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                        <label for="price">Precio *</label>
                                        <input type="text" class="form-control required input_number" id="price" name="price" maxlength="200" autocomplete="off" value='{{(isset($staticPage) ? $staticPage->price : '')}}'>
                                    </div>
                            </div>

                            <div class="row div_photo_content">
                                <div class="row form-group col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div id="previewContainer"></div>
                                </div>
                            </div>

                            <div class="row div_photo_content">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="photo">Foto</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photo" name="photo">
                                            <label class="custom-file-label" for="photo" data-browse="Buscar">Seleccionar archivo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('staticpage.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="application/javascript">
    $('#summernote').summernote({
        height: 200, // Altura en píxeles
        minHeight: 200, // Altura mínima
        maxHeight: 500, // Altura máxima
        focus: true
    });
</script>