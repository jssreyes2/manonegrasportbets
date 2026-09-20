<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BankingInformationRequest;
use App\Http\Requests\User\changePasswordRequest;
use App\Http\Requests\User\ClientRoleRequest;
use App\Http\Requests\User\ProfileRequest;
use App\Services\User\ProfileServices;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Inyecta ProfileServices en el constructor
    public function __construct(protected ProfileServices $profile){}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->profile->prepareViewIndexData($request);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerProfile()
    {
        return $this->profile->customerProfile();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ProfileRequest $request)
    {
        return $this->profile->updateProfile($request);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bankInformation(Request $request)
    {
        return $this->profile->bankInformation($request);
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveBankingInformation(BankingInformationRequest $request)
    {
        return $this->profile->saveBankingInformation($request);
    }
    
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        return $this->profile->changePassword();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveNewPassword(changePasswordRequest $request)
    {
        return $this->profile->saveNewPassword($request);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configureClientRole()
    {
        return $this->profile->configureClientRole();
    }
    
    public function saveClientRole(ClientRoleRequest $request)
    {
        return $this->profile->saveClientRole($request);
    }
    
    
}