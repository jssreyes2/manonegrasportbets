<?php

namespace App\Services\Settings;

use App\Models\Bank;
use App\Models\Parameter;
use App\Models\UserProfile;
use App\Services\FileServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ParameterServices
{
    /** Preparamos la vista de Parametro */
    public function prepareViewIndexData()
    {
        $parameter = Parameter::getParameter();
        
        return view('admin.parameter.form_parameter', compact( 'parameter'));
    }
    
    /** Creamos parametro */
    public function storePatameter(array $data)
    {
        try {
            
            DB::beginTransaction();
            $parameter = Parameter::saveParameter($data);
           
            //Guardamos el logo
            $file = new FileServices();
            $file->storeImage($parameter, Parameter::FOLDER_COMPANY,  $parameter->id,Parameter::NAME_FILE, $data);
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito']);
            
        } catch (\Throwable $e) {
            
            DB::rollBack();
            
            throw $e;
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /** Actualizamos parametro */
    public function updateParameter(array $data)
    {
        try {
            
            DB::beginTransaction();
            $parameter = Parameter::updateParameter($data);
            
            $file = new FileServices();
            $file->storeImage($parameter, Parameter::FOLDER_COMPANY, $parameter->id, Parameter::NAME_FILE, $data);
            
            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Datos guardados con éxito']);
            
        } catch (\Throwable $e) {
            
            DB::rollBack();
            
            throw $e;
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
}