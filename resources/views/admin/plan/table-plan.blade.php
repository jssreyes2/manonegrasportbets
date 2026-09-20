@extends('layouts.app-backend')
@section('title', 'Planes')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('plan.index')}}"
            paginate="{{ $plans->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :extraFilterLanguage="true"
    >
        <thead>

        <tr>
            <th style="width: 10%!important; text-align: center">Acción</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Recomendado</th>
            <th>Tipo</th>
            <th style="text-align: center;">Estatus</th>
            <th style="text-align: center;">Lenguaje</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($plans) > 0)
            @foreach($plans AS $plan)
                @php
                    $classStatus = $plan->is_active == 1 ? 'bg-success' : 'bg-danger';
                @endphp
                <tr>
                    <td style="text-align: center">
                        <x-admin.actions-dropdown
                                :item="$plan"
                                :delete="false"
                                route="plan"
                        />
                    </td>
                    <td>{{capitalize_first($plan->name)}}</td>
                    <td>{{$plan->price}}</td>
                    <td>{{convert_option($plan->recommended)}}</td>
                    <td>{{capitalize_first($plan?->typePlan?->name)}}</td>
                    <td style="text-align: center;">
                        <span class="badge {{$classStatus}}">{{status_register($plan->is_active)}}</span>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge bg-info">{{$plan->language}}</span>
                    </td>
                    <td>{{date('d/m/Y', strtotime($plan->created_at))}}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif
        </tbody>
    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('plan.create')])
    @include('admin.plan.function-plan')
@endsection