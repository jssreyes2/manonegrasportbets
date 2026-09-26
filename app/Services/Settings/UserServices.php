<?php

namespace App\Services\Settings;

use App\Models\Rol;
use App\Models\User;
use App\Models\WebSuscription;
use App\Repositories\Settings\UserRepository;
use App\Services\SendMailServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Exception;

class UserServices
{
    
    private function getUser(?array $filter = [])
    {
        return UserRepository::getUser($filter);
    }
    
    public function getRol()
    {
        return Rol::where('is_active', true)->get();
    }
    
    public function prepareViewIndexData(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $filter = array_merge($filter, ['in_rol_id' => [1, 2]]);
        
        $viewData = [
            'users'  => $this->getUser($filter)->paginate(config('app.npage')),
            'filter' => $filter,
            'roles'  => $this->getRol(),
        ];
        
        return view('admin.user.table-user', $viewData);
    }
    
    public function prepareViewCreateData()
    {
        return view('admin.user.form-user', ['option' => 'create', 'roles' => $this->getRol()]);
    }
    
    public function prepareViewEditData(array $data)
    {
        $user = $this->getUser(['id' => $data['id']])->first();
        return view('admin.user.form-user', ['option' => 'edit', 'roles' => $this->getRol(), 'user' => $user]);
    }
    
    public function createUser($data)
    {
        if ($data['rol_id'] == Rol::ROL_CUSTOMER && $data['the_terms'] != 1) {
            return response()->json([
                'status'  => 'fail',
                'message' => __t('text.backend.messages.terms', 'Debe aceptar los términos y condiciones para registrarse como cliente.'),
                'edit'    => false
            ]);
        }
        
        DB::beginTransaction();
        
        try {
            // 1. Guardar el usuario
            $user = User::saveUser($data);
            
            // 2. Intentar enviar el correo si es cliente
            if ($data['rol_id'] == Rol::ROL_CUSTOMER) {
                // Asegúrate de que este servicio lance la excepción si falla
                (new SendMailServices())->sendMailRegisterUser($data, $user);
            }
            
            DB::commit();
            
        } catch (Exception $e) {
            // Si ocurre CUALQUIER error (incluyendo el envío del correo),
            // se deshace la creación del usuario en la base de datos.
            DB::rollBack();
            
            // Opcional: Puedes eliminar explícitamente el usuario recién creado por seguridad
            if (isset($user) && $user->exists) {
                $user->delete();
            }
            
            // Volvemos a lanzar la excepción para que la aplicación muestre el error o lo registre
            throw $e;
        }
        
        return response()->json([
            'status'  => 'success',
            'message' => __t('text.backend.messages.confirm_your_email', 'Datos guardados exitosamente. Debe confirmar su dirección de correo electrónico.'),
            'edit'    => false
        ]);
    }
    
    public function updateUser(array $data)
    {
        User::updateUser($data);
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
    }
    
    public function deleteUser(array $data)
    {
        User::destroy($data['id']);
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
    
    public function verifyEmail($data)
    {
        try {
            $email = decrypt($data['email']);
            
            $user = User::where('email', $email)->first();
            
            if ($user) {
                $user->is_valid_email = true;
                $user->save();
                return view('frontend.confirmation-email', compact('email'));
            }
            
            return view('frontend.verify-email-error', compact('email'));
            
        } catch (DecryptException|Exception $e) {
            
            $email = null;
            
            return view('frontend.verify-email-error', compact('email'));
        }
    }
    
    public function createUserSuscription($data)
    {
        DB::beginTransaction();
        
        try {
            
            $data['full_name'] = mb_strtoupper($data['full_name']);
            $data['email']     = $data['email'];
            
            $webSuscript = WebSuscription::create($data);
            
            if (!$webSuscript?->id) {
                return response()->json(['status' => 'fail', 'message' => 'No se pudo realizar la suscripción, por favor verifique que los datos sean correctos']);
            }
            
            $data = [
                'name'    => capitalize_first($webSuscript->full_name),
                'email'   => $webSuscript->email,
                'body'    => __t('text.email.notification_web_suscription.body_text'),
                'subject' => __t('text.email.notification_web_suscription.subject'),
                'bcc'       => config('app.mail_copy_ocult'),
            ];
            
            (new SendMailServices())->sendMailNotification($data);
            
            DB::commit();
            
        } catch (Exception $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => 'La suscripción fue realizada con éxito, luego recibiras tu pick Gratis']);
    }
}