@extends('layouts.app-backend')
@section('title', 'Admin')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$totalCustomer >= 10 ? $totalCustomer : '0'.$totalCustomer}}</h3>
                            <p>{{ __t('text.usuario', 'Users') }} </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{route('get.report.user')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$totalContacts}}</h3>
                            <p>Comentarios</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{route('staticpage.contacts')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$totalSubscriptions}}</h3>
                            <p>Suscripciones</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <a href="{{route('get.user.subscription')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


        <div class="row">

            @if(empty($clients))
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-gray-dark">
                        <div class="card-header">
                            <h3 class="card-title">USUARIOS PERFIL COMPLETADOS</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Nombres y Apellidos</th>
                                    <th>Correo electrónico</th>
                                    <th>Teléfono</th>
                                    <th>Status</th>
                                    <th>Creación</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tbody>
                                @foreach($clients AS $item)
                                    <tr>
                                        <td>{{ucwords($item['first_name'].' '.$item['last_name'])}}</td>
                                        <td>{{$item['email']}}</td>
                                        <td>{{$item['phone']}}</td>
                                        <td>{{(($item['is_active']) ? 'Activo' : 'Inactivo')}}</td>
                                        <td>{{date('d/m/Y', strtotime($item['created_at'])),}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @include('layouts.paginate', ['variable' => $clients])
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
