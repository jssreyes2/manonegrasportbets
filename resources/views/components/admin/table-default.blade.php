@props([
    'routeNewRegister' => null,
    'routeExport' => '',
    'paginate' => null,
    'cancelRoute' => '',
    'filter' => [],
    'showBtnNew' => true,
    'showStatus' => false,
    'extraFilterStatus' => false,
    'extraFilterPlans' => false,
    'extraFilterPageStatic' => false,
    'extraFilterLanguage' => false,
    'extraFilterStatusPick' => false,
    'dateFilter' => false,
    'plans' => []
])

<div class="card card-info card-outline">
    <div class="card-header">

        @if($showBtnNew)
            <a href="javascript:void(0)" class="btn btn-outline-info new_form"><i class="fas fa-plus"></i> Nuevo</a>
        @endif

        @if($routeExport)
            <a href="{{ $routeExport }}" class="btn btn-outline-dark"><i class="fas fa-file-excel"></i> Excel</a>
        @endif
    </div>


    <div class="card-body">
        @include('layouts.partials.filter-form', [
            'searchPlaceholder' => __t('text.backend.tables.search', 'Buscar...'),
            'clearRoute' => $cancelRoute,
            'filter' => $filter,
            'showStatus' => $showStatus,
            'extraFilterStatus' => $extraFilterStatus,
            'extraFilterPlans' => $extraFilterPlans,
            'extraFilterPageStatic' => $extraFilterPageStatic,
            'extraFilterLanguage' => $extraFilterLanguage,
            'extraFilterStatusPick' => $extraFilterStatusPick,
            'dateFilter' => $dateFilter,
        ])

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                {{ $slot }}
            </table>
        </div>

        <div class="d-flex">
            {!! $paginate !!}
        </div>
    </div>
</div>