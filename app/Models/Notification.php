<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Builder;
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
    
    protected $attributes = [
        'state'    => 'pendiente',
        'intentos' => 0,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function events()
    {
        return $this->hasMany(NotificationEvent::class);
    }
    
    public static function generateTrackingToken(): string
    {
        return bin2hex(random_bytes(32));
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
    
    public static function getNotifications(){
        return self::select(
            'users.id',
            'users_profiles.first_name',
            'users_profiles.last_name',
            'users_profiles.phone',
            'notifications.channel',
            'notifications.type',
            'notifications.addressee',
            'notifications.subject',
            'notifications.state',
            'notifications.shipping_date',
            'notifications.opening_date',

        )
            ->join('users', 'notifications.user_id', '=', 'users.id')
            ->join('users_profiles', 'users.id', '=', 'users_profiles.user_id');
    }
    
    public function scopeFilter(Builder $query, ?array $filters = []): Builder
    {
        $filters = $filters ?? [];
        
        if (isset($filters['search'])) {
            $query->where('addressee', 'like', "%" . $filters['search'] . "%")
                ->orWhere('notifications.type', 'like', "%" . $filters['search'] . "%")
                ->orWhere('notifications.state', 'like', "%" . $filters['search'] . "%")
                ->orWhere('notifications.channel', 'like', "%" . $filters['search'] . "%")
                ->orWhere('notifications.type', 'like', "%" . $filters['search'] . "%");
        }
        
        if (isset($filters['id'])) {
            $query->where('notifications.id', $filters['id']);
        }
        
        if (isset($filters['start_date'])) {
            $query->whereDate('notifications.shipping_date', '>=', $filters['start_date']);
        }
        
        if (isset($filters['end_date'])) {
            $query->whereDate('notifications.shipping_date', '<=', $filters['end_date']);
        }
        
        $query->orderBy('notifications.id', 'DESC');
        
        return $query;
    }
}
