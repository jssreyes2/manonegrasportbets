<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\ValidRace;
use App\Services\AssignPointsServices;
use App\Services\AssignPositionServices;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function utilityMatch()
    {
        $statusCode = 200;

        $message = match ($statusCode) {
            200, 300 => 'es valido',
            400      => 'no es valido',
            500      => 'server error',
            default  => 'no se verifico el status',
        };

        return $message;
    }

    public function utilityArray(Request $request)
    {
        $value=$request->value;

        return [
            0=>'ACTIVE',
            1=>'INACTIVE',
        ][$value];

    }


    public function assignPoints(Request $request)
    {
        $validRaces = ValidRace::where('career_id', $request->career_id)->where('is_completed', true)->get();

        if(count($validRaces) <= 0){
            return 'No existe validas completadas';
        }

        foreach ($validRaces as $item) {
            $arrValidaComplete[] = $item->id;
        }

        $assignPoints = new AssignPointsServices();
        $assignPoints->UpdatePoint($arrValidaComplete);

        return 'Los puntos fueron asignados exitosamente';
    }

    public function assignPosition(Request $request)
    {
        $careerId=$request->career_id;

        if(empty($careerId)){
            return 'ingresa el id de la carrera';
        }

        $career = Career::where('id', $careerId)->where('status', Career::CARRER_COMPLETED)->first();

       if(!$career instanceof Career){
           return 'Solo se permite carrera completada';
       }

        $assignPosition = new AssignPositionServices();
        $assignPosition->UpdatePosition($careerId);

        return 'Las posiciones fueron asignadas exitosamente';
    }
}
