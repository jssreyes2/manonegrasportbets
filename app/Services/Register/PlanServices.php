<?php

namespace App\Services\Register;

use App\Models\Plan;
use App\Models\TypePlan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PlanServices
{
    public function getPlans(?array $filter = [])
    {
        return Plan::filter($filter)->select([
            'id',
            'name',
            'price',
            'type_plan_id',
            'is_active',
            'recommended',
            'created_at',
            'description',
            'source',
            'duration_days',
            'language'
        ]);
    }
    
    public function index(array $data = []): View
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $plans = $this->getPlans($filter)->paginate(config('app.npage'));
        
        return view('admin.plan.table-plan', compact('filter', 'plans'));
    }
    
    public function frmPlanCreate(): view
    {
        $typePlans = TypePlan::filter(['is_active' => true])->get();
        
        return view('admin.plan.form-plan', compact('typePlans'));
    }
    
    public function frmPlanEdit(array $data): view
    {
        $plan = $this->getPlans(['id' => $data['id']])->first();
        
        $typePlans = TypePlan::filter(['is_active' => true])->get();
        
        return view('admin.plan.form-plan', compact('plan', 'typePlans'));
    }
    
    public function createPlan(array $data): JsonResponse
    {
        
        DB::beginTransaction();
        
        try {
            
            $data['name']         = mb_strtoupper($data['name']);
            $data['price']        = (float) $data['price'];
            $data['is_active']    = (int) ($data['is_active'] ?? 0);
            $data['recommended']  = (int) ($data['recommended'] ?? 0);
            $data['type_plan_id'] = (int) $data['type_plan_id'];
            
            $plan = Plan::savePlan($data);
            
            if (!$plan?->id) {
                return response()->json(['status' => 'fail', 'message' => 'No se pudo crear el plan, por favor verifique que los datos sean correctos']);
            }
            
            DB::commit();
            
        } catch (Exception $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function updatePlan(array $data): JsonResponse
    {
        $plan = Plan::find($data['id']);
        
        if (!$plan) {
            return response()->json(['status' => 'fail', 'message' => 'no se pudo actualizar el plan, por favor verifique que el plan exista']);
        }
        
        DB::beginTransaction();
        
        try {
            
            $data['name']         = mb_strtoupper($data['name']);
            $data['price']        = $data['price'];
            $data['is_active']    = $data['is_active'];
            $data['recommended']  = $data['recommended'];
            $data['type_plan_id'] = $data['type_plan_id'];
            
            Plan::updatePlan($plan, $data);
            
            DB::commit();
            
        } catch (Exception $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function deletePlan(array $data): JsonResponse
    {
        Plan::destroy($data['id']);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
}