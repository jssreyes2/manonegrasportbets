<div class="modal fade" id="modal-confirmation" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Validación requerida</h4>
                <button type="button" class="close close-form-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="id_register" name="id_register"/>
                <input type="hidden" id="route_controller" name="route_controller"/>
                <p>¿Proceder con la operación?</p>

                <div class="text-center loading_modal" style="display: none">
                    <img src="{{asset('img/loadingfrm.gif')}}">
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                    <button type="button" class="btn btn-block btn-outline-secondary close-form-modal">
                        <i class="fas fa-times"></i> No
                    </button>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                    <button type="button" class="btn btn-block btn-outline-info btn_modal_confirmation">
                        <i class="fas fa-check-circle"></i> Si
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>