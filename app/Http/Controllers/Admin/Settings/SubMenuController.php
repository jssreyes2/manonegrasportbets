<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SubMenuRequest;
use App\Services\Settings\SubMenuServices;
use Illuminate\Http\Request;


class SubMenuController extends Controller
{
    // Inyecta SubMenuServices en el constructor
    public function __construct(protected SubMenuServices $subMenu){}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->subMenu->prepareViewIndexData($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->subMenu->prepareViewEditData($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(SubMenuRequest $request)
    {
        return $this->subMenu->updateSubMenu($request->all());
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->subMenu->deleteSubMenu($request->all());
    }

}
