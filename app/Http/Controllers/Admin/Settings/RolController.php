<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\RolRequest;
use App\Services\Settings\RolServices;
use Illuminate\Http\Request;


class RolController extends Controller
{
    // Inyecta RolServices en el constructor
    public function __construct(protected RolServices $rol){}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->rol->prepareViewIndexData($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->rol->prepareViewCreateData();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->rol->prepareViewEditData($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolRequest $request)
    {
        return $this->rol->createRol($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(RolRequest $request)
    {
        return $this->rol->updateRol($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        return $this->rol->deleteRol($request->all());
    }
}
