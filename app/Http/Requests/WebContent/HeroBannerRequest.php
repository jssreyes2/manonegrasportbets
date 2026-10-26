<?php

namespace App\Http\Requests\WebContent;

use Illuminate\Foundation\Http\FormRequest;

class HeroBannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        // Pesos máximos en KB: un video de fondo más pesado retrasa la carga de la portada
        return [
            'video_desktop' => 'nullable|file|mimetypes:video/mp4,video/webm|max:15360',
            'video_mobile'  => 'nullable|file|mimetypes:video/mp4,video/webm|max:10240',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'poster_mobile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'overlay'       => 'required|integer|min:20|max:90',
            'show_video'    => 'nullable|boolean',
        ];
    }
    
    public function messages()
    {
        return [
            'video_desktop.mimetypes' => 'El video de escritorio debe ser MP4 o WebM.',
            'video_desktop.max'       => 'El video de escritorio no debe pesar más de 15 MB.',
            'video_mobile.mimetypes'  => 'El video móvil debe ser MP4 o WebM.',
            'video_mobile.max'        => 'El video móvil no debe pesar más de 10 MB.',
            'poster.image'            => 'La imagen debe ser JPG, PNG o WebP.',
            'poster.max'              => 'La imagen no debe pesar más de 2 MB.',
            'poster_mobile.image'     => 'La imagen móvil debe ser JPG, PNG o WebP.',
            'poster_mobile.max'       => 'La imagen móvil no debe pesar más de 2 MB.',
            'overlay.*'               => 'La oscuridad de la capa debe estar entre 20% y 90%.',
        ];
    }
}
