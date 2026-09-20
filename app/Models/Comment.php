<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $table = 'comments';
    
    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn($value) => $value, set: fn($value) => strtolower($value));
    }
    
    public static function saveComment(array $data)
    {
        $obj = new self();
        
        $obj->full_name   = $data['full_name'];
        $obj->email       = $data['email'];
        $obj->comment     = $data['comment'];
        
        $obj->save();
        
        return $obj;
    }
}
