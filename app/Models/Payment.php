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
            'payments.created_at',
            'payments.currency',
            'payments.payment_id'
        )
            ->join('users', 'payments.website_user_id', '=', 'users.id')
            ->join('users_profiles', 'users.id', '=', 'users_profiles.user_id');
    }
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->where('users.email', 'like', "%" . $filters['search'] . "%")
                ->orWhere('users_profiles.first_name', 'like', "%" . $filters['search'] . "%")
                ->orWhere('users_profiles.last_name', 'like', "%" . $filters['search'] . "%")
                ->orWhere('payments.payment_id', 'like', "%" . $filters['search'] . "%");
        }
        
        if (isset($filters['user_id'])) {
            $query->where('users.id', $filters['user_id']);
        }
        
        if (isset($filters['input_status'])) {
            $query->where('payments.substatus', status_payment($filters['input_status']));
        }
        
        $query->orderBy('payments.created_at', 'DESC');
        
        return $query;
    }
}