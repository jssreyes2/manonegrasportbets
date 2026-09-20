<?php

namespace App\Services\WebContent;

use App\Models\Category;
use App\Models\FrequentlyAskedQuestion;
use App\Repositories\Register\CategoryRepository;
use App\Repositories\WebContent\FrequentlyAskedQuestionRepository;

class FrequentlyAskedQuestionServices
{
    
    public function getFaq($filter)
    {
        return FrequentlyAskedQuestionRepository::getFaq($filter);
    }
    

    public function index(array $data)
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $faq    = $this->getFaq($filter);
        
        $viewData  = [
            'filter' => $filter,
            'faqs' => $faq->paginate(config('app.npage'))
        ];
        
        return view('admin.web_content.frequently_asked_question.table-faq', $viewData);
    }
    
    /** Preparamos la vista de crear */
    public function prepareViewCreateData()
    {
        return view('admin.web_content.frequently_asked_question.form-faq');
    }
    
    /** Preparamos la vista de editar */
    public function prepareViewEditData($request)
    {
        $faq = $this->getfaq(['id' => $request->id])->first();
        
        return view('admin.web_content.frequently_asked_question.form-faq', ['faq' => $faq]);
    }
    
    public function createFaq($request)
    {
        FrequentlyAskedQuestion::saveFaq($request);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function updateFaq($request)
    {
        FrequentlyAskedQuestion::updateFaq($request);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
    }
    
    public function deleteFaq($request)
    {
        FrequentlyAskedQuestion::deleteFaq($request->id);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
}
