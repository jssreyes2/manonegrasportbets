<?php

namespace App\Repositories\Settings;


use App\Models\Country;
use App\Models\Menu;
use App\Models\Rol;
use App\Models\RoleHasPermissions;
use Illuminate\Support\Facades\Auth;

class MenuRepository
{
    
    public static function getMenu(array $filter = [])
    {
        $query = Menu::select('*');
        
        if ($filter and (isset($filter['search']) and !empty($filter['search']))) {
            $query->where('name', 'like', "%" . $filter['search'] . "%");
        }
        
        if ($filter && isset($filter['is_active']) && in_array((int)$filter['is_active'], [0, 1], true)) {
            $query->where('is_active', (int)$filter['is_active']);
            $s = 1;
        }
        
        if ($filter and (isset($filter['id']) and !empty($filter['id']))) {
            $query->where('id', $filter['id']);
        }
        
        if ($filter and (isset($filter[0]))) {
            $query->where('parent', $filter[0]['parent']);
        }
        
        if ($filter and (isset($filter['sub_menu']))) {
            $query->where('parent', '!=', 0);
        }
        
        if ($filter and (isset($filter['type']))) {
            $query->where('type', '=', $filter['type']);
        }
        
        $query->orderBy('position', 'ASC');
        
        return $query;
    }
    
    
    public static function optionsMenu()
    {
        $rol = Auth::user()->rol_id;
        
        $lan = Country::LANGUAGE_ES;
        if ($rol == Rol::ROL_CUSTOMER) {
            $lan = session_language();
        }
        
        return Menu::join('role_has_permissions', function ($join) use ($rol) {
            $join->on('menus.id', '=', 'role_has_permissions.id_menu');
            $join->where('role_has_permissions.role_id', '=', $rol);
        })
            ->select('role_has_permissions.new', 'role_has_permissions.edit', 'role_has_permissions.delet', 'menus.*')
            ->where('menus.is_active', true)
            ->where('menus.language', $lan)
            ->orderby('menus.parent')
            ->orderby('menus.position')
            ->orderby('menus.name')
            ->get()
            ->toArray();
    }
    
    
    public static function menus()
    {
        $query   = new MenuRepository();
        $data    = $query->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item    = [array_merge($line, ['submenu' => $query->getChildren($data, $line)])];
            $menuAll = array_merge($menuAll, $item);
        }
        return $query->menuAll = $menuAll;
    }
    
    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getChildren($data, $line1)])]);
            }
        }
        return $children;
    }
    
    
    public static function buildTree(array $elements, $parentId = 0)
    {
        
        $branch = array();
        
        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = MenuRepository::buildTree($elements, $element['id']);
                
                if ($children) {
                    $element['children'] = $children;
                }
                
                $branch[] = $element;
            }
        }
        
        return $branch;
    }
    
    public static function getAdditionalPermissions($menuId = null, $rolId = null)
    {
        $additionalPermissions = Menu::join('role_has_permissions', 'role_has_permissions.id_menu', '=', 'menus.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('menus.name', 'menus.icono', 'menus.position', 'menus.parent', 'menus.route', 'menus.id AS menu_id', 'role_has_permissions.new', 'role_has_permissions.edit', 'role_has_permissions.delet', 'role_has_permissions.role_id')
            ->where('menus.id', '=', $menuId)
            ->where('roles.id', '=', $rolId)
            ->first();
        
        return $additionalPermissions;
    }
    
    public static function getPermissionHasRoles($id = null)
    {
        
        $hasRolesPermission = Menu::join('role_has_permissions', 'role_has_permissions.id_menu', '=', 'menus.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('menus.id')
            ->where('role_has_permissions.role_id', '=', $id)
            ->get()->toArray();
        
        $arrPermission = [];
        
        if ($hasRolesPermission) {
            foreach ($hasRolesPermission as $items) {
                $arrPermission[] .= $items['id'];//id del menu
            }
        }
        
        return $arrPermission;
    }
    
    public static function getMenuParent($id = null)
    {
        //DB::enableQueryLog();
        $parent = RoleHasPermissions::select('parent')
            ->where('role_has_permissions.role_id', '=', $id)
            ->orderBy('parent', 'ASC')
            ->groupBy('parent')
            ->get()->toArray();
        
        //dd(DB::getQueryLog());
        
        $arrParent = [];
        
        if ($parent) {
            foreach ($parent as $items) {
                $arrParent[] .= $items['parent'];
            }
        }
        return $arrParent;
    }
    
    
}