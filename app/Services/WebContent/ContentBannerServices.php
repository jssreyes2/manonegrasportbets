<?php

namespace App\Services\WebContent;


use App\Models\ContentBanner;
use App\Models\Parameter;
use App\Models\StaticPage;
use App\Repositories\WebContent\StaticPageRepository;
use App\Services\FileServices;
use App\Services\SendMailServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentBannerServices
{
    
    private function getContentBanner($filter)
    {
        return StaticPageRepository::getContentBanner($filter);
    }
    
    /** Preparamos la vista de lista */
    public function prepareViewIndexData($request)
    {
        $filter = $request->filter ?? [];
        $id     = $request->id ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $request->id]);
        }
        
        $contentsBanner = $this->getContentBanner($filter);
        
        $viewData = [
            'filter'         => $filter,
            'contentsBanner' => $contentsBanner->paginate(config('app.npage'))
        ];
        
        return view('admin.web_content.static_page.table-content-banner', $viewData);
    }
    
    /** Preparamos la vista de crear */
    public function prepareViewCreateData()
    {
        return view('admin.web_content.static_page.form-content-banner');
    }
    
    /** Preparamos la vista de editar */
    public function prepareViewEditData($request)
    {
        $contentsBanner = $this->getContentBanner(['id' => $request->id])->first();
        
        return view('admin.web_content.static_page.form-content-banner', ['contentsBanner' => $contentsBanner]);
    }
    
    public function saveContentBanner($request)
    {
        try {
            DB::beginTransaction();
            $contentBanner = ContentBanner::saveContentBanner($request);
            
            if (empty($request->photo)) {
                return response()->json(['status' => 'fail', 'message' => '¡Atención!, Debe ingresar una imagen']);
            }
            
            $this->updloadFile($contentBanner, $request);
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar contenido del banner: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateContentBanner($request)
    {
        try {
            
            DB::beginTransaction();
            $contentBanner = ContentBanner::updateContentBanner($request);
            
            $this->updloadFile($contentBanner, $request);
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar pagina estatica: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function deleteContentBanner($request)
    {
        ContentBanner::deleteContentBanner($request->id);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
    
    public function updloadFile($model, $request)
    {
        $file = new FileServices();
        $file->storeImage($model, ContentBanner::FOLDER_PHOTO_PAGE, ContentBanner::FOLDER_BANNER, ContentBanner::NAME_FILE . '-' . $model->id, $request, false);
    }
}
