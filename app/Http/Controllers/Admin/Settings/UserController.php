<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserRequest;
use App\Http\Requests\Settings\WebSuscriptionRequest;
use App\Jobs\UpdateExpiredSubscriptionsJob;
use App\Models\Rol;
use App\Models\Subscription;
use App\Repositories\UserRepository;
use App\Services\SendMailServices;
use App\Services\Settings\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionEmail;

class UserController extends Controller
{
    // Inyecta UserServices en el constructor
    public function __construct(protected UserServices $user)
    {
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->user->prepareViewIndexData($request->all());
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->user->prepareViewCreateData();
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return $this->user->prepareViewEditData($request->all());
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!$request->filled('rol_id')) {
            $request->merge(['rol_id' => Rol::ROL_CUSTOMER, 'is_active' => true]);
        }
        
        return $this->user->createUser($request->all());
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        return $this->user->updateUser($request->all());
    }
    
    public function destroy(Request $request)
    {
        return $this->user->deleteUser($request->all());
    }
    
    public function verifyEmail(Request $request)
    {
        return $this->user->verifyEmail($request->all());
    }
    public function createUserSuscription(WebSuscriptionRequest $request)
    {
        return $this->user->createUserSuscription($request->all());
    }
    
    public function sendMailTest()
    {
        
        try {
            // Ejecuta el comando Artisan registrado
            Artisan::call('check-subscriptions');
            
            // Captura la salida o mensajes del comando (opcional)
            $output = Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Comando ejecutado exitosamente desde el controlador.',
                'output' => $output
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error al ejecutar comando desde controlador: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
