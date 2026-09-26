<?php

namespace App\Services\User;

use App\Models\Payment;
use App\Models\Rol;
use App\Services\Register\CategoryServices;
use Illuminate\Support\Facades\Auth;

class PaymentServices
{
    
    public function __construct()
    {
    }
    
    
    public function getPayments(array $filter = [])
    {
        return Payment::getPayments()->filter($filter);
    }
    
    public function index(array $data = [])
    {
        $user = Auth::user();
        
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        if ($user && $user->rol_id == Rol::ROL_CUSTOMER && !$user->profile?->completed_profile) {
            return redirect()->route('profile');
        }
        
        $view = "dashboard.views.operations.table-my-payment";
        
        $filter['user_id'] = $user->rol_id == Rol::ROL_CUSTOMER ? $user->id : null;
        if ($user && $user->rol_id != Rol::ROL_CUSTOMER) {
            $view = "admin.operation.table-payment";
        }
        
        $payments = $this->getPayments($filter)->paginate(config('app.npage'));
        
        return view($view, compact('filter', 'payments'));
    }
}