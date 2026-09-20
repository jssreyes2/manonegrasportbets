<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\changePasswordRequest;
use App\Http\Requests\User\ProfileRequest;
use App\Services\User\ProfileServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    // Inyecta ProfileServices en el constructor
    public function __construct(protected ProfileServices $profile){}
    
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index():view
    {
        return $this->profile->index();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return jsonResponse
     */
    public function updateProfile(ProfileRequest $request):jsonResponse
    {
        return $this->profile->updateProfile($request->validated());
    }
    
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword():view
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
        return $this->profile->saveNewPassword($request->all());
    }
    
}