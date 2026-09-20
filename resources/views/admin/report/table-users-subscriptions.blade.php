@extends('layouts.app-backend')

@section('content')

    <div id="expediente-modal"></div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Suscripciones</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card card-purple card-outline">

                    <form role="form">
                        <div class="card-body">
                            <div class="row">
                                @include('layouts.search', [$filter, 'doNotShowStatus' => true])

                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="is_approved">Estatus</label>
                                    <select class='form-control' id='is_approved' name="filter[is_approved]">
                                        <option value=''>Seleccione...</option>
                                        <option value='1' {{ (array_key_exists('is_approved', $filter) && $filter['is_approved'] === '1') ? 'selected' : '' }}>
                                            Aprobado
                                        </option>
                                        <option value='0' {{ (array_key_exists('is_approved', $filter) && $filter['is_approved'] === '0') ? 'selected' : '' }}>
                                            Por aprobar
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="plan_id">Planes</label>
                                    <select class='form-control' id='plan_id' name="filter[plan_id]">
                                        <option value=''>Seleccione...</option>

                                        @foreach($plans AS $item)
                                            <option value='{{$item->id}}' {{ (array_key_exists('plan_id', $filter) && (int)$filter['plan_id'] === $item->id) ? 'selected' : '' }}>
                                                {{$item->name}}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="start_expiration_date">Fecha expiración inicio</label>
                                    <input type="date" class="form-control" id="start_expiration_date" name="filter[start_expiration_date]" value="{{isset($filter['start_expiration_date']) ? $filter['start_expiration_date']: ''}}">
                                </div>

                                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
                                    <label for="end_expiration_date">Fecha expiración final</label>
                                    <input type="date" class="form-control" id="end_expiration_date" name="filter[end_expiration_date]" value="{{isset($filter['end_expiration_date']) ? $filter['end_expiration_date']: ''}}">
                                </div>
                            </div>
                        </div>

                        @include('layouts.button-from-table', ['route_cancel' => route('get.user.subscription'), 'new'=>false, 'download_report' => route('excel.report.subscription', ['filter' =>$filter])])
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($subscriptions)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">SUSCRIPCIONES</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Plan</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha expiración</th>
                                    <th>Dias restantes</th>
                                    <th>Status</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subscriptions AS $item)

                                    @php

                                        $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';

                                        $responseApproved=(status_register($item->is_approved) =='Activo' ? 'Aprobado': 'Por aprobar');

                                           if(daysRemaining($item->expiration_date) <=0){
                                                $classStatus = 'bg-danger';

                                                $responseApproved='Vencido';
                                           }

                                    @endphp

                                    <tr>
                                        <td>{{$item->email}}</td>
                                        <td>{{tranform_string($item->rol_name)}}</td>
                                        <td>{{tranform_string($item->plan_name)}}</td>
                                        <td>{{date_formt($item->payment_date)}}</td>
                                        <td>{{date_formt($item->expiration_date)}}</td>
                                        <td>{{daysRemaining($item->expiration_date)}}</td>
                                        <td>
                                            <span class="badge {{$classStatus}}">{{$responseApproved}}</span>
                                        </td>
                                        <td>{{date_formt($item->created_at)}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $subscriptions])

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            @endif
        </div>

    </section>
    <!-- /.content -->

@endsection
