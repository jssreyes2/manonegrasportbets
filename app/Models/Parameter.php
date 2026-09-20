<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;
    
    protected $table = 'parameters';
    
    const   FOLDER_COMPANY = 'company';
    const   NAME_FILE      = 'logo';
    
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    
    
    public static function getParameter()
    {
        return self::first();
    }
    
    public static function getUSDConversion($value)
    {
        $parameter = self::first();
        
        return round($parameter->dollar_rate * $value, 2);
        
    }
    
    public static function saveParameter(array $data)
    {
        $obj = new self();
        

        $obj->company                  = $data['company'];
        $obj->phone                    = $data['phone'];
        $obj->identification           = strtoupper($data['identification']);
        $obj->address                  = $data['address'];
        $obj->email                    = $data['email'];
        
        $obj->save();
    }
    
    public static function updateParameter($request)
    {
        $obj = new self();
        $obj = $obj->find($request->id);
        
        $obj->dollar_rate              = $request->dollar_rate;
        $obj->vat_value                = $request->vat_value;
        $obj->invoice_number           = $request->invoice_number;
        $obj->igtf                     = $request->igtf;
        $obj->company                  = $request->company;
        $obj->phone                    = $request->phone;
        $obj->identification           = strtoupper($request->identification);
        $obj->address                  = $request->address;
        $obj->email                    = $request->email;
        $obj->social_network_facebook  = $request->social_network_facebook;
        $obj->social_network_instagram = $request->social_network_instagram;
        $obj->social_network_tiktok    = $request->social_network_tiktok;
        $obj->bank_id                  = $request->bank_id;
        $obj->identity_mobile_payment  = $request->identity_mobile_payment;
        $obj->phone_mobile_payment     = $request->phone_mobile_payment;
        
        $obj->save();
        
        return $obj;
    }
}
