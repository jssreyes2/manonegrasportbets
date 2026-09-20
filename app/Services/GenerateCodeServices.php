<?php

namespace App\Services;

use App\Models\InvoiceDetailTmp;
use Illuminate\Support\Facades\Auth;
use RandomLib\Factory;

class GenerateCodeServices
{
    public function createCode($length = 6)
    {
        $factory   = new Factory();
        $generator = $factory->getMediumStrengthGenerator();
        
        return $generator->generateString($length, '0123456789');
    }
    
    public function temporaryInvoiceCode()
    {
        $detailTmp = InvoiceDetailTmp::where('created_by', '=', Auth::user()->id)->first();
        if ($detailTmp instanceof InvoiceDetailTmp) {
            return $detailTmp->code_tmp;
        }
        
        do {
            $code = $this->createCode();
        } while (InvoiceDetailTmp::where('created_by', '!=', Auth::user()->id)->where('code_tmp', $code)->exists());
        
        return $code;
    }
}