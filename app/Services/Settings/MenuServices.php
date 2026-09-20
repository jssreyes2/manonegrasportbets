<?php

namespace App\Services\Settings;

use App\Models\Menu;
use App\Repositories\Settings\MenuRepository;

class MenuServices
{
    
    private function getMenu(?array $filter=[])
    {
        return MenuRepository::getMenu($filter);
    }
    
    /** Preparamos la vista de lista de menus */
    public function prepareViewIndexData(array $data=[])
    {
        $filter = $data['filter'] ?? [];
        $id     = $data['id'] ?? [];
        
        if (empty($filter) and $id) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        array_push($filter, ['parent' => 0]);
        
        $viewData = [
            'menus'  => $this->getMenu($filter)->paginate(config('app.npage')),
            'filter' => $filter
        ];
        
        return view('admin.menu.table-menu', $viewData);
    }
    
    /** Preparamos la vista de crear menus */
    public function prepareViewCreateData()
    {
        $subMenu = $this->getMenu()->where(['is_active' => true])->get()->toArray();
        return view('admin.menu.form-menu', ['subMenu' => $subMenu]);
    }
    
    /** Preparamos la vista de editar menus */
    public function prepareViewEditData(array $data)
    {
        $menu    = $this->getMenu(['id' => $data['id']])->first();
        $subMenu = $this->getMenu()->where(['is_active' => true])->get()->toArray();
        return view('admin.menu.form-menu', ['menu' => $menu, 'subMenu' => $subMenu]);
    }
    
    public function createMenu(array $data)
    {
        
        $menu=Menu::where(['parent' => $data['id_submenu'], 'name' => $data['name']])->exists();
        
        if($menu){
            return response()->json([
                'status' => 'fail',
                'message' => 'Los datos se encuentran duplicados, por favor verifique que el nombre del menu no se encuentre registrado para el mismo directorio'
            ]);
        }
        
        Menu::saveMenu($data);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => false]);
    }
    
    public function updateMenu(array $data)
    {
        Menu::updateSubMenu($data);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito', 'edit' => true]);
    }
    
    public function deleteSubMenu(array $data)
    {
        Menu::destroy($data['id']);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
}