<?php

namespace App\Http\Controllers\Admin\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\PlanRequest;
use App\Services\Register\PlanServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PlanController extends Controller
{
    public function __construct(protected PlanServices $plan){}

    public function index(Request $request): View
    {
        return $this->plan->index($request->all());
    }
    
    public function create():view
    {
        return $this->plan->frmPlanCreate();
    }
 
    public function edit(Request $request):view
    {
        return $this->plan->frmPlanEdit($request->all());
    }
    
    public function store(PlanRequest $request):JsonResponse
    {
        return $this->plan->createPlan($request->all());
    }
    
    public function update(PlanRequest $request):JsonResponse
    {
        return $this->plan->updatePlan($request->all());
    }
    
    public function destroy(Request $request):JsonResponse
    {
        return $this->plan->deletePlan($request->all());
    }
}
