@extends('layouts.app-backend')
@section('title', 'Páginas Estáticas')
@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('staticpage.index')}}"
            paginate="{{ $staticPages->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showStatus="true"
            :extraFilterPageStatic="true"
            :extraFilterLanguage="true"
    >
        <thead>
        <tr>
            <th style="width: 10%!important; text-align: center">Acciones</th>
            <th>Foto</th>
            <th>Titulo</th>
            <th>Página</th>
            <th>Slug</th>
            <th style="text-align: center;">Estatus</th>
            <th style="text-align: center;">Lenguaje</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($staticPages) > 0)
            @foreach($staticPages AS $item)

                @php
                    $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';

                @endphp

                <tr>
                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="staticpage"
                        />

                    </td>

                    <td>
                        <div class="image">
                            @if($item->photo)
                                <img src="{{ url('storage/blog/' . $item->id.'/'.$item->photo) }}" class="img-circle elevation-2" style="width: 30px; height: 30px; object-fit: cover">
                            @else
                                <img src="{{asset('img/logo.png')}}" class="img-circle elevation-2" style="width: 30px; height: 30px; object-fit: cover">
                            @endif

                        </div>
                    </td>

                    <td>{{capitalize_first($item->title)}}</td>

                    <td>{{page_style_translation($item->type)}}</td>

                    <td>{{$item->source}}</td>

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
    @include('admin.global_script.function-form-modal', ['route' => route('staticpage.create')])
    @include('admin.web_content.static_page.function-static-page')
@endsection
