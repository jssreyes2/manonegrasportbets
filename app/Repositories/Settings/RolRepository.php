<?php

namespace App\Repositories\Settings;


use App\Models\Rol;
use App\Models\Service;

class RolRepository
{
    
    public static function getRol(array $filter=[])
    {
        $query = Rol::select('*');
        
        if ($filter and (isset($filter['search']) and !empty($filter['search']))) {
            $query->where('name', 'like', "%" . $filter['search'] . "%");
        }
        
        if ($filter && isset($filter['is_active']) && in_array((int)$filter['is_active'], [0, 1], true)) {
            $query->where('is_active', (int) $filter['is_active']);
        }
        
        
        if ($filter and (isset($filter['id']) and !empty($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        $query->orderBy('name', 'ASC');
        
        return $query;
    }
    
}