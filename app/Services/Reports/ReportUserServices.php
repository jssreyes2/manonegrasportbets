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
    
    public function prepareViewIndexData($request)
    {
        $filter = $request->filter ?? [];
        $id     = $request->id ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $request->id]);
        }
        
        $filter = array_merge($filter, ['rol_id' => $request->rol, 'completed_profile' => true]);
        
        $users = UserRepository::getUserProfile($filter);
        
        $typeUser         = 'USUARIOS';
        $routeBack        = "get.report.user";
        $btnViewProfile   = false;
        $routeExportExcel = 'excel.report.customer';
        
        if ($request->rol == Rol::ROL_CUSTOMER) {
            $typeUser = 'CLIENTES';
        }
        
        if ($request->rol == Rol::ROL_FREELANCER) {
            $typeUser         = 'FREELANCERS';
            $routeBack        = "get.report.freelancers";
            $btnViewProfile   = true;
            $routeExportExcel = 'excel.report.freelancers';
        }
        
        
        $viewData = [
            'filter'           => $filter,
            'users'            => $users->paginate(30),
            'typeUser'         => $typeUser,
            'routeBack'        => $routeBack,
            'btnViewProfile'   => $btnViewProfile,
            'routeExportExcel' => $routeExportExcel,
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
