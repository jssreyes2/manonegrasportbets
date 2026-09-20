<?php

namespace App\Http\Controllers\Admin\WebContent;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebContent\StaticPageRequest;
use App\Services\WebContent\StaticPageServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{

    public function __construct(protected StaticPageServices $staticPage){}
    
    public function index(Request $request):View
    {
        return $this->staticPage->index($request->all());
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->staticPage->prepareViewCreateData();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->staticPage->prepareViewEditData($request->all());
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticPageRequest $request)
    {
        return $this->staticPage->createStaticPage($request->all());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(StaticPageRequest $request)
    {
        return $this->staticPage->updateStaticPage($request->all());
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->staticPage->deleteStaticPage($request->all());
    }
    
 
    public function comments(Request $request): View
    {
        return $this->staticPage->tableViewComments($request->all());
    }
  /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function commentResponse(Request $request)
    {
        return $this->staticPage->commentResponse($request->all());
    }

  /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResponse(Request $request)
    {
        return $this->staticPage->sendResponse($request->all());
    }
}
