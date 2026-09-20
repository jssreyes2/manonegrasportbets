<?php

namespace App\Services\WebContent;


use App\Models\StaticPage;
use App\Repositories\WebContent\StaticPageRepository;
use App\Services\FileServices;
use App\Services\SendMailServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class StaticPageServices
{
    
    private function getStaticPage($filter)
    {
        return StaticPageRepository::getStaticPage($filter);
    }
    
    /** Preparamos la vista de lista */
    public function index(?array $data): View
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $staticPages = $this->getStaticPage($filter);
        
        $viewData = [
            'filter'          => $filter,
            'staticPages'     => $staticPages->paginate(config('app.npage')),
            'staticPageClass' => StaticPage::class,
        ];
        
        return view('admin.web_content.static_page.table-static-page', $viewData);
    }
    
    
    public function prepareViewCreateData(): View
    {
        return view('admin.web_content.static_page.form-static-page');
    }
    
    
    public function prepareViewEditData(array $data): View
    {
        $staticPage = $this->getStaticPage(['id' => $data['id']])->first();
        
        return view('admin.web_content.static_page.form-static-page', compact('staticPage'));
    }
    
    public function createStaticPage(array $data): JsonResponse
    {
        try {
            DB::beginTransaction();
            $staticPage = StaticPage::saveStaticPage($data);
            
            $this->updloadFile($staticPage, $data, $data['type']);
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar pagina estatica: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateStaticPage(array $data): JsonResponse
    {
        try {
            
            DB::beginTransaction();
            $staticPage = StaticPage::updateStaticPage($data);
            
            $this->updloadFile($staticPage, $data, $data['type']);
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
    
    public function deleteStaticPage(array $data): JsonResponse
    {
        StaticPage::destroy($data['id']);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
    
    public function updloadFile($model, $data, $folder = StaticPage::FOLDER_PHOTO_PAGE): void
    {
        $file = new FileServices();
        
        $folderPhoto = folder_based_on_file($folder);
        
        $file->storeImage($model, $folderPhoto, $model->id, StaticPage::NAME_FILE . '-' . $model->id, $data);
    }
    
    
    public function tableViewComments(?array $data): View
    {
        $filter = $data['filter'] ?? [];
        
        $contacts = StaticPageRepository::getContact($filter);
        
        $viewData = [
            'filter'   => $filter,
            'contacts' => $contacts->paginate(config('app.npage'))
        ];
        
        return view('admin.web_content.static_page.table-contact', $viewData);
    }
    
    
    public function commentResponse(array $data): View
    {
        $contact = StaticPageRepository::getContact(['id' => $data['id']])->first();
        
        return view('admin.web_content.static_page.form-comment-response', ['contact' => $contact]);
    }
    
    public function sendResponse(array $data): JsonResponse
    {
        if (empty($data['response_text'])) {
            return response()->json(['status' => 'fail', 'message' => 'Por favor ingrese la respuesta']);
        }
        
        $contact = StaticPageRepository::getContact(['id' => $data['id']])->first();
        
        if (empty($contact)) {
            return response()->json(['status' => 'fail', 'message' => 'Este comentario ha sido eliminado']);
        }
        
        $data['name'] = capitalize_first($contact->full_name);
        $data['email']     = $contact->email;
        $data['body']      = $contact->comment;
        $data['subject']   = __t('text.email.notification.subject');
        
        $response = (new SendMailServices())->sendMailNotification($data);
        
        if (!$response) {
            return response()->json(['status' => 'fail', 'message' => 'Error al enviar correo']);
        }
        
        $contact->answered = true;
        $contact->update();
        
        return response()->json(['status' => 'success', 'message' => 'La respuesta fué enviada exitosamente']);
    }
}
