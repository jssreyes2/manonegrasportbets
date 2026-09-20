<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\ReportUserServices;
use Illuminate\Http\Request;

class ReportUserController extends Controller
{
    public function __construct(protected ReportUserServices $report){}
    
    public function index(Request $request)
    {
        return $this->report->prepareViewIndexData($request);
    }
    
    public function exportExcelUser(Request $request)
    {
        return $this->report->exportExcelUser($request);
    }
    
    public function getUserSubscription(Request $request)
    {
        return $this->report->getUserSubscription($request);
    }
 public function exportExcelSubscription(Request $request)
    {
        return $this->report->exportExcelSubscription($request);
    }
}
