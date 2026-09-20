<?php

namespace App\Services;


use App\Models\Rol;
use App\Repositories\Settings\UserRepository;
use Illuminate\Support\Facades\Auth;

class AdministrativePanelServices
{
    
    public function adminPanel()
    {
        
        if (Auth::user()->rol_id == Rol::ROL_CUSTOMER) {
            return redirect()->route('subscription');
        }
        
        $customersQuery = UserRepository::getUserProfile(['rol_id' => Rol::ROL_CUSTOMER, 'completed_profile' => true]);
        
        return view('admin.dashboard', [
            'clients'              => $customersQuery->paginate(config('app.npage')),
            'totalCustomer'        => $customersQuery->count(),
            'totalFreelancers'     => $this->formatNumber(0),
            'totalServiceRequests' => $this->formatNumber(0),
            'totalContacts'        => $this->formatNumber(0),
            'totalSubscriptions'   => $this->formatNumber(0),
            'totalProducts'        => $this->formatNumber(0),
        ]);
    }
    
    private function formatNumber($number): string
    {
        return $number > 10 ? (string)$number : '0' . $number;
    }
}                