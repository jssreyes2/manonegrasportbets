<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ParameterRequest;
use App\Services\Settings\ParameterServices;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function __construct(protected ParameterServices $parameter){}
    
    public function index()
    {
        return $this->parameter->prepareViewIndexData();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParameterRequest $request)
    {
        return $this->parameter->storePatameter($request->validated());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(ParameterRequest $request)
    {
        return $this->parameter->updateParameter($request->validated());
    }
}
