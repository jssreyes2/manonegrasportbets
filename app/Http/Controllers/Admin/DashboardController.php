<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Responsables\DashboardShow;
use App\Services\AdministrativePanelServices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected AdministrativePanelServices $administrativePanel)
    {
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->administrativePanel->adminPanel();
    }
}
