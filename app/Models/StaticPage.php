<?php

namespace App\Models;

use App\Traits\GeneratesSlugsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use HasFactory, SoftDeletes, GeneratesSlugsTrait;
    
    protected $table = 'static_pages';
    
    const TYPE_PRIVACY    = 'PRIVACY'; // Politicas de privacidad
    const TYPE_COOKIES    = 'COOKIES'; // Politicas de privacidad
    const TYPE_TERMS      = 'TERMS'; // Terminos y condiciones
    const TYPE_BLOG       = 'BLOG'; // Blog o noticias
    const TYPE_WHO_WE_ARE = 'WHO_WE_ARE'; // Quienes somos
    const TYPE_OBJETIVE   = 'OBJETIVE'; // Objetivo
    const TYPE_PHILOSOPHY = 'PHILOSOPHY'; // Filosofia
    
    const   FOLDER_PHOTO_PAGE = 'photo_page'; // carpeta donde se guardaran las imagenes
    const   FOLDER_BLOG       = 'blog'; // carpeta donde se guardaran las imagenes
    const   NAME_FILE         = 'photo'; //nombre de la imagen
    
    public static function saveStaticPage($data)
    {
        $obj = new self();
        
        $obj->title     = ucfirst(mb_strtolower($data['title'], 'UTF-8'));
        $obj->body      = $data['body'];
        $obj->is_active = $data['is_active'];
        $obj->type      = $data['type'];
        $obj->language  = $data['language'];
        $obj->source    = $obj->generateSlug($data['title'], self::class);
        $obj->save();
        
        return $obj;
    }
    
    public static function updateStaticPage($data)
    {
        $obj = new self();
        $obj = $obj->find($data['id']);
        
        if (!$obj) {
            return null;
        }
        
        $obj->title     = ucfirst(mb_strtolower($data['title'], 'UTF-8'));
        $obj->body      = $data['body'];
        $obj->is_active = $data['is_active'];
        $obj->type      = $data['type'];
        $obj->language  = $data['language'];
        $obj->source    = $obj->generateSlug($data['title'], self::class, 'source', $data['id']);
        $obj->save();
        
        return $obj;
    }
}
