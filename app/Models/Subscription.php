<?php

namespace App\Models;

use App\Traits\GeneratesSlugsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, GeneratesSlugsTrait;
    
    const STATUS_ACTIVE  = 'active';
    const STATUS_EXPIRED = 'expirado';
    const PLAN_ELITE = 'elite';
    
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'user_id',
        'payment_date',
        'whop_membership_id',
        'subscription_status',
        'subscription_plan',
        'subscription_expires_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subscription_expires_at' => 'datetime',
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
    
    public static function getSubscription()
    {
        return Subscription::select(
            'subscriptions.id',
            'subscriptions.user_id',
            'subscriptions.payment_date',
            'subscriptions.whop_membership_id',
            'subscriptions.subscription_status',
            'subscriptions.subscription_plan',
            'subscriptions.subscription_expires_at',
            'subscriptions.quantity_pick',
            'subscriptions.winner',
            'subscriptions.sure_bettor',
            'subscriptions.created_at',
            'users.email',
            'users_profiles.first_name',
            'users_profiles.last_name',
            'users_profiles.phone',
            'countries.name as country_name'
        )
            ->join('users', 'subscriptions.user_id', '=', 'users.id')
            ->join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
            ->join('countries', 'users_profiles.country_id', '=', 'countries.id');
    }
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->where('users.email', 'like', "%" . $filters['search'] . "%")
                ->orWhere('users_profiles.first_name', 'like', "%" . $filters['search'] . "%")
                ->orWhere('users_profiles.last_name', 'like', "%" . $filters['search'] . "%")
                ->orWhere('countries.name', 'like', "%" . $filters['search'] . "%");
        }
        
        if (isset($filters['id'])) {
            $query->where('subscriptions.id', $filters['id']);
        }
        
        if (isset($filters['user_id'])) {
            $query->where('subscriptions.user_id', $filters['user_id']);
        }
        
        if (isset($filters['whop_membership_id'])) {
            $query->where('subscriptions.whop_membership_id', $filters['whop_membership_id']);
        }
        
        if (isset($filters['subscription_plan'])) {
            $query->where('subscriptions.subscription_plan', $filters['subscription_plan']);
        }
        
        if (isset($filters['subscription_expires_at'])) {
            $query->whereDate('subscriptions.subscription_expires_at', '>=', now()->format('Y-m-d'));
        }
        
        if (isset($filters['expired'])) {
            $query->whereDate('subscriptions.subscription_expires_at', '<=', now()->format('Y-m-d'));
        }
        
        if (isset($filters['subscription_status'])) {
            $query->where('subscriptions.subscription_status', $filters['subscription_status']);
        }
        
        if (isset($filters['not_send_email'])) {
            $query->whereNull('subscriptions.send_email');
        }
        
        if (isset($filters['send_email'])) {
            $query->whereNotNull('subscriptions.send_email');
        }
        
        if (isset($filters['now'])) {
            $query->whereDate('subscriptions.created_at', '=', now()->format('Y-m-d'));
        }
        
       if (isset($filters['winner'], $filters['subscription_plan']) && ($filters['subscription_plan'] === self::PLAN_ELITE)) {
            $query->where(function ($q) {
                $q->where('subscriptions.winner', '!=', true)
                    ->orWhereNull('subscriptions.winner');
            });
        }
        
        $query->orderBy('subscriptions.user_id', 'ASC');
        
        return $query;
    }
    
}
