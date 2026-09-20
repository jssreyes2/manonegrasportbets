<?php
/**
 * Created by Jesus Reyes.
 * User: Administrator
 * Date: 2024/09/19
 * Time: 10:25
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Invoice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'invoice';
    }
}