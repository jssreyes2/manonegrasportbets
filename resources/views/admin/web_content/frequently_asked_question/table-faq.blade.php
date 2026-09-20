@extends('layouts.app-backend')
@section('title', 'Preguntas Frecuentes')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('faq.index')}}"
            paginate="{{ $faqs->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :extraFilterLanguage="true"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acciones</th>
            <th>Pregunta</th>
            <th style="text-align: center;">Posición</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Lenguaje</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($faqs) > 0)
            @foreach($faqs AS $item)

                @php
                    $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                @endphp

                <tr>
                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="faq"
                        />

                    </td>

                    <td>{{capitalize_first($item->question)}}</td>

                    <td style="text-align: center;"><span class="badge bg-info">{{$item->orden}}</span></td>

                    <td style="text-align: center;">
                        <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                    </td>

                    <td style="text-align: center;">
                        <span class="badge bg-info">{{$item->language}}</span>
                    </td>

                    <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif
        </tbody>
    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('faq.create')])
    @include('admin.web_content.frequently_asked_question.function-faq')
@endsection
