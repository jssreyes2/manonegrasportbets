<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Whop\WhopWebhookServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WhopWebhookController extends Controller
{
    function __construct(protected WhopWebhookServices $whopWebhook)
    {
    }
    
    public function handle(Request $request): Response
    {
        return $this->whopWebhook->handle($request);
    }
}