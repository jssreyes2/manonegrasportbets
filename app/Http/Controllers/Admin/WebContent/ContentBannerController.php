<?php

namespace App\Http\Controllers\Admin\WebContent;

use App\Http\Controllers\Controller;
use App\Services\WebContent\ContentBannerServices;
use Illuminate\Http\Request;

class ContentBannerController extends Controller
{
    public function __construct(protected ContentBannerServices $contentBanner){}
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->contentBanner->prepareViewIndexData($request);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $this->contentBanner->prepareViewCreateData($request);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->contentBanner->prepareViewEditData($request);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->contentBanner->saveContentBanner($request);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->contentBanner->updateContentBanner($request);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->contentBanner->deleteContentBanner($request);
    }
    
}
