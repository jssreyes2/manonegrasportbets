<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class TypePlan extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'type_plans';
    
    public function plans()
    {
        return $this->hasMany(Plan::class, 'type_plan_id');
    }
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->where('name', 'like', "%" . $filters['search'] . "%");
        }
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        
        
        $query->orderBy('id', 'ASC');
        
        return $query;
    }
}
