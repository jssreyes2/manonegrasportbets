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
                        <li class="breadcrumb-item"><a href="#">{{capitalize_first($typeUser)}}</a></li>
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
                                @include('layouts.search', [$filter])
                            </div>
                        </div>

                        @include('layouts.button-from-table', ['route_cancel' => route($routeBack), 'new'=>false, 'download_report' => route($routeExportExcel, ['filter' =>$filter])])
                    </form>
                </div>
            </div>
        </div>

        <div class="row">

            @if(count($users)<=0)
                @include('layouts.alert_warning')
            @else

                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">{{$typeUser}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <div class="card card-solid">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        @foreach($users AS $item)

                                            @php
                                                $classStatus='bg-danger';
                                                    if($item->is_active==1){
                                                        $classStatus='bg-success';
                                                    }
                                            @endphp
                                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                                <div class="card bg-light d-flex flex-fill">
                                                    <div class="card-header text-muted border-bottom-0">
                                                        Creado: {{date('d/m/Y', strtotime($item->created_at))}}
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="lead"><b>{{capitalize_first($item->first_name.' '.$item->last_name)}}</b></h2>
                                                                <p class="text-muted text-sm"><b>Profesión: </b> {{$item->profession}} </p>
                                                                <p class="text-muted text-sm"><b>Estatus: </b> <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span></p>
                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> {{$item->address}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> {{$item->phone}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mail-bulk"></i></span> {{$item->email}}</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">
                                                                <img src="{{ getImageUrl('users/'.$item->id, $item->photo) }}" class="img-circle img-fluid img-photo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="text-right">

                                                            @if($btnViewProfile)
                                                                <a class="btn btn-sm btn-primary expediente" data-id="{{$item->id}}" data-url="{{route('user.get.freelancer.expediente')}}"><i class="fas fa-user"></i> Ver Perfil</a>
                                                            @else
                                                                <p></p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            @include('layouts.paginate', ['variable' => $users])

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
