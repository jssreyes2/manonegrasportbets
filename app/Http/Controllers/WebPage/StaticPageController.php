<?php

namespace App\Http\Controllers\WebPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebContent\CommentRequest;
use App\Services\WebPage\WebPageServices;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    
    protected $webPage;
    
    
    function __construct(WebPageServices $webPage)
    {
        $this->webPage = $webPage;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBlog(Request $request)
    {
        return $this->webPage->getBlog($request);
    }
    
    public function getBlogDetail($source)
    {
        return $this->webPage->getBlogDetail($source);
    }
    
    public function pageLegalDocuments(Request $request)
    {
        return $this->webPage->pageLegalDocuments($request->type);
    }
    
    public function frequentlyAskedQuestions()
    {
        return $this->webPage->frequentlyAskedQuestions();
    }
    
    public function saveComment(CommentRequest $request)
    {
        return $this->webPage->saveComment($request->validated());
    }
}
