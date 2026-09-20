<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Model
{
    use HasFactory;
    
    protected $table = 'users_profiles';
    
    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'first_name',
        'last_name',
        'phone',
        'country_id',
        'completed_profile',
    ];
    
    const   FOLDER_USER = 'users';
    const   NAME_FILE   = 'photo';
    
    
    public function rol()
    {
        return $this->hasOne(Rol::class, 'rol_id');
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    
    protected function firstName(): Attribute
    {
        return Attribute::make(get: fn($value) => $value, set: fn($value) => strtolower($value));
    }
    
    #Mutador Apellidos
    protected function lastName(): Attribute
    {
        return Attribute::make(get: fn($value) => $value, set: fn($value) => strtolower($value));
    }
    
    /**
     * ACCESOR: full_name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst(mb_strtolower($this->first_name, 'UTF-8')) . ' ' . ucfirst(mb_strtolower($this->last_name, 'UTF-8'));
    }
    
    public static function verifyPhoneExist($userId, $phone)
    {
        return self::where('id', '!=', $userId)->where('phone', $phone)->exists();
    }
    
    public static function updateProfile(array $data)
    {
        $country = Country::find($data['country_id']);
        
        if (!$country) {
            return false;
        }
        
        try {
            $normalizedPhone = normalizePhone($data['phone'], $country->code_phone);
        } catch (\Exception $e) {
            throw $e;
        }
        
        $userProfile = self::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'phone'             => $normalizedPhone,
                'country_id'        => $data['country_id'],
                'completed_profile' => true,
            ]
        );
        
        return $userProfile;
    }
}
