<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\MenuRequest;
use App\Services\Settings\MenuServices;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Inyecta MenuServices en el constructor
    public function __construct(protected MenuServices $menu){}
    

    public function index(Request $request)
    {
        return $this->menu->prepareViewIndexData($request->all());
    }
    

    public function create()
    {
        return $this->menu->prepareViewCreateData();
    }
    

    public function edit(Request $request)
    {
        return $this->menu->prepareViewEditData($request->all());
        
    }
    

    public function store(MenuRequest $request)
    {
        return $this->menu->createMenu($request->all());
    }
    

    public function update(MenuRequest $request)
    {
        return $this->menu->updateMenu($request->all());
    }
    

    public function destroy(Request $request)
    {
        return $this->menu->deleteSubMenu($request->all());
    }
    
    
}
