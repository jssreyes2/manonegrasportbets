<?php

namespace App\Models;

use App\Traits\GeneratesSlugsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pick extends Model
{
    use HasFactory, SoftDeletes, GeneratesSlugsTrait;
    
    const SOURCE_SUSCRIPTION     = 'SUSCRIPTION';
    const SOURCE_WEB_SUSCRIPTION = 'JUGADAS FREE';
    
    protected $table = 'picks';
    
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
    
    protected $fillable = [
        'plan_id',
        'sport',
        'match',
        'bet_type',
        'selection',
        'detail',
    ];
    
    
    static function createPick(array $data)
    {
        
        $obj          = new self();
        $obj->plan_id = $data['plan_id'];
        $obj->body    = $data['body'];
        $obj->source  = $data['source'];
        $obj->save();
        
        return $obj;
    }
    
    static function editPick(array $data)
    {
        $obj        = self::findOrFail($data['id']);
        $obj->right = $data['right'];
        $obj->save();
        
        return $obj;
    }
    
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->whereHas('plan', function ($q) use ($filters) {
                $q->where('name', 'like', "%" . $filters['search'] . "%");
            })->orWhere('picks.body', 'like', "%" . $filters['search'] . "%");
        }
        
        if (isset($filters['id'])) {
            $query->where('picks.id', $filters['id']);
        }
        
        if (isset($filters['plan_id'])) {
            $query->where('picks.plan_id', $filters['plan_id']);
        }
        
        if (isset($filters['right_null'])) {
            $query->whereNull('picks.right');
        }
        
        if (isset($filters['input_status'])) {
            $query->where('picks.right', '=', $filters['input_status']);
        }
        
        if (isset($filters['source'])) {
            $query->where('picks.source', '=', $filters['source']);
        }
        
        $query->orderBy('picks.id', 'DESC');
        
        return $query;
    }
    
    static function getSourcePick()
    {
        $model      = new self();
        $reflection = new \ReflectionClass($model);
        $constants  = $reflection->getConstants();
        $sources    = [];
        
        foreach ($constants as $key => $value) {
            
            if (strpos($key, 'SOURCE_') === 0) {
                $sources[$key] = $value;
            }
        }
        
        return $sources;
    }
    
}
