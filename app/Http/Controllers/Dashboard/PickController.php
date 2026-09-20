<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PickController extends Controller
{
    /**
     * Mostrar los picks del día.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        /*
         * Picks de ejemplo.
         * Más adelante puedes obtenerlos desde la base de datos.
         */
        $picks = [
            [
                'sport' => 'MLB',
                'league' => 'MLB',
                'match' => 'Equipo A vs Equipo B',
                'pick' => 'Equipo A Moneyline',
                'odds' => '-135',
                'category' => 'Élite',
                'start_time' => '7:10 PM',
            ],
            [
                'sport' => 'MLB',
                'league' => 'MLB',
                'match' => 'Equipo C vs Equipo D',
                'pick' => 'Más de 8.5 carreras',
                'odds' => '-110',
                'category' => 'VIP',
                'start_time' => '8:05 PM',
            ],
        ];
        
        return view('dashboard.views.picks', [
            'user' => $user,
            'picks' => $picks,
        ]);
    }
}