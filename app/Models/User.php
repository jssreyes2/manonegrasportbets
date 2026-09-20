<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rol_id',
        'email',
        'password',
        'is_active'
    ];
    
    protected $table = 'users';
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
    
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }
    
    public function bank()
    {
        return $this->hasOne(BankingInformation::class, 'user_id');
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }
    
    #Mutador Email
    protected function email(): Attribute
    {
        return Attribute::make(get: fn($value) => $value, set: fn($value) => strtolower($value));
    }
    
    public static function saveUser(array $data): User
    {
        return User::updateOrCreate([
            'email' => $data['email'],
        ], [
            'rol_id'           => $data['rol_id'],
            'password'         => ($data['password']) ? Hash::make($data['password']) : null,
            'is_active'        => $data['is_active'],
            'accept_the_terms' => $data['the_terms'] ?? false
        ]);
    }
    
    public static function updateUser(array $data)
    {
        $user = self::findOrFail($data['id'] ?? Auth::id());
        
        $user->fill(array_filter([
            'email'     => $data['email'],
            'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : $user->is_active,
            'rol_id'    => $data['rol_id'],
        ], fn($value) => !is_null($value)));
        
        if (isset($data['password']) && !empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        
        $user->save();
        
        return $user;
    }
    
    public static function saveUserWeb(Request $request)
    {
        $obj = new self();
        
        $obj->email     = $request->email;
        $obj->password  = Hash::make($request->password);
        $obj->is_active = true;
        $obj->rol_id    = Rol::ROL_CUSTOMER;
        $obj->save();
        
        return $obj;
    }
}
