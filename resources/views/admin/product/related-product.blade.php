<div class="row mt-4">
    <div class="col-12">
        <div class="card card-purple card-outline shadow">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-link mr-2"></i>Productos Relacionados
                </h3>
                <div class="card-tools">
                    <span class="badge badge-purple">{{ count($relatedProducts ?? []) }} productos</span>
                </div>
            </div>

            <div class="card-body">
                @if(isset($relatedProducts) && count($relatedProducts) > 0)
                    <div class="row">

                        <div class="card-body table-responsive p-0">
                            <div class="card card-solid">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        @foreach($relatedProducts AS $item)

                                            @php
                                                $classStatus = $item->is_active == 1 ? 'bg-success' : 'bg-danger';
                                                $classIsApproved = $item->is_approved == 1 ? 'bg-success' : 'bg-danger';

                                                $textIsApproved = $item->is_approved == 1 ? 'Aprobado' : 'Por aprobar';
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
                                                                <p class="text-muted text-sm"><b>Nombre: </b> {{$item->name_prod}} </p>
                                                                <p class="text-muted text-sm"><b>Estatus: </b>
                                                                    <span class="badge {{$classStatus}}">{{status_register($item->is_active)}}</span>
                                                                    @if($rolAdmin || $rolSeller)
                                                                        / <span class="badge {{$classIsApproved}}">{{$textIsApproved}}</span>
                                                                    @endif
                                                                </p>
                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa fa-briefcase"></i></span> Categoría: {{capitalize_first($item->category_name)}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-book"></i></span> Subcategoría: {{capitalize_first($item->subcategory_name)}}</li>
                                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-dollar-sign"></i></span>Precio: {{$item->price}}</li>

                                                                    {{-- Un solo li para todas las estrellas --}}
                                                                    <li class="small">
                                                                        {!! showStar($item->punctuation) !!}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">

                                                                @if(!empty($rolCustomer))
                                                                    <a href="{{route('product.detail', ['id' =>encrypt($item->id), 'back' =>encrypt($routeBack)])}}" title="Ver detalle del producto">
                                                                        <img src="{{ getImageUrl('products/'.$item->id, $item->photo) }}" class="img-circle img-fluid img-photo">
                                                                    </a>
                                                                @else
                                                                    <img src="{{ getImageUrl('products/'.$item->id, $item->photo) }}" class="img-circle img-fluid img-photo">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">

                                                        @if(!empty($rolAdmin))
                                                            <a class="btn btn-sm btn-outline-info" href="{{route('product.detail', ['id' =>encrypt($item->id), 'back' =>encrypt($routeBack)])}}"><i class="fas fa-search"></i> Ver</a>
                                                        @endif

                                                        @if(!empty($rolSeller))
                                                            <a class="btn btn-sm btn-outline-danger confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{route('user.destroy.product')}}"><i class="fas fa-trash"></i> Eliminar</a>
                                                            <a class="btn btn-sm btn-outline-primary" href="{{route('user.edit.product', ['id'=>encrypt($item->id)])}}"><i class="fas fa-pencil"></i> Modificar</a>
                                                            <a class="btn btn-sm btn-outline-info" href="{{route('product.detail', ['id' =>encrypt($item->id)])}}"><i class="fas fa-search"></i> Ver</a>
                                                        @endif

                                                        @if(!empty($rolCustomer))
                                                            <a class="btn btn-sm btn-outline-success" href="{{route('product.shopping', ['id' =>encrypt($item->id), 'back' =>encrypt($routeBack)])}}"><i class="fas fa-shopping-cart"></i> Comprar</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="alert alert-info alert-dismissible mb-0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info-circle"></i> Información</h5>
                        No se encontraron productos relacionados en la misma categoría.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>