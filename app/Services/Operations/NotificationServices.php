<?php

namespace App\Services\Operations;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationServices
{
    
    private const TRANSPARENT_GIF_B64 = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    
    public function getNotifications(array $filter = [])
    {
        return Notification::getNotifications()->filter($filter);
    }
    
    public function index(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $notifications = $this->getNotifications($filter)->paginate(config('app.npage'));
        
        return view('admin.operation.table-notifications', compact('filter', 'notifications'))->with('error', $data['msg_error'] ?? session('error'));
    }
    
    
    public function emailOpen(array $data = [])
    {
        $token = $data['token'];
        
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
    
}