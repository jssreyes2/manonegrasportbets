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
    
    public function index(): view
    {
        $user      = $this->getUserProfile()->first();
        $countries = Country::getCountryList();
        
        return view('dashboard.views.frm-customer-profile', compact('user', 'countries'));;
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
    
    public function changePassword(): view
    {
        $user = Auth::user();
        
        return view('dashboard.views.frm-update-password', compact('user'));
    }
    
    public function saveNewPassword($data)
    {
        DB::beginTransaction();
        
        try {
            
            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.user_not_logged_in', 'Usuario no logueado')]);
            }
            
            $data['user_name'] = capitalize_first($user->profile->first_name) . ' ' . capitalize_first($user->profile->last_name);
            $currentEmail      = $user->email;
            
            $user->email    = strtolower($data['email']);
            $user->password = Hash::make($data['password']);
            
            if ($data['email'] != $currentEmail) {
                $user->is_valid_email = false;
                (new SendMailServices())->sendMailAccessSystem($data, $user);
                app(AuthServices::class)->logout();
            }
            
            $user->save();
            DB::commit();
            
        } catch (\Throwable $e) {
            
            DB::rollBack();
            
            throw $e;
        }
        
        return response()->json(['status' => 'success', 'message' => __t('text.backend.messages.saved', 'Datos guardados con éxito')]);
    }
}