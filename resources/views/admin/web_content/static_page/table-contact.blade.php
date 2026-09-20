@extends('layouts.app-backend')

@section('content')

    <div id="form-modal"></div>

    <x-admin.table-default
            routeExport=""
            cancelRoute="{{route('staticpage.contacts')}}"
            paginate="{{ $contacts->appends(request()->input())->links('pagination::bootstrap-4') }}"
            :filter="$filter"
            :showBtnNew="false"
    >
        <tr>
            <th style="text-align: center">Acciones</th>
            <th>Nombres y Apellidos</th>
            <th>Correo Electrónico</th>
            <th>Comentario</th>
            <th>Respondido</th>
            <th>Creación</th>
        </tr>
        </thead>
        <tbody>
        @if(count($contacts) > 0)
            @foreach($contacts AS $item)
                @php
                    $classStatus='bg-danger';
                        if($item->answered==1){
                            $classStatus='bg-success';
                        }

                @endphp
                <tr>

                    <td style="text-align: center">

                        <x-admin.actions-dropdown
                                :item="$item"
                                route="comment"
                                :comment="true"
                                :edit="false"
                                :delete="false"
                        />

                    </td>

                    <td>{{capitalize_first($item->full_name)}}</td>

                    <td>{{$item->email}}</td>

                    <td>{{ Str::limit($item->comment, 70, '...') }} @if($item->path_file)
                            <a href="{{Storage::url($item->path_file)}}" target="_blank"><i class="fa fas fa-file-pdf"></i></a>
                        @endif</td>

                    <td><span class="badge {{$classStatus}}">{{($item->answered==1)?'SI':'NO'}}</span></td>

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
    @include('admin.global_script.function-form-modal', ['route' => route('comment.response')])
    @include('admin.web_content.static_page.function-comment-response')
@endsection
