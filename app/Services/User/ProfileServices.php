<?php

namespace App\Services\User;


use App\Models\Country;
use App\Models\Rol;
use App\Models\User;
use App\Models\UserProfile;
use App\Repositories\Settings\UserRepository;
use App\Services\AuthServices;
use App\Services\FileServices;
use App\Services\SendMailServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ProfileServices
{
    
    private function getUserProfile()
    {
        return UserRepository::getUserProfile(['id' => Auth::user()->id]);
    }
    
    public function index(string $tab = 'profile'): view
    {
        $user      = $this->getUserProfile()->first();
        $account   = Auth::user();
        $countries = Country::getCountryList();
        // Prefijo telefónico por país para mostrarlo junto al campo teléfono
        $phoneCodes = Country::pluck('code_phone', 'id');
        
        return view('dashboard.views.frm-customer-profile', compact('user', 'account', 'countries', 'phoneCodes', 'tab'));
    }
    
    public function updateProfile(array $data): jsonResponse
    {
        try {
            
            DB::beginTransaction();
            
            $profile = UserProfile::updateProfile($data);
            if (!$profile) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => __t('text.backend.messages.error_updated_profile', 'No se pudo actualizar el perfil')
                ], 422);
            }
            
            $verifyPhoneExist = UserProfile::verifyPhoneExist($profile->id, normalizePhone($data['phone']));
            if ($verifyPhoneExist) {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.phone_already_exists', 'EL número de teléfono ya se encuentra registrado')]);
            }
            
            $file = new FileServices();
            $file->storeImage($profile, UserProfile::FOLDER_USER, Auth::user()->id, UserProfile::NAME_FILE, $data);
            
            DB::commit();
            
        } catch (\Throwable $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => __t('text.backend.messages.saved', 'Datos guardados con éxito')]);
    }
    
    /**
     * "Actualizar acceso" ahora es la pestaña Seguridad de Mi cuenta.
     */
    public function changePassword(): view
    {
        return $this->index('security');
    }
    
    public function savePreferences(array $data): jsonResponse
    {
        $user           = Auth::user();
        $user->language = $data['language'];
        $user->save();
        
        session(['locale' => $data['language']]);
        
        return response()->json(['status' => 'success', 'message' => __t('text.backend.messages.saved', 'Datos guardados con éxito', [], $data['language'])]);
    }
    
    public function saveNewPassword($data)
    {
        DB::beginTransaction();
        
        try {
            
            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.user_not_logged_in', 'Usuario no logueado')]);
            }
            
            $data['user_name'] = capitalize_first($user->profile?->first_name) . ' ' . capitalize_first($user->profile?->last_name);
            $currentEmail      = $user->email;
            $newEmail          = strtolower(trim($data['email']));
            $emailChanged      = $newEmail !== strtolower($currentEmail);
            
            // La contraseña es opcional: vacía significa que solo cambia el correo
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            
            if (!$emailChanged && empty($data['password'])) {
                DB::rollBack();
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.customer.nothing_to_update')]);
            }
            
            $user->email = $newEmail;
            
            if ($emailChanged) {
                $user->is_valid_email = false;
            }
            
            $user->save();
            DB::commit();
            
            // Al cambiar el correo se cierra la sesión hasta confirmar la nueva dirección
            if ($emailChanged) {
                (new SendMailServices())->sendMailAccessSystem($data, $user);
                app(AuthServices::class)->logout();
                
                return response()->json([
                    'status'   => 'success',
                    'message'  => __t('text.backend.customer.email_changed'),
                    'redirect' => route('show.login-customer'),
                ]);
            }
            
        } catch (\Throwable $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => __t('text.backend.messages.saved', 'Datos guardados con éxito')]);
    }
}