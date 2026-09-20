<?php


namespace App\Services;


use App\Repositories\Settings\MenuRepository;

class RolPermissionsServices
{
    public function verifyPermission($route)
    {
        $menusUser = MenuRepository::optionsMenu();
        
        if (count($menusUser) > 0) {
            foreach ($menusUser as $item) {
                if ($item['route'] and $item['route'] == $route) {
                    return true;
                }
            }
        }
        
        return false;
    }
}