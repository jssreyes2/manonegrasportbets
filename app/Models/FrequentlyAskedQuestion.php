<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrequentlyAskedQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'frequently_asked_questions';
    
    public static function saveFaq($request)
    {
        $obj = new self();
        
        $obj->question  = ucfirst(mb_strtolower($request->question, 'UTF-8'));
        $obj->answer    = $request->answer;
        $obj->orden     = $request->orden;
        $obj->is_active = $request->is_active;
        $obj->language  = $request->language;
        $obj->save();
        
        return $obj;
    }
    
    public static function updateFaq($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);
        
        $obj->question  = ucfirst(mb_strtolower($request->question, 'UTF-8'));
        $obj->answer    = $request->answer;
        $obj->orden     = $request->orden;
        $obj->is_active = $request->is_active;
        $obj->language  = $request->language;
        $obj->save();
        
        return $obj;
    }
    
    public static function deleteFaq($id)
    {
        $obj = new self();
        
        $Rol = $obj->find($id);
        $obj->find($id)->delete();
        
        return $Rol;
    }
}
