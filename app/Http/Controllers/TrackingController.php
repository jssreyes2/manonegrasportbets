<?php

namespace App\Http\Controllers;

use App\Services\Operations\NotificationServices;
use Illuminate\Http\Request;
use App\Models\NotificationEvent;

class TrackingController extends Controller
{
    public function __construct(protected NotificationServices $notification){}
    
    public function index(Request $request)
    {
        return $this->notification->index($request->all());
    }
    
    
    public function emailOpen(Request $request)
    {
        return $this->notification->emailOpen($request->all());
    }
}