<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\User\CustomerPanelServices;
use Illuminate\Http\Request;

class PickController extends Controller
{
    public function __construct(protected CustomerPanelServices $panel)
    {
    }
    
    /**
     * Historial de picks que recibió el cliente, con su resultado.
     */
    public function index(Request $request)
    {
        return $this->panel->picks($request->only('result'));
    }
}
