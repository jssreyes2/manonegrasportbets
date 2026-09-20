@extends('layouts.heard_landing')

@section('content')
    <section class="page-section">
        <div class="container">

            <div class="row" style="margin-bottom: 15px;">
                <div class="form-group col-12" style="margin-bottom: 10px;">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h4 class="card-title">@if(isset($filter))Combinaciones Jugadas ${{$accumulatedAmount}} &nbsp;/&nbsp;Acumulado ${{$totalToBeDistributed}} &nbsp;/&nbsp; {{$total}}@endif
                                <div style="float: right">
                                    <a href="/rules" class="btn btn-info" target="_blank">
                                        Reglas
                                    </a>
                                </div>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="form-group col-12">
                    <div class="card card-lightblue">
                        <div class="card-body">
                            <div class="form-group col-12">
                                <form role="form">

                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="short_code">Ticket</label>
                                            <input type="text" class="form-control" id="short_code" name="filter[short_code]" value='{{(isset($filter['short_code']) ? $filter['short_code'] : '')}}'>
                                        </div>


                                        <div class="form-group col-4">
                                            <label for="racecourse_id">Hipódromos</label>
                                            <select class='form-control' id='racecourse_id' name="filter[racecourse_id]">
                                                @foreach($racecourses as $item)
                                                    <option value='{{$item->id}}' {{(isset($filter['racecourse_id']) and $filter['racecourse_id']==$item->id) ?  'selected=selected': ''}}>
                                                        {{$item->name_racecourse}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="event_date">Fecha del evento</label>
                                            <input type="text" class="form-control required date" id="event_date" name="filter[event_date]" maxlength="10" readonly='readonly' value='{{(isset($filter['event_date']) ? $filter['event_date'] : '')}}'>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="form-group col-12">
                                            <button type="submit" class="btn btn-success">
                                                Buscar
                                            </button>
                                            &nbsp;&nbsp;
                                            <a href="{{route('index')}}" class="btn btn-info">
                                                Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($validRaces))

                <div class="form-group col-12" style="margin-top: 10px;">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Validas Completadas</h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="text-center">Validas</th>
                                    <th class="text-left">Retirados</th>
                                    <th class="text-left">Primer Lugar</th>
                                    <th class="text-left">Segundo Lugar</th>
                                    <th class="text-left">Tercer Lugar</th>
                                </tr>
                                </thead>

                                <tbody>

                                @php
                                    $j=0;
                                    $x=1;
                                    $firstPlaceHorse=[];
                                @endphp

                                @foreach($validRaces AS $item)

                                    @php
                                        $arrRetired=null;
                                        $horse=null;
                                        if(isset($item['retired_horse'])){
                                             $arrRetired=json_decode($item['retired_horse'], true);
                                        }

                                        if(!empty($arrRetired)){
                                             foreach ($arrRetired as $retired) {

                                                 if(($retired < 10)){
                                                     $retired='0'.$retired;
                                                 }

                                                $horse.=$retired.',';
                                            }
                                        }

                                         if(!empty($horse)){
                                             $horse=substr($horse, 0, -1);
                                         }

                                         $firstPlaceHorse[]=$item['first_place'];

                                    @endphp

                                    <tr>
                                        <th class="text-center">{{$x}}</th>
                                        <th class="text-left">
                                            <span class="badge bg-danger">{{$horse}}</span>
                                        </th>
                                        <th class="text-left">
                                            <span class="badge bg-success">{{($item['first_place'] < 10) ? '0'.$item['first_place'] : $item['first_place']}}</span>
                                            @if($item['first_place_tie'])
                                                <span class="badge bg-success">{{($item['first_place_tie'] < 10) ? '0'.$item['first_place_tie'] : $item['first_place_tie']}}</span>
                                            @endif
                                        </th>
                                        <th class="text-left"><span class="badge bg-info">{{($item['second_place'] < 10) ? '0'.$item['second_place'] : $item['second_place']}}</span></th>
                                        <th class="text-left"><span class="badge bg-warning">{{($item['third_place'] < 10) ? '0'.$item['third_place'] : $item['third_place']}}</span></th>

                                    </tr>

                                    @php $j++; $x++; @endphp
                                @endforeach

                                <tr style="background-color: #e7e6e6">
                                    <th colspan="5">&nbsp;</th>

                                </tr>
                                <tr>
                                    <th colspan="5">
                                        <p>{{$firstPrize}}</p>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="form-group col-12" style="margin-top: 10px;">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tickets</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th class="text-center">Posición</th>
                                    <th>Ticket</th>
                                    <th>Fecha</th>
                                    <th></th>
                                    <th class="text-center">1ra Válida</th>
                                    <th class="text-center">2da Válida</th>
                                    <th class="text-center">3ra Válida</th>
                                    <th class="text-center">4ta Válida</th>
                                    <th class="text-center">5ta Válida</th>
                                    <th class="text-center">6ta Válida</th>
                                    <th class="text-center">Puntos</th>

                                </tr>
                                </thead>
                                <tbody>

                                @if(count($ticks) > 0)
                                    @php $i=0; @endphp
                                    @foreach ($ticks AS $item)
                                        @php
                                            $validRace=\App\Models\ValidRace::where('career_id','=', $item->career_id)->orderBy('valid_number', 'ASC')->get();

                                             $position='<span class="material-symbols-outlined" style="color:#ccc">stars</span>';
                                             if($item->position==1){
                                                $position='<span class="material-symbols-outlined" style="color:#79bf9e">stars</span>'.$item->position;
                                              }
                                              if($item->position==2){
                                                $position= '<span class="material-symbols-outlined" style="color:#0dcaf0">stars</span> '.$item->position;
                                              }
                                              if($item->position==3){
                                                $position='<span class="material-symbols-outlined" style="color:#e7818a">stars</span> '.$item->position;
                                              }
                                        @endphp

                                        <tr>
                                            <td class="text-center">{!! $position !!}</td>
                                            <td>{{$item->short_code}}</td>
                                            <td>{{\App\Helpers\date_formt($item->event_date)}}</td>
                                            <td>Caballos:</td>
                                            @foreach ($validRace as $valid)

                                                @php
                                                    $tickDetails=$item->tick_details()->where('valid_race_id', '=', $valid->id)->get();
                                                    $firstPlace=null;
                                                @endphp
                                                <td class="text-center">
                                                    @foreach ($tickDetails as $detail)

                                                        @php
                                                            $hourse=($detail->horse_number < 10) ? '0'.$detail->horse_number: $detail->horse_number;
                                                            if((isset($firstPlaceHorse[$i]) and $firstPlaceHorse[$i] === $detail->horse_number) or ($valid->first_place_tie === $detail->horse_number and $detail->first_place_tie)){
                                                                $firstPlace='<span style="color:#198754; font-weight: bold;">'.$hourse.'</span>';
                                                            }else{
                                                            $firstPlace=$hourse;
                                                            }
                                                        @endphp
                                                        {!! $firstPlace !!}
                                                    @endforeach
                                                </td>
                                                @php
                                                    $i++;
                                                    if($i===6){
                                                       $i=0;
                                                    }
                                                @endphp
                                            @endforeach

                                            <td class="text-center">{{$item->total_point}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (isset($ticks))
                                <div class="d-flex" style="padding: 10px;">
                                    {{ $ticks->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                            @else
                                <tr>
                                    <td colspan="12">
                                        <div class="alert alert-danger alert-dismissible">
                                            Upps!! No existen tickets para mostrar este día
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection

@section('script')
    <script type="application/javascript">

        $(function () {
            $("#event_date").datepicker({maxDate: 0, dateFormat: 'yy-mm-dd'});
        });

    </script>
@endsection
