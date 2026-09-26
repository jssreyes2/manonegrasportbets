<?php

namespace App\Services\Reports;

use App\Exports\SubscriptionExport;
use App\Exports\UserExport;
use App\Models\Plan;
use App\Models\Rol;
use App\Models\User;
use App\Repositories\Settings\UserRepository;

class ReportUserServices
{
    
    public function prepareViewIndexData(array $data)
    {
        
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $filter['rol_id']=Rol::ROL_CUSTOMER;
        $filter['completed_profile']=true;
        
        $viewData = [
            'users'  => UserRepository::getUserProfile($filter)->paginate(config('app.npage')),
            'filter' => $filter,
        ];
        
        return view('admin.report.table-users', $viewData);
    }
    
    
    public function exportExcelUser($request)
    {
        $filter = [];
        if ($request->filter) {
            $filter = $request->filter;
        }
        
        $typeUser = 'USUARIOS';
        
        if ($request->rol == Rol::ROL_CUSTOMER) {
            $typeUser = 'CLIENTES';
        }
        
        if ($request->rol == Rol::ROL_FREELANCER) {
            $typeUser = 'FREELANCERS';
        }
        
        return (new UserExport($filter))->download(strtolower($typeUser) . '_' . date('Ymd_His') . '.xlsx');
    }
    
    
    public function getUserSubscription($request)
    {
        $filter = $request->filter ?? [];
        $id     = $request->id ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $request->id]);
        }
        
        $subscriptions = UserRepository::getUserSubscription($filter)->paginate(30);
        $plans         = Plan::where('is_active', true)->get();
        
        return view('admin.report.table-users-subscriptions', compact('filter', 'subscriptions', 'plans'));
    }
    
    public function exportExcelSubscription($request)
    {
        $filter = [];
        if ($request->filter) {
            $filter = $request->filter;
        }
        
        return (new SubscriptionExport($filter))->download('suscripciones-' . date('Ymd_His') . '.xlsx');
    }
}
