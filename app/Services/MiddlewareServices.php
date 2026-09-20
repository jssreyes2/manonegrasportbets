<?php

namespace App\Services;


use App\Models\Rol;
use App\Models\User;
use App\Services\User\SubscriptionServices;
use Illuminate\Support\Facades\Auth;

class MiddlewareServices
{
    
    
    private function verifyAuthUser(): User|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user || !$user?->rol_id) {
            return redirect()->route('logout');
        }
        
        return $user;
    }
    
      public function checkCompletedProfile($request, $next)
      {
          $user = $this->verifyAuthUser();
          if ($user instanceof \Illuminate\Http\RedirectResponse) {
              return $user;
          }
          
          $allowedRoles = [Rol::ROL_CUSTOMER];
          
          if (in_array($user->rol_id, $allowedRoles)) {
              $completedProfile = $user->profile?->completed_profile ?? false;
              
              if (!$completedProfile) {
                  return redirect()->route('profile');
              }
          }
          
          return $next($request);
      }
      
      public function checkSubscription($request, $next)
      {
          $user = $this->verifyAuthUser();
          if ($user instanceof \Illuminate\Http\RedirectResponse) {
              return $user;
          }
          
          $roles = [Rol::ROL_ADMIN, Rol::ROL_OPERATOR, Rol::ROL_CUSTOMER];
          
          $verfirySubscription = app(SubscriptionServices::class)->verfirySubscription();
          
          if (!$verfirySubscription && !in_array($user->rol_id, $roles)) {
              return redirect()->route('subscription');
          }
          
          return $next($request);
      }
      
      public function checkRolPermissions($request, $next, $route)
      {
          $user = $this->verifyAuthUser();
          
          if ($user instanceof \Illuminate\Http\RedirectResponse) {
              return $user;
          }
          
          $rolPermissions = new RolPermissionsServices();
          
          $verifyPermission = $rolPermissions->verifyPermission($route);
          
          if (!$verifyPermission) {
              return redirect()->route('admin.panel');
          }
          
          return $next($request);
      }
}