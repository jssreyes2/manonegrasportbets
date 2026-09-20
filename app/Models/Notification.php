<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    
    protected $table = 'notifications';
    
    const STATE_FAILED = 'failed';
    const STATE_SEND   = 'send';
    const CREATED_AT   = 'created_at';
    
    const TYPE_PICK                 = 'pick';
    const TYPE_WELCOME              = 'welcome';
    const TYPE_EXPIRED_SUBSCRIPTION = 'expired_subscription';
    const TYPE_SUBSCRIPTION         = 'subscription';
    const CHANNEL_EMAIL             = 'email';
    
    protected $fillable = [
        'user_id',
        'channel',
        'type',
        'addressee',
        'subject',
        'content',
        'state',
        'tracking_token',
        'intentos',
        'error_log',
        'shipping_date',
        'opening_date',
    ];
    
    protected $casts = [
        'user_id'       => 'integer',
        'intentos'      => 'integer',
        'shipping_date' => 'datetime',
        'opening_date'  => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];
    
    /**
     * Valores por defecto a nivel de modelo.
     * Complementa al DEFAULT 'pendiente' que ya tienes en la BD.
     */
    protected $attributes = [
        'state'    => 'pendiente',
        'intentos' => 0,
    ];
    
    // -------------------------
    // Relaciones
    // -------------------------
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function events()
    {
        return $this->hasMany(NotificationEvent::class);
    }
    
    /**
     * Genera un token único seguro de 64 caracteres (hex).
     * 32 bytes aleatorios -> 64 caracteres hex.
     */
    public static function generateTrackingToken(): string
    {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * ¿Se puede marcar como abierto?
     */
    public function canBeOpened(): bool
    {
        return $this->opening_date === null
               && $this->deleted_at === null;
    }
    
    /**
     * ¿Está en estado enviado?
     */
    public function isSent(): bool
    {
        return $this->state === 'enviado';
    }
    
    // -------------------------
    // Scopes útiles
    // -------------------------
    
    public function scopePending($query)
    {
        return $query->where('state', 'pendiente');
    }
    
    public function scopeSent($query)
    {
        return $query->where('state', 'enviado');
    }
    
    public function scopeFailed($query)
    {
        return $query->where('state', 'fallido');
    }
    
    public function scopeOpened($query)
    {
        return $query->where('state', 'abierto');
    }
    
    public function scopeForToken($query, string $token)
    {
        return $query->where('tracking_token', $token);
    }
    
    
    public static function notificationCreate(array $data)
    {
        return Notification::create([
            'user_id'        => $data['user_id'],
            'channel'        => $data['channel'],
            'type'           => $data['type'],
            'addressee'      => $data['addressee'],
            'subject'        => $data['subject'],
            'content'        => $data['content'],
            'tracking_token' => self::generateTrackingToken(),
            'state'          => Notification::STATE_SEND,
            'shipping_date'  => now(),
        ]);
    }
}
