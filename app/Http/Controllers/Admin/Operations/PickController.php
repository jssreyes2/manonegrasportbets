<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operation\PickRequest;
use App\Services\Operations\PickServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PickController extends Controller
{
    public function __construct(protected PickServices $pick){}
    
    
    public function index(Request $request)
    {
        return $this->pick->index($request->all());
    }
    
    public function create()
    {
        return $this->pick->create();
    }
    public function edit(Request $request):view
    {
        return $this->pick->edit($request->all());
    }
    
    public function store(PickRequest $request)
    {
        return $this->pick->store($request->all());
    }
    public function update(Request $request)
    {
        return $this->pick->update($request->all());
    }
    
    public function destroy(Request $request)
    {
        return $this->pick->destroy($request->all());
    }
    
    public function verifyPick(Request $request)
    {
        return $this->pick->verifyPick($request->all());
    }
   
}
