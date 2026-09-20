@extends('layouts.app-backend')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Principal</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$totalCustomer}}</h3>
                            <p>Clientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{route('get.report.user')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$totalFreelancers}}</h3>
                            <p>Freelancers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <a href="{{route('get.report.freelancers')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{$totalServiceRequests}}</h3>
                            <p>Solicitudes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <a href="{{route('service.requests')}}" class="small-box-footer">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
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

                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-blue">
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

                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$totalProducts}}</h3>
                            <p>Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{route('published.products')}}" class="small-box-footer"> Más Información <i class="fas fa-arrow-circle-right"></i></a>
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
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">CLIENTES PERFIL COMPLETADOS</h3>
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
