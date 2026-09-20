<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdministrativePanelServices;
use Illuminate\Http\Request;

class AdministrativePanelController extends Controller
{
    
    public function __construct(protected AdministrativePanelServices $administrativePanel)
    {
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPanel(Request $request)
    {
        return $this->administrativePanel->adminPanel();
    }
    
    public function dashboardPanel(Request $request)
    {
        return $this->administrativePanel->dashboardPanel($request->all());
    }
}
