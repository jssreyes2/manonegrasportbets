<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\CareerCumulativeAmount;
use App\Models\Racecourse;
use App\Models\Ticket;
use App\Repositories\RacecourseRepository;
use App\Repositories\TicketRepository;
use App\Repositories\WebContent\StaticPageRepository;
use Illuminate\Http\Request;
use App\Helpers\BusinessHelper;

class HomeController extends Controller
{
    
    public function index()
    {
        $banners=StaticPageRepository::getContentBanner(['is_active' => true])->get();
        
        return view('home', ['banners' =>$banners]);
    }
    
    public function formLogin()
    {
        return view('auth.login');
    }
}
