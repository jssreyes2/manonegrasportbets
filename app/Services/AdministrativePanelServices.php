<?php

namespace App\Services;


use App\Models\Payment;
use App\Models\Rol;
use App\Models\Subscription;
use App\Repositories\Settings\UserRepository;
use App\Services\User\PaymentServices;
use Illuminate\Support\Facades\Auth;

class AdministrativePanelServices
{
    
    public function adminPanel()
    {
        
        if (Auth::user()->rol_id == Rol::ROL_CUSTOMER) {
            return redirect()->route('subscription');
        }
        
        $customersQuery  = UserRepository::getUserProfile(['rol_id' => Rol::ROL_CUSTOMER, 'completed_profile' => true]);
        $totalSuccessful = app(PaymentServices::class)->getPayments(['input_status' => 1])->sum('payments.total');
        $subscriptions   = Subscription::getSubscription()->filter()->count();
        
        
        return view('admin.dashboard', [
            'clients'            => $customersQuery->paginate(config('app.npage')),
            'totalCustomer'      => $customersQuery->count(),
            'totalSuccessful'    => $totalSuccessful,
            'totalSubscriptions' => $this->formatNumber($subscriptions),
        ]);
    }
    
    private function formatNumber($number): string
    {
        return $number > 10 ? (string)$number : '0' . $number;
    }
}                