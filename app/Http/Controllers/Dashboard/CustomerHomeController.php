<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\User\CustomerPanelServices;

class CustomerHomeController extends Controller
{
    public function __construct(protected CustomerPanelServices $panel)
    {
    }
    
    /**
     * Inicio del cliente: planes vigentes, picks de hoy y su rendimiento.
     */
    public function index()
    {
        return $this->panel->home();
    }
}
