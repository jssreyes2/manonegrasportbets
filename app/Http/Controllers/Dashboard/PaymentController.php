<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\User\PaymentServices;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentServices $payment)
    {
    }
    
    public function index(Request $request)
    {
        return $this->payment->index($request->all());
    }
    
    /**
     * Recibo en PDF de un pago (por el ID de pago de Whop).
     */
    public function receipt(string $paymentId)
    {
        return $this->payment->receipt($paymentId);
    }
    
}
