<div class="card-footer">
    <div class="row">

        <div class="col-12 col-md-6 col-lg-1 mb-2">
            <button type="submit" class="btn btn-block btn-outline-info"><i class="fas fa-search"></i> Buscar</button>
        </div>
        <div class="col-12 col-md-6 col-lg-1 mb-2">
            <button type="button" class="btn btn-block btn-outline-secondary cancel-form" data-url="{{$route_cancel}}"><i class="fas fa-times"></i>  Cancelar</button>
        </div>

        @if(isset($new) and $new)
            <div class="col-12 col-md-6 col-lg-1 mb-2">
                <button type="button" class="btn btn-block btn-outline-success new_form"><i class="fas fa-check-circle"></i>  Nuevo</button>
            </div>
        @endif

        @if(isset($download_report))
            <div class="col-12 col-md-6 col-lg-1 mb-2">
                <button type="button" class="btn btn-block btn-outline-success download-report" data-url="{{$download_report}}"><i class="fas fa-file-excel"></i> Excel</button>
            </div>
        @endif

        @if(isset($download_report_pdf))
            <div class="col-12 col-md-6 col-lg-1 mb-2">
                <button type="button" class="btn btn-block btn-outline-info download-report" data-url="{{$download_report_pdf}}"><i class="fas fa-file-contract"></i> PDF</button>
            </div>
        @endif
    </div>
</div>
