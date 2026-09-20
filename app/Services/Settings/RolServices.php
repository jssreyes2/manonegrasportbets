<?php

namespace App\Services\Settings;

use App\Models\Country;
use App\Models\Menu;
use App\Models\Rol;
use App\Repositories\Settings\MenuRepository;
use App\Repositories\Settings\RolRepository;
use Illuminate\Support\Facades\Auth;

class RolServices
{
    
    private function getRol(?array $filter = [])
    {
        return RolRepository::getRol($filter);
    }
    
    private function getMenuParents()
    {
        return Menu::with('children')->orderBy('position', 'ASC')->get()->toArray();
    }
    
    private function getMenuChildren($menuParents)
    {
        return MenuRepository::buildTree($menuParents);
    }
    
    private function getPermissionHasRoles($id)
    {
        return MenuRepository::getPermissionHasRoles($id);
    }
    
    /** Preparamos la vista de lista de rol */
    public function prepareViewIndexData(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        array_push($filter, ['parent' => 0]);
        
        $viewData = [
            'filter' => $filter,
            'roles'  => $this->getRol($filter)->paginate(config('app.npage'))
        ];
        
        return view('admin.rol.table-rol', $viewData);
    }
    
    /** Preparamos la vista de crear rol */
    public function prepareViewCreateData()
    {
        #Traemos los padres
        $menuParents = $this->getMenuParents();
        #Traemos los hijos
        $menuChildren = $this->getMenuChildren($menuParents);
        return view('admin.rol.form-rol', ['menus' => $menuChildren]);
    }
    
    /** Preparamos la vista de editar rol */
    public function prepareViewEditData(array $data)
    {
        #Traemos los padres
        $menuParents = $this->getMenuParents();
        #Traemos los hijos
        $menuChildren = $this->getMenuChildren($menuParents);
        #Traemos los permisosn segun roles
        $arrPermission = $this->getPermissionHasRoles(['id' => $data['id']]);
        
        return view('admin.rol.form-rol', [
            'rol'           => $this->getRol(['id' => $data['id']])->first(),
            'menus'         => $menuChildren,
            'arrPermission' => $arrPermission
        ]);
    }
    
    public function createRol($data)
    {
        $rol = Rol::saveRol($data);
        
        if (!$rol) {
            return response()->json(['status' => 'fail', 'message' => 'Los datos no se guardaron, por favor contacte al administrador del sistema.']);
        }
        
        Rol::registerPermissions($rol->id, $data);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function updateRol($data)
    {
        $rol = Rol::updateRol($data);
        
        if (!$rol) {
            return response()->json(['status' => 'fail', 'message' => 'Los datos no se guardaron, por favor contacte al administrador del sistema.']);
        }
        
        Rol::registerPermissions($rol->id, $data);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
    }
    
    public function deleteRol(array $data)
    {
        Rol::destroy($data['id']);;
        
        return response()->json(['status' => 'success', 'message' => "Datos eliminados con éxito"]);
    }
}