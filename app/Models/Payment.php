<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    const PAYMENT_SUCCESS = 'succeeded';
    const PAYMENT_FAIL    = 'failed';
    // Pago duplicado devuelto automáticamente (ver WhopWebhookServices::refundDuplicatePayment)
    const PAYMENT_REFUNDED = 'refunded';
    
    
    protected $table = 'payments';
    
    protected $fillable = [
        'payment_id',
        'status',
        'substatus',
        'total',
        'currency',
        'paid_at',
        'whop_user_id',
        'username',
        'plan_id',
        'company_id',
        'card_brand',
        'card_last4',
        'website_plan',
        'website_user_id',
    ];
    
    // Casts recomendados para asegurar que las fechas y tipos de datos se manejen correctamente
    protected $casts = [
        'total'           => 'decimal:2',
        'paid_at'         => 'datetime',
        'website_user_id' => 'integer',
    ];
    
    public static function getPayments()
    {
        return self::select(
            'users.id',
            'users_profiles.first_name',
            'users_profiles.last_name',
            'users_profiles.phone',
            'users.email',
            'payments.substatus',
            'payments.total',
            'payments.website_plan',
            'payments.paid_at',
            'payments.currency',
            'payments.payment_id',
            'payments.card_brand',
            'payments.card_last4'
        )
            ->join('users', 'payments.website_user_id', '=', 'users.id')
            ->join('users_profiles', 'users.id', '=', 'users_profiles.user_id');
    }
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        // Agrupado: sin el paréntesis, el OR anulaba el filtro por user_id y un cliente veía pagos ajenos
        if (isset($filters['search'])) {
            $search = "%" . $filters['search'] . "%";
            $query->where(function ($q) use ($search) {
                $q->where('users.email', 'like', $search)
                    ->orWhere('users_profiles.first_name', 'like', $search)
                    ->orWhere('users_profiles.last_name', 'like', $search)
                    ->orWhere('payments.payment_id', 'like', $search);
            });
        }
        
        if (isset($filters['user_id'])) {
            $query->where('users.id', $filters['user_id']);
        }
        
        if (isset($filters['input_status']) && ($status = status_payment($filters['input_status']))) {
            $query->where('payments.substatus', $status);
        }
        
        
        if (isset($filters['start_date'])) {
            $query->whereDate('payments.paid_at', '>=', $filters['start_date']);
        }
        
        if (isset($filters['end_date'])) {
            $query->whereDate('payments.paid_at', '<=', $filters['end_date']);
        }
        
        $query->orderBy('payments.paid_at', 'DESC');
        
        return $query;
    }
}