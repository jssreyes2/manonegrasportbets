<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'type',
        'name',
        'icono',
        'is_active',
        'position',
        'parent',
        'route',
        'language',
    ];
    
    protected $table = 'menus';
    
    
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent')->where('parent', 0);
    }
    
    public function children()
    {
        return $this->hasMany(self::class, 'parent');
    }
    
    #Mutador Nombre
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => ucwords(strtolower($value)),
        );
    }
    
    public static function saveMenu(array $data)
    {
        $isParentMenu = $data['type'] == 1;
        
        return self::create([
            'type'      => $data['type'],
            'name'      => $data['name'],
            'icono'     => $data['icono'],
            'is_active' => $data['is_active'],
            'position'  => $isParentMenu ? self::max('position') + 1 : 0,
            'parent'    => $isParentMenu ? 0 : $data['id_submenu'],
            'route'     => $data['route'],
            'language'     => $data['language'],
        ]);
    }
    
    public static function updateSubMenu(array $data)
    {
        
        $obj = new self();
        $obj = $obj->find($data['id']);
        $obj->name      = $data['name'];
        $obj->is_active = $data['is_active'];
        $obj->route     = $data['route'];
        $obj->save();
        
    }
    
}
