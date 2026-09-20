<?php

namespace App\Models;

use App\Traits\GeneratesSlugsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory, SoftDeletes, GeneratesSlugsTrait;
    
    const ID_PLAN_FREE = 5;
    const ID_PLAN_ELITE = 1;
    const CURRENCY_USD = 'usd';
    const PLAN_SOURCE_SUSCRIPCION = 'suscripcion';
    const PLAN_SOURCE_VIP = 'vip';
    
    protected $table = 'plans';
    
    protected $fillable = [
        'name',
        'price',
        'is_active',
        'description',
        'recommended',
        'type_plan_id',
        'slug',
        'currency',
        'duration_days',
        'language',
    ];
    
    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class, 'plan_id');
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
    
    public function typePlan()
    {
        return $this->belongsTo(TypePlan::class, 'type_plan_id');
    }
    
    public static function savePlan($data)
    {
        $obj = new self();
        
        $obj->name         = mb_strtoupper($data['name']);
        $obj->price        = (float)$data['price'];
        $obj->is_active    = (int)($data['is_active'] ?? 0);
        $obj->recommended  = (int)($data['recommended'] ?? 0);
        $obj->type_plan_id = (int)$data['type_plan_id'];
        $obj->source       = $obj->generateSlug($data['name'], self::class);
        $obj->currency     = self::CURRENCY_USD;
        $obj->save();
        
        return $obj;
    }
    
    public static function updatePlan($obj, $data)
    {
        $obj->name         = mb_strtoupper($data['name']);
        $obj->price        = (float)$data['price'];
        $obj->is_active    = (int)($data['is_active'] ?? 0);
        $obj->recommended  = (int)($data['recommended'] ?? 0);
        $obj->type_plan_id = (int)$data['type_plan_id'];
        $obj->currency     = self::CURRENCY_USD;
        $obj->save();
        
        return $obj;
    }
    
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->where('name', 'like', "%" . $filters['search'] . "%");
        }
        
        if (isset($filters['id'])) {
            $query->where('id', $filters['id']);
        }
        
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        
        if (isset($filters['recommended'])) {
            $query->where('recommended', $filters['recommended']);
        }
        
        if (isset($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        
        if (isset($filters['language'])) {
            $query->where('language', $filters['language']);
        }
        
        $query->orderBy('price', 'ASC')->orderBy('language', 'ASC');
        
        return $query;
    }
}
