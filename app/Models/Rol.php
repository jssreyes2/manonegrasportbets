<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;
    
    const ROL_ADMIN    = 1;
    const ROL_OPERATOR    = 2;
    const ROL_CUSTOMER = 3;
    const ROL_FREELANCER   = 4;
    const ROL_MENTOR   = 5;
    const ROL_MARKETPLACE  = 6;
    
    const ROL_INVENTED  = 7;

    protected $table = 'roles';
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    #Mutador Nombre
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    /**
     * ACCESOR: name_rol
     *
     * @return string
     */
    public function getNameRolAttribute()
    {
        return ucfirst(mb_strtolower($this->name, 'UTF-8'));
    }



    public static function saveRol(array $data)
    {
        $obj = new self();

        $obj->name      = mb_strtoupper($data['name']);
        $obj->is_active = $data['is_active'];
        $obj->save();

        return $obj;
    }

    public static function updateRol($data)
    {
        $obj = new self();
        $obj = $obj->find($data['id']);

        $obj->name      = mb_strtoupper($data['name']);
        $obj->is_active = $data['is_active'];
        $obj->save();

        return $obj;
    }
    
    public static function  registerPermissions(int $id, array $data)
    {
        RoleHasPermissions::where([['role_id', '=', $id]])->delete();
        
        $menuId = $data['menu_id'];
        
        $dataToInsert = [];
        
        foreach ($menuId as $item) {
            $idMenu = explode('@', $item);
            $menuIdValue = isset($idMenu[0]) ? (int)$idMenu[0] : 0;
            $parentValue = isset($idMenu[1]) ? (int)$idMenu[1] : 0;
            
            $dataToInsert[] = [
                'id_menu' => $menuIdValue,
                'parent'  => $parentValue,
                'role_id' => $id,
                'new'     => true,
                'edit'    => true,
                'delet'   => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        if (!empty($dataToInsert)) {
            RoleHasPermissions::insert($dataToInsert);
        }
    }
}
