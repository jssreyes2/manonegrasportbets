@extends('layouts.app-backend')
@section('title', 'Picks')
@section('content')

    <div id="form-modal"></div>

    @php
        if(isset($data['msg_error'])){
         session()->flash('error', $data['msg_error']);
     }
    @endphp

    <x-admin.table-default routeExport="" cancelRoute="{{ route('pick.index') }}"
                           paginate="{{ $picks->appends(request()->input())->links('pagination::bootstrap-4') }}"
                           :filter="$filter"
                           :extraFilterStatusPick="true"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acción</th>
            <th>Plan</th>
            <th>Contenido</th>
            <th>Estatus</th>
            <th>Origen</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if (count($picks) > 0)
            @foreach ($picks as $pick)
                @php

                    $right = '<span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Por definir</span>';
                    if ($pick->right == 1) {
                        $right = '<span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Exitoso</span>';
                    }
                    if ($pick->right === 0) {
                        $right = '<span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Fallido</span>';
                    }

                    $parts = extractPickParts($pick->body);
                    $totalParts = count($parts);
                @endphp

                <tr>
                    <td style="text-align: center">
                        <x-admin.actions-dropdown :item="$pick" route="pick"/>
                    </td>
                    <td>{{ capitalize_first($pick->plan->name ?? '') }}</td>
                    <td>
                        @if($totalParts > 0)
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                @foreach($parts as $index => $part)
                                    @php
                                        $isPlan = str_contains($part, 'Plan:') || $index == 0;
                                        $isCuota = str_contains($part, 'CUOTA') || str_contains($part, '-');
                                        $isApuesta = preg_match('/OVER|UNDER/', $part);
                                    @endphp

                                    @if($isPlan)
                                        <span class="fw-bold text-primary">{{ $part }}</span>
                                    @elseif($isCuota)
                                        <span class="badge bg-success text-white">{{ $part }}</span>
                                    @elseif($isApuesta)
                                        <span class="badge bg-info text-white">{{ $part }}</span>
                                    @else
                                        <span class="badge bg-light text-dark border">{{ $part }}</span>
                                    @endif

                                    @if($index < $totalParts - 1)
                                        <span class="text-muted mx-1">|</span>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Sin contenido</span>
                        @endif
                    </td>
                    <td>{!! $right !!}</td>
                    <td>{{$pick->source}}</td>
                    <td>{{ date('d/m/Y', strtotime($pick->created_at)) }}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif

        </tbody>

    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('pick.create')])
    @include('admin.operation.function-pick')
@endsection
