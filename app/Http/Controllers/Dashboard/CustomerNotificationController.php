<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pick;
use App\Services\User\WebPushServices;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerNotificationController extends Controller
{
    public function __construct(protected WebPushServices $push)
    {
    }

    /** Picks nuevos sin ver (campana). */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $count = DB::table('send_mail_picks')
            ->where('user_id', $userId)
            ->whereNull('seen_at')
            ->count();

        $items = Pick::sentToUser($userId)
            ->whereNull('send_mail_picks.seen_at')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'title' => $p->lines()[0] ?? '—',
                'plan'  => $p->plan->name ?? '',
                'date'  => Carbon::parse($p->send_date)->format('d/m/Y'),
            ]);

        return response()->json(['count' => $count, 'items' => $items]);
    }

    public function markSeen(Request $request): JsonResponse
    {
        DB::table('send_mail_picks')
            ->where('user_id', $request->user()->id)
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);

        return response()->json(['ok' => true]);
    }

    public function subscribe(Request $request): JsonResponse
    {
        $data = $request->validate([
            'endpoint'    => 'required|url|max:2000',
            'keys.p256dh' => 'required|string',
            'keys.auth'   => 'required|string',
        ]);

        $this->push->subscribe($request->user()->id, $data, $request->userAgent());

        return response()->json(['ok' => true]);
    }

    public function unsubscribe(Request $request): JsonResponse
    {
        $data = $request->validate(['endpoint' => 'required|url|max:2000']);
        $this->push->unsubscribe($request->user()->id, $data['endpoint']);

        return response()->json(['ok' => true]);
    }
}
