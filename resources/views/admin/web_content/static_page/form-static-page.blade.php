<x-admin.modal-frm-default>
    <form role="form" id="frm-static-page">

        @if(isset($staticPage))
            <input type="hidden" id="route" name="route" value='{{route('staticpage.update')}}'>
            <input type="hidden" id="id" name="id" value='{{(isset($staticPage) ? $staticPage->id : '')}}'>
        @else
            <input type="hidden" id="route" name="route" value='{{route('staticpage.store')}}'>
        @endif

        <div class="card-body">
            <div class="row">

                @if($staticPage->photo ?? false)
                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                        <img src="{{ url('storage/blog/' . $staticPage->id.'/'.$staticPage->photo) }}" style="width: 150px; height: 150px;  object-fit: cover">
                    </div>
                @endif

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="title">Titulo *</label>
                    <input type="text" class="form-control required input_string" id="title" name="title" maxlength="200" autocomplete="off" value='{{(isset($staticPage) ? $staticPage->title : '')}}'>
                </div>

                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                    <label for="body">Contenido *</label>
                    <textarea id="summernote" name="body" class="summernote">{{(isset($staticPage) ? $staticPage->body : '')}}</textarea>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    @include('layouts.select_is_active', ['item' =>$staticPage ?? null])
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                    <label for="type">Tipo *</label>
                    <select class='form-control required inputform' id='type' name="type">
                        <option value=''>
                            Seleccione...
                        </option>

                        @foreach(staticPageTypes() AS $key=>$item)
                            <option value='{{$key}}' {{((isset($staticPage) and $staticPage->type==$key) ?  'selected': '')}}>
                                {{$item}}
                            </option>
                        @endforeach

                    </select>
                </div>

                <x-admin.select-language
                        :form="true"
                        :item="$staticPage ?? null"
                />

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

            <div class="row div_photo_content">
                <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                    <div id="image-preview-container" class="mt-2"></div>
                </div>
            </div>

        </div>

        @include('layouts.button-from-modal', ['route_cancel' => route('staticpage.index')])
    </form>
</x-admin.modal-frm-default>

<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="application/javascript">
    $('#summernote').summernote({
        height: 200, // Altura en píxeles
        minHeight: 200, // Altura mínima
        maxHeight: 500, // Altura máxima
        focus: true
    });
</script>