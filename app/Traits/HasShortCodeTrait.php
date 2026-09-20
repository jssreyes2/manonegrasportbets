<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasShortCodeTrait
{
    /**
     * Boot the trait
     */
    protected static function bootHasShortCodeTrait()
    {
        static::creating(function ($model) {
            if (empty($model->short_code)) {
                $model->short_code = self::generateShortCode($model);
            }
        });
    }
    
    /**
     * Generate a unique short code
     */
    protected static function generateShortCode($model)
    {
        $prefix = $model->getShortCodePrefix();
        $length = $model->getShortCodeLength();
        
        do {
            $code = $prefix . strtoupper(Str::random($length));
        } while ($model->where('short_code', $code)->exists());
        
        return $code;
    }
    
    /**
     * Get prefix for short code
     */
    protected function getShortCodePrefix()
    {
        return property_exists($this, 'shortCodePrefix')
            ? $this->shortCodePrefix
            : 'PRD';
    }
    
    /**
     * Get random part length
     */
    protected function getShortCodeLength()
    {
        return property_exists($this, 'shortCodeLength')
            ? $this->shortCodeLength
            : 6;
    }
}