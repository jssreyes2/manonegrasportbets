@extends('layouts.app-backend')
@section('title', 'Notificaciones')
@section('content')

    @php
        if(isset($data['msg_error'])){
         session()->flash('error', $data['msg_error']);
     }
    @endphp

    <x-admin.table-default cancelRoute="{{ route('notification.index') }}"
                           paginate="{{ $notifications->appends(request()->input())->links('pagination::bootstrap-4') }}"
                           :filter="$filter"
                           :showBtnNew="false"
                           :dateFilter="true"
    >
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Email</th>
            <th>Estatus</th>
            <th>Canal</th>
            <th>Tipo</th>
            <th>Asunto</th>
            <th>Enviado</th>
            <th>Leído</th>
        </tr>
        </thead>
        <tbody>
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)

                <tr>
                    <td>{{ capitalize_first($notification->first_name.' '.$notification->last_name) }}</td>
                    <td>{{$notification->addressee}}</td>
                    <td>{{$notification->state}}</td>
                    <td>{{$notification->channel}}</td>
                    <td>{{$notification->type}}</td>
                    <td>{{$notification->subject}}</td>
                    <td>{{ date('d/m/Y', strtotime($notification->shipping_date)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($notification->opening_date)) }}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif

        </tbody>

    </x-admin.table-default>

@endsection
