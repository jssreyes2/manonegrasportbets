<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Banner principal (video) de la portada. Hay una sola fila; los campos vacíos usan el
 * video de prueba de public/video/hero (clip de Pexels, licencia libre sin atribución obligatoria).
 */
class HeroBanner extends Model
{
    protected $table = 'hero_banners';

    const FOLDER = 'hero';

    // Archivos que se pueden subir desde el admin
    const FILE_FIELDS = ['video_desktop', 'video_mobile', 'poster', 'poster_mobile'];

    const DEFAULTS = [
        'video_desktop' => 'video/hero/hero-desktop.mp4',
        'video_mobile'  => 'video/hero/hero-mobile.mp4',
        'poster'        => 'video/hero/hero-poster.jpg',
        'poster_mobile' => 'video/hero/hero-poster-mobile.jpg',
    ];

    // Versión WebM del video de prueba (más liviana); solo aplica mientras no se suba otro video
    const DEFAULT_DESKTOP_WEBM = 'video/hero/hero-desktop.webm';

    protected $fillable = ['video_desktop', 'video_mobile', 'poster', 'poster_mobile', 'overlay', 'show_video'];

    protected $casts = [
        'overlay'    => 'integer',
        'show_video' => 'boolean',
    ];

    /**
     * Configuración vigente. Si la tabla aún no existe (migración pendiente) devuelve los valores por defecto.
     */
    public static function current(): self
    {
        return rescue(fn() => self::first(), null, false) ?? new self(['overlay' => 45, 'show_video' => true]);
    }

    public function url(string $field): string
    {
        return $this->{$field} ? Storage::url($this->{$field}) : asset(self::DEFAULTS[$field]);
    }

    /**
     * Fuentes de video por dispositivo: [['src' => url, 'type' => mime], ...]
     */
    public function sources(string $device): array
    {
        $field = $device === 'mobile' ? 'video_mobile' : 'video_desktop';

        if ($this->{$field}) {
            return [['src' => Storage::url($this->{$field}), 'type' => $this->mime($this->{$field})]];
        }

        $sources = [];
        if ($device === 'desktop') {
            $sources[] = ['src' => asset(self::DEFAULT_DESKTOP_WEBM), 'type' => 'video/webm'];
        }
        $sources[] = ['src' => asset(self::DEFAULTS[$field]), 'type' => 'video/mp4'];

        return $sources;
    }

    private function mime(string $path): string
    {
        return str_ends_with(strtolower($path), '.webm') ? 'video/webm' : 'video/mp4';
    }
}
