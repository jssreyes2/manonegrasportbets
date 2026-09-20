<?php

namespace App\Services\Settings;

use App\Models\Menu;
use App\Repositories\Settings\MenuRepository;

class SubMenuServices
{
    
    private function getMenu(?array $filter=[])
    {
        return MenuRepository::getMenu($filter);
    }
    
    /** Preparamos la vista de lista de sub-menus */
    public function prepareViewIndexData(array $data)
    {
        $filter = ['sub_menu' => true];
        if (isset($data['filter'])) {
            $filter = $data['filter'];
            array_merge(['sub_menu' => true]);
        }
        
        $id = $data['id'] ?? [];
        
        if (!empty($id)) {
            $filter = array_merge($filter, ['id' => $data['id']]);
        }
        
        $viewData = [
            'subMenus' => $this->getMenu($filter)->paginate(config('app.npage')),
            'filter'   => $filter
        ];
        
        return view('admin.sub_menu.table-sub-menu', $viewData);
    }
    
    /** Preparamos la vista de editar sub-menus */
    public function prepareViewEditData(array $data)
    {
        $subMenu = $this->getMenu(['id' => $data['id']])->first();
        $menus   = $this->getMenu(['parent' => 0]);
        $menus   = $menus->where(['is_active' => true])->get()->toArray();
        return view('admin.sub_menu.form-sub-menu', ['menus' => $menus, 'subMenu' => $subMenu]);
    }
    
    
    public function updateSubMenu(array $data)
    {
        Menu::updateSubMenu($data);
        
        return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito']);
    }
    
    public function deleteSubMenu(array $data)
    {
        Menu::destroy($data['id']);
        
        return response()->json(['status' => 'success', 'message' => 'Datos eliminados con éxito']);
    }
}