<?php

declare(strict_types=1);

return [
    'api_key' => env('WHOP_API_KEY'),
    'webhook_secret' => env('WHOP_WEBHOOK_SECRET'),
    'base_url' => env('WHOP_BASE_URL', 'https://api.whop.com/api/v1'),
    'whop_company_id' => env('WHOP_COMPANY_ID'),
    'http_client' => env('WHOP_HTTP_CLIENT'),
    'webhook_path' => env('WHOP_WEBHOOK_PATH', '/whop/webhook'),
    'register_routes' => env('WHOP_REGISTER_ROUTES', true),
];
