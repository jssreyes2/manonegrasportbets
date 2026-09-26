@extends('layouts.app-backend')
@section('title', __t('text.backend.tables.my_payments', 'Mis Pagos'))
@section('content')

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$totalSuccessful}}</h3>
                    <p>{{ __t('text.backend.tables.successful_payments', 'Successful payments') }} </p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$totalFail}}</h3>
                    <p>{{ __t('text.backend.tables.failed_payments', 'Failed payments') }} </p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>



    <x-admin.table-default cancelRoute="{{ route('my.payment') }}"
                           paginate="{{ $payments->appends(request()->input())->links('pagination::bootstrap-4') }}"
                           :filter="$filter"
                           :showBtnNew="false"
                           :extraFilterStatusPick="true"
                           :extraFilterStatusPick="true"
                           :dateFilter="true"
                           routeExport=""
    >
        <thead>
        <tr>
            <th>{{__t('text.backend.tables.payment_id', 'Payment ID')}}</th>
            <th>{{__t('text.backend.tables.plan', 'Plan')}}</th>
            <th>{{__t('text.backend.tables.status', 'Status')}}</th>
            <th>{{__t('text.backend.tables.amount', 'Amount')}}</th>
            <th>{{__t('text.backend.tables.currency', 'Currency')}}</th>
            <th>{{__t('text.backend.tables.creation', 'Creation')}}</th>
        </tr>
        </thead>
        <tbody>
        @if (count($payments) > 0)
            @foreach ($payments as $payment)
                @php
                    $classStatus = $payment->substatus == \App\Models\Payment::PAYMENT_SUCCESS ? 'bg-success' : 'bg-danger';

                    $substatus=$payment->substatus=='succeeded' ? __t('text.backend.tables.successful', 'Successful'): __t('text.backend.tables.failed', 'Failed');

                @endphp

                <tr>

                    <td>{{ $payment->payment_id }}</td>
                    <td>{{ capitalize_first($payment->website_plan ?? '') }}</td>
                    <td><span class="badge {{$classStatus}}">{{$substatus}}</span></td>
                    <td>{{$payment->total}}</td>
                    <td>{{$payment->currency}}</td>
                    <td>{{ date('d/m/Y', strtotime($payment->paid_at)) }}</td>
                </tr>
            @endforeach
        @else
            @include('layouts.alert_warning')
        @endif

        </tbody>

    </x-admin.table-default>

@endsection

@section('script')
    @include('admin.global_script.function-form-modal', ['route' => route('my.payment')])
    @include('admin.operation.function-pick')
@endsection
