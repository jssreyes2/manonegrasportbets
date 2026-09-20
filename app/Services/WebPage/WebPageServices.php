<?php

namespace App\Services\WebPage;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Parameter;
use App\Models\Plan;
use App\Models\Rol;
use App\Models\StaticPage;
use App\Models\User;
use App\Repositories\Register\CategoryRepository;
use App\Repositories\Settings\UserRepository;
use App\Repositories\WebContent\FrequentlyAskedQuestionRepository;
use App\Repositories\WebContent\StaticPageRepository;
use App\Services\FileServices;
use App\Services\SendMailServices;
use App\Services\Settings\UserServices;
use App\Services\WebContent\FrequentlyAskedQuestionServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class WebPageServices extends FileServices
{
    
    public function getBlog($request)
    {
        $filter = $request->filter ?? [];
        $id     = $request->id ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $request->id]);
        }
        
        $filter = array_merge($filter, ['type' => 'blog', 'is_active' => true]);
        
        $staticPages = StaticPageRepository::getStaticPage($filter);
        
        $viewData = [
            'filter' => $filter,
            'news'   => $staticPages->paginate(3)
        ];
        
        return view('frontend.sports-news', $viewData);
    }
    
    public function getBlogDetail($source)
    {
        $news = StaticPageRepository::getStaticPage(['source' => $source])->first();
        
        if (!$news) {
            return redirect()->route('show.sports-news-detail');
        }
        
        return view('frontend.sports-news-detail', compact('news'));;
    }
    
    public function registerUser($request)
    {
        try {
            
            $user = UserRepository::getUser(['email' => strtolower($request->email)])->first();
            
            if (!empty($user)) {
                return response()->json(['status' => 'fail', 'message' => 'Los datos ya se encuentran registrado']);
            }
            
            DB::beginTransaction();
            $userNew = User::saveUserWeb($request);
            
            (new SendMailServices())->sendMailRegisterUser($request, $userNew);
            
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Proceso exitoso', 'email' => encrypt($userNew->email)]);
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            DB::rollBack();
          
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar usuario'
            ], 500);
        }
    }
    
    
    public function saveComment(array $data)
    {
        try {
            
            DB::beginTransaction();
            
            Comment::saveComment($data);
            
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito']);
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar registro: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function pageLegalDocuments(string $type)
    {
        $legaldocument = StaticPageRepository::getStaticPage(['type' => $type, 'language' => session_language()])->first();
        
        if (!$legaldocument) {
            return redirect()->route('/');
        }
        
        
        $classWhoWeAre = 'border-b-2 border-lime-400';
        
        return match ($type) {
            StaticPage::TYPE_TERMS      => view('frontend.terms-and-conditions', compact('legaldocument')),
            StaticPage::TYPE_WHO_WE_ARE => view('frontend.who-we-are', compact('legaldocument', 'classWhoWeAre')),
            default                     => redirect()->route('/')
        };
    }
    
    public function frequentlyAskedQuestions()
    {
        $faqs = app(FrequentlyAskedQuestionServices::class)->getFaq(['is_active' => true, 'language'=>session_language()])->get();
        
        if (!$faqs) {
            return redirect()->route('/');
        }
        
        return view('frontend.frequently-asked-questions', compact('faqs'));
    }
}

