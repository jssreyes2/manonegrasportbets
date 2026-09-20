<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Responder
                </h4>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-purple card-outline">
                    <form role="form" id="frm-user-contact-email">

                        @if(isset($serviceRequest))
                            <input type="hidden" id="id" name="id" value='{{($serviceRequest->id??'')}}'>
                        @endif

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="full_name">Nombres y Apellido *</label>
                                    <input type="text" class="form-control required input_string" id="full_name" name="full_name" maxlength="200" autocomplete="off" readonly="readonly"
                                           value='{{(isset($customerProfile) ? capitalize_first($customerProfile->first_name.' '.$customerProfile->last_name) : '')}}'>
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="subject">Asunto *</label>
                                    <input type="text" class="form-control required input_string" id="subject" name="subject" readonly="readonly" value="{{$serviceRequest->subject}}">
                                </div>

                                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-12">
                                    <label for="description">Descripción *</label>
                                    <textarea id="summernote" name="description" class="summernote"></textarea>
                                </div>

                            </div>

                        </div>

                        @include('layouts.button-from-modal', ['route_cancel' => route('user.get.freelancer')])
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
        minHeight: 100, // Altura mínima
        maxHeight: 200, // Altura máxima
        focus: true
    });
</script>