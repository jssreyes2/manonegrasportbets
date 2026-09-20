<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\NotificationEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    /**
     * GIF transparente 1x1 codificado en base64.
     * Lo devolvemos siempre, incluso en errores, para no romper el render del correo.
     */
    private const TRANSPARENT_GIF_B64 = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    
    public function emailOpen(Request $request)
    {
        $token = $request->query('token');
        
        // Validación mínima: token de 64 chars
        if (!is_string($token) || strlen($token) !== 64) {
            return $this->gifResponse();
        }
        
        try {
            // Solo actualizamos si aún no se ha abierto
            DB::table('notifications')
                ->where('tracking_token', $token)
                ->whereNull('deleted_at')
                ->whereNull('opening_date')
                ->update([
                    'state'        => 'open',
                    'opening_date' => now(),
                    'updated_at'   => now(),
                ]);
            
        } catch (\Throwable $e) {
            // Nunca rompemos la respuesta por un error de tracking
            Log::error('[tracking/email-open] ' . $e->getMessage(), [
                'token' => $token,
            ]);
        }
        
        return $this->gifResponse();
    }
    
    private function gifResponse()
    {
        return response(base64_decode(self::TRANSPARENT_GIF_B64), 200)
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    
    private function clientIp(Request $request): ?string
    {
        $forwarded = $request->header('X-Forwarded-For');
        if ($forwarded) {
            return trim(explode(',', $forwarded)[0]);
        }
        return $request->ip();
    }
}