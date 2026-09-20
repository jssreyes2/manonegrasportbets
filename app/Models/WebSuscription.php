<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSuscription extends Model
{
    use HasFactory;
    
    protected $table = 'web_suscriptions';
    
    protected $fillable = [
        'full_name',
        'email' ,
        'send_email',
    ];
}
