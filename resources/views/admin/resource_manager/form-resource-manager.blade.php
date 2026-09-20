<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($resource))
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
                    <form role="form" id="frm-resource" enctype="multipart/form-data">

                        @if(isset($resource))
                            <input type="hidden" id="route" name="route" value='{{route('resource.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($resource) ? $resource->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('resource.store')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="name">Nombre *</label>
                                    <input type="text" class="form-control required input_string" id="name" name="name" maxlength="100" autocomplete="off" value='{{(isset($resource) ? $resource->name : '')}}'>
                                </div>

                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-12">
                                    <label for="category_id">Categorías</label>
                                    <select class='form-control required inputform' id='category_id' name="category_id">
                                        <option value=''>Seleccione...</option>
                                        @foreach($categories AS $item)
                                            <option value='{{$item->id}}' {{(isset($resource->category_id) and $resource->category_id==$item->id) ? 'selected=selected': ''}}>
                                                {{$item->name_category}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(isset($resource))
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                        @include('layouts.select_is_active', ['item' =>(isset($resource) ? $resource : null)])
                                    </div>
                                @endif

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="recommended">Descripción *</label>
                                    <textarea id="description" name="description" class="form-control" style="height: 100px;" maxlength="255">{{(isset($resource) ? $resource->description : '')
                                    }}</textarea>
                                    <small id="caracteres" class="text-muted">
                                        <span id="contador">0</span> / 255 caracteres
                                    </small>
                                </div>

                            </div>

                            <!-- Vista previa de archivo -->
                            <div class="row">
                                <div class="row form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div id="previewContainer"></div>
                                </div>
                            </div>

                            <!-- Subir Archivo -->
                            <div class="row">
                                <div class="row form-group col-lg-8 col-md-8 col-sm-12 col-12">
                                    <label for="file_pdf">Archvio</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file_pdf" name="file_pdf">
                                            <label class="custom-file-label" for="file_pdf" data-browse="Buscar">
                                                Seleccionar archivo
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Formatos aceptados: PDF. Tamaño máximo: 10MB
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Contenedor de vista previa -->
                                <div class="form-group col-lg-6 col-md-8 col-sm-12 col-12">
                                    <div id="image-preview-container" class="mt-2"></div>
                                </div>
                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('resource.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
