<?php

namespace App\Http\Controllers\Admin\WebContent;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebContent\HeroBannerRequest;
use App\Services\WebContent\HeroBannerServices;
use Illuminate\Http\Request;

class HeroBannerController extends Controller
{
    public function __construct(protected HeroBannerServices $hero)
    {
    }
    
    /**
     * Formulario del banner principal (video) de la portada.
     */
    public function index()
    {
        return $this->hero->index();
    }
    
    public function update(HeroBannerRequest $request)
    {
        return $this->hero->update($request);
    }
    
    /**
     * Quita los archivos subidos y vuelve al video de prueba.
     */
    public function restore(Request $request)
    {
        return $this->hero->restore();
    }
}
