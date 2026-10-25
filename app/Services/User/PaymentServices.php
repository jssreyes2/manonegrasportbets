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

        // Monto y cantidad por estatus, respetando los filtros aplicados
        $totals = $this->getPayments($filter)
            ->reorder()
            ->select('payments.substatus')
            ->selectRaw('COUNT(*) AS quantity, COALESCE(SUM(payments.total), 0) AS amount')
            ->groupBy('payments.substatus')
            ->get()
            ->keyBy('substatus');

        $stats = collect([
            Payment::PAYMENT_SUCCESS  => ['label' => __t('text.backend.tables.successful_payments', 'Pagos exitosos'), 'icon' => 'fas fa-check', 'tone' => 'success'],
            Payment::PAYMENT_REFUNDED => ['label' => __t('text.backend.tables.refunded_payments', 'Pagos reembolsados'), 'icon' => 'fas fa-undo', 'tone' => 'warning'],
            Payment::PAYMENT_FAIL     => ['label' => __t('text.backend.tables.failed_payments', 'Pagos fallidos'), 'icon' => 'fas fa-times', 'tone' => 'danger'],
        ])->map(fn($stat, $status) => $stat + [
                'amount'   => (float)($totals[$status]->amount ?? 0),
                'quantity' => (int)($totals[$status]->quantity ?? 0),
            ]);

        return view($view, compact('filter', 'payments', 'stats'));
    }
}