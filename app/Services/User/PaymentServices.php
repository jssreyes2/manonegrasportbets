<?php

namespace App\Services\User;

use App\Models\Payment;
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
        if ($user && !$user->profile?->completed_profile) {
            return redirect()->route('profile');
        }
        
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $filter['user_id'] = $user->id;
    
        $payments = $this->getPayments($filter)->paginate(config('app.npage'));
        
        return view('dashboard.views.operations.table-my-payment', compact('filter', 'payments'));
    }
}