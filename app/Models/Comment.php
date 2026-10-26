<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $table = 'comments';
    
    const MAX_LENGTH = 1000;
    
    // Asuntos del formulario público; la etiqueta se traduce con text.frontend.ux.subject_{valor}
    const SUBJECTS = ['suggestion', 'payment', 'picks', 'account', 'other'];
    
    protected function casts(): array
    {
        return ['is_testimonial' => 'boolean'];
    }
    
    /**
     * Comentarios que el admin marcó para publicarse como testimonio.
     */
    public static function testimonials(int $limit = 6)
    {
        return self::where('is_testimonial', true)->latest()->take($limit)->get();
    }
    
    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn($value) => $value, set: fn($value) => strtolower($value));
    }
    
    public static function saveComment(array $data)
    {
        $obj = new self();
        
        $obj->full_name   = $data['full_name'];
        $obj->email       = $data['email'];
        $obj->subject     = $data['subject'] ?? null;
        $obj->comment     = $data['comment'];
        
        $obj->save();
        
        return $obj;
    }
}
