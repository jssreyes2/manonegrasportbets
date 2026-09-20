<style>
    .img-thumbnail{
        max-width:100%!important;
        max-height:100%!important;
    }

</style>
<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(isset($contentsBanner))
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
                    <form role="form" id="frm-content-banner">

                        @if(isset($contentsBanner))
                            <input type="hidden" id="route" name="route" value='{{route('content.banner.update')}}'>
                            <input type="hidden" id="id" name="id" value='{{(isset($contentsBanner) ? $contentsBanner->id : '')}}'>
                        @else
                            <input type="hidden" id="route" name="route" value='{{route('content.banner.store')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                @if($contentsBanner->photo ?? false)
                                    <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                        <img src="{{ url('storage/photo_page/banner/' . $contentsBanner->photo) }}"  style="height: 150px;  object-fit: cover">
                                    </div>
                                @endif

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="name">Nombre *</label>
                                    <input type="text" class="form-control required" id="name" name="name" maxlength="200" autocomplete="off" value='{{(isset($contentsBanner) ? $contentsBanner->name : '')}}'>
                                </div>
                                    
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    @include('layouts.select_is_active', ['item' =>$contentsBanner ?? null])
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


                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="orden_photo">Orden *</label>
                                    <input type="text" class="form-control required input_number" id="orden_photo" name="orden_photo" maxlength="10" autocomplete="off" value='{{(isset($contentsBanner) ? $contentsBanner->orden_photo : '')}}'>
                                </div>
                            </div>

                            <div class="row div_photo_content">
                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <div id="image-preview-container" class="mt-2"></div>
                                </div>
                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('content.banner.index')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>