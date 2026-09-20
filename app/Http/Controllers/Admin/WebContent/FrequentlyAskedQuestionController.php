<?php

namespace App\Http\Controllers\Admin\WebContent;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebContent\FrequentlyAskedQuestionRequest;
use App\Services\WebContent\FrequentlyAskedQuestionServices;
use Illuminate\Http\Request;

class FrequentlyAskedQuestionController extends Controller
{
    // Inyecta FrequentlyAskedQuestionServices en el constructor
    public function __construct(protected FrequentlyAskedQuestionServices $faq){}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->faq->index($request->all());
    }
    
 
    public function create()
    {
        return $this->faq->prepareViewCreateData();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->faq->prepareViewEditData($request);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrequentlyAskedQuestionRequest $request)
    {
        return $this->faq->createFaq($request);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(FrequentlyAskedQuestionRequest $request)
    {
        return $this->faq->updateFaq($request);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->faq->deleteFaq($request);
    }
}
