<?php

namespace App\Services\Operations;


use App\Jobs\MassiveUpdatePickJob;
use App\Models\Pick;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\WebSuscription;
use App\Services\Register\CategoryServices;
use App\Services\Register\PlanServices;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendMassivePickEmailJob;
use Illuminate\Support\Facades\Log;

class PickServices
{
    
    public function __construct(protected PlanServices $plan)
    {
    }
    
    public function getPick(array $filter = [])
    {
        return Pick::with('plan')->filter($filter);
    }
    
    
    public function index(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $picks = $this->getPick($filter)->paginate(config('app.npage'));
        
        return view('admin.operation.table-picks', compact('filter', 'picks'))->with('error', $data['msg_error'] ?? session('error'));
    }
    
    
    public function create()
    {
        $plans = $this->plan->getPlans()->get();
        
        $sources = Pick::getSourcePick();
        
        return view('admin.operation.frm-picks', compact('plans', 'sources'));
    }
    
    public function edit(array $data)
    {
        $pick = $this->getPick(['id' => $data['id']])->first();
        
        return view('admin.operation.frm-picks-accepted-status', compact('pick'));
    }
    
    public function store(array $data = [])
    {
        DB::beginTransaction();
        
        try {
            
            if ($data['source'] == PICK::SOURCE_SUSCRIPTION) {
                $plan = $this->plan->getPlans(['id' => $data['plan_id']])->first();
                
                if ($data && $plan->is_active) {
                    return response()->json(['status' => 'fail', 'message' => 'Para enviar el Pick del plan ' . $plan->name . ' debe estar inactivo, por favor verifique']);
                }
            }
            
            $pick = Pick::createPick($data);
            
            DB::commit();
            
            SendMassivePickEmailJob::dispatch($pick);
            
        } catch (Exception $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function update(array $data = [])
    {
        DB::beginTransaction();
        
        try {
            
            $pick = Pick::editPick($data);
            
            DB::commit();
            
            MassiveUpdatePickJob::dispatch($pick);
            
        } catch (Exception $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
    }
    
    public function destroy(array $data = [])
    {
        Pick::destroy($data['id']);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
    
    public function verifyPick(array $data = [])
    {
        $subscription = 0;
        if ($data['source'] == PICK::SOURCE_SUSCRIPTION) {
            
            $plan = Plan::find($data['plan_id']);
            
            $subscription = Subscription::getSubscription()->filter(['subscription_expires_at' => true, 'subscription_status' => Subscription::STATUS_ACTIVE, 'subscription_plan' => $plan->source])->count();
            
            if (!$subscription) {
                return response()->json(['status' => null, 'subscription' => 0]);
            }
        }
        
        $pick = $this->getPick(['plan_id' => (int)$data['plan_id'], 'right_null' => true, 'source' => Pick::SOURCE_SUSCRIPTION])->exists();
        
        return response()->json(['status' => $pick, 'subscription' => $subscription]);
    }
    
}