<?php

namespace App\Repositories\Settings;


use App\Models\ProfileSubcategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    
    public static function getUser(array $filter = [])
    {
        $query = User::join('roles', 'users.rol_id', '=', 'roles.id')
            ->select([
                'users.id',
                'users.rol_id',
                'users.email',
                'users.is_active',
                'users.created_at',
                'roles.name'
            ]);
        
        
        if (isset($filter['search'])) {
            $query->where('users.email', 'like', "%" . $filter['search'] . "%");
        }
        
        
        if ($filter and (isset($filter['is_active']) and !empty($filter['is_active'])) or (isset($filter['is_active']) and (int)$filter['is_active'] === 0)) {
            $query->where('users.is_active', $filter['is_active']);
        }
        
        if ($filter and (isset($filter['id']))) {
            $query->where('users.id', $filter['id']);
        }
        
        if ($filter and (isset($filter['rol_id']))) {
            $query->where('users.rol_id', $filter['rol_id']);
        }
        
        if ($filter and (isset($filter['in_rol_id']))) {
            $query->whereIn('users.rol_id', $filter['in_rol_id']);
        }
        
        if ($filter and (isset($filter['email']))) {
            $query->where('users.email', $filter['email']);
        }
        
        $query->orderBy('users.id', 'ASC');
        
        return $query;
    }
    
    public static function getUserProfile(array $filter = [])
    {
        // Construir query base
        $query = User::leftJoin('users_profiles', 'users.id', '=', 'users_profiles.user_id')
            ->join('roles', 'users.rol_id', '=', 'roles.id');
        
        $query->select([
            'users.id',
            'users.email',
            'users.is_active',
            'users.created_at',
            'roles.id As rol_id',
            'roles.name',
            'users_profiles.id as profile_id',
            'users_profiles.first_name',
            'users_profiles.last_name',
            'users_profiles.phone',
            'users_profiles.country_id',
            'users_profiles.photo',
            'users_profiles.completed_profile',
        ]);
        
        // Resto de las condiciones...
        if ($filter && (isset($filter['search']))) {
            
            if ($filter and (isset($filter['search']))) {
                $searchTerm = $filter['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->WhereRaw("CONCAT(users_profiles.first_name, ' ', users_profiles.last_name) LIKE ?", ["%{$searchTerm}%"])
                        ->orWhere('users_profiles.first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('users_profiles.last_name', 'like', "%{$searchTerm}%");
                });
            }
            
        }
        
        if ($filter && (isset($filter['is_active']) && !empty($filter['is_active'])) or (isset($filter['is_active']) && (int)$filter['is_active'] === 0)) {
            $query->where('users.is_active', $filter['is_active']);
        }
        
        if ($filter && (isset($filter['id']))) {
            $query->where('users.id', $filter['id']);
        }
        
        if ($filter && (isset($filter['rol_id']))) {
            $query->where('users.rol_id', $filter['rol_id']);
        }
        
        if ($filter && (isset($filter['in_rol_id']))) {
            $query->whereIn('users.rol_id', $filter['in_rol_id']);
        }
        
        if ($filter && (isset($filter['email']))) {
            $query->where('users.email', $filter['email']);
        }
        
        if ($filter && (isset($filter['completed_profile']))) {
            $query->where('users_profiles.completed_profile', $filter['completed_profile']);
        }
        
        $query->orderBy('users.id', 'ASC');
        
        return $query;
    }
    
    public static function getProfileSubCatgories($profileId)
    {
        return ProfileSubcategory::join('users_profiles', 'profiles_subcategories.user_profile_id', '=', 'users_profiles.id')
            ->join('subcategories', 'profiles_subcategories.subcategory_id', '=', 'subcategories.id')
            ->select('profiles_subcategories.subcategory_id')
            ->where('profiles_subcategories.user_profile_id', $profileId)
            ->get()->toArray();
    }
    
    
    public static function getUserSubscription(?array $filter = [])
    {
        $query = User::join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->join('roles', 'users.rol_id', '=', 'roles.id')
            ->join('subscriptions_pays', 'subscriptions.id', '=', 'subscriptions_pays.subscription_id')
            ->select([
                'users.id',
                'users.email',
                'roles.name as rol_name',
                'plans.name as plan_name',
                'subscriptions.id AS subscription_id',
                'subscriptions.plan_id',
                'subscriptions.payment_date',
                'subscriptions.expiration_date',
                'subscriptions.is_active',
                'subscriptions.is_approved',
                'subscriptions.created_at',
                'subscriptions_pays.reference_number'
            ]);
        
        $latestSubscription = DB::table('subscriptions as s2')
            ->select('s2.user_id', DB::raw('MAX(s2.payment_date) as last_payment_date'))
            ->groupBy('s2.user_id');
        
        $query->joinSub($latestSubscription, 'latest_sub', function ($join) {
            $join->on('subscriptions.user_id', '=', 'latest_sub.user_id')
                ->on('subscriptions.payment_date', '=', 'latest_sub.last_payment_date');
        });
        
        if (isset($filter['search'])) {
            $query->where('users.email', 'like', "%" . $filter['search'] . "%");
        }
        
        if (isset($filter['is_approved'])) {
            $query->where('subscriptions.is_approved', $filter['is_approved']);
        }
        
        if (isset($filter['plan_id'])) {
            $query->where('subscriptions.plan_id', $filter['plan_id']);
        }
        
        if (isset($filter['start_expiration_date'])) {
            $query->whereDate('subscriptions.expiration_date', '>=', $filter['start_expiration_date']);
        }
        
        if (isset($filter['end_expiration_date'])) {
            $query->whereDate('subscriptions.expiration_date', '<=', $filter['end_expiration_date']);
        }
        
        $query->orderBy('subscriptions.id', 'DESC');
        
        return $query;
    }
    
    
    public static function getSuscriptionPay($id)
    {
        $query = DB::table('subscriptions')
            ->join('subscriptions_pays', 'subscriptions.id', '=', 'subscriptions_pays.subscription_id')
            ->join('users', 'subscriptions.user_id', '=', 'users.id')
            ->join('banks', 'subscriptions_pays.bank_id', '=', 'banks.id')
            ->select(
                'subscriptions.id',
                'subscriptions.user_id',
                'users.email',
                'subscriptions_pays.photo',
                'subscriptions.plan_id',
                'subscriptions_pays.reference_number',
                'subscriptions_pays.payment_date',
                'subscriptions_pays.amount',
                'subscriptions_pays.phone',
                'subscriptions_pays.identification',
                'subscriptions_pays.bank_id',
                'banks.bank'
            )
            ->where('subscriptions.id', $id);
        
        return $query;
    }
}
