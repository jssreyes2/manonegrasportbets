<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTransaction extends Model
{
    protected $table = 'logs';
    
    public static function saveTransaction(int $userId, array $payload): void
    {
        $obj = new self();
        
        $obj->user_id = $userId;
        $obj->payload = $payload;
        $obj->save();
    }
}
