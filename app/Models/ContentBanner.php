<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentBanner extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'content_banner';
    
    const   FOLDER_PHOTO_PAGE = 'photo_page'; // carpeta donde se guardaran las imagenes
    const   FOLDER_BANNER     = 'banner'; // carpeta donde se guardaran las imagenes
    const   NAME_FILE         = 'photo'; //nombre de la imagen
    
    public static function saveContentBanner($request)
    {
        $obj = new self();
        
        $obj->name        = $request->name;
        $obj->is_active   = $request->is_active;
        $obj->orden_photo = $request->orden_photo;
        
        $obj->save();
        
        return $obj;
    }
    
    
    public static function updateContentBanner($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);
        
        if (!$obj) {
            return null;
        }
        
        $obj->name        = $request->name;
        $obj->is_active   = $request->is_active;
        $obj->orden_photo = $request->orden_photo;
        
        $obj->save();
        
        return $obj;
    }
    
    public static function deleteContentBanner($id)
    {
        $obj = new self();
        
        $Rol = $obj->find($id);
        $obj->find($id)->delete();
        
        return $Rol;
    }

}
