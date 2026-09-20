<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    const LANGUAGE_ES = 'es';
    const LANGUAGE_EN = 'en';
    
    
    protected $table = 'countries';
    
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'country_id');
    }
    
    public static function getCountryList()
    {
        return static::pluck('name', 'id');
    }
}
