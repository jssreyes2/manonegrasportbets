<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class FileServices
{
    
    public function storeImage($model, $folder, $subFolder, $name, $data, $scale = 800)
    {
        if (!isset($data['photo'])) {
            return false;
        }
        
        $file = $data['photo'];
        
        try {
            // Validaciones básicas
            if (!$file->isValid()) {
                throw new \Exception('Archivo no válido');
            }
            
            // Eliminar foto anterior
            if ($model->photo) {
                $oldPath = storage_path('app/public/' . $folder . '/' . $subFolder . '/' . $model->photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Crear directorio
            $relativePath = $folder . '/' . $subFolder;
            $storagePath  = storage_path('app/public/' . $relativePath);
            
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            
            // Generar nombre
            $extension = $file->getClientOriginalExtension();
            $namePhoto = $name . '-' . time() . '.' . $extension;
            
            // MÉTODO SIMPLE: Mover el archivo directamente
            $file->move($storagePath, $namePhoto);
            
            // Intentar procesar con Intervention si está disponible
            if (class_exists('Intervention\Image\ImageManager')) {
                try {
                    $fullPath = $storagePath . '/' . $namePhoto;
                    $manager  = ImageManager::gd();
                    $img      = $manager->read($fullPath);
                    
                    if ($scale) {
                        $img->scale(width: $scale);
                    }
                    
                    // Sobrescribir el archivo original
                    if (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
                        $img->toJpeg(90)->save($fullPath);
                    } elseif ($extension === 'png') {
                        $img->toPng()->save($fullPath);
                    }
                } catch (\Throwable $e) {
                    throw $e;
                }
            }
            
            // Actualizar modelo
            $model->photo = $namePhoto;
            $model->save();
            
            return asset('storage/' . $relativePath . '/' . $namePhoto);
            
        } catch (\Throwable $e) {
            throw $e;
            return false;
        }
    }
    
    public function getUrl($folder, $subFolder, $image)
    {
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $subFolder . DIRECTORY_SEPARATOR . $image);
        if (file_exists($path)) {
            return asset('storage/' . $folder . '/' . $subFolder . '/' . $image);
        }
        
        return asset('storage/img/logo.png');
    }
    
    
    public function uploadPDF($request, $model, $folder, $action = 'create')
    {
        
        if (!$request->hasFile('file_pdf')) {
            return false;
        }
        
        $file = $request->file('file_pdf');
        
        if ($action == 'update') {
            $this->deleteFile($model);
        }
        
        // Obtener la carpeta de destino según el número de archivos
        $destinationFolder = $this->getDestinationFolder($folder);
        
        // Generar nombre único para el archivo
        $filename = $this->generateUniqueFilename($file);
        
        // Guardar el archivo usando storeAs
        $path = storage_path('app/public/' . $destinationFolder . '/' . $filename);
        
        $file->move(storage_path('app/public/' . $destinationFolder), $filename);
        
        $relativePath = $destinationFolder . '/' . $filename;
        
        // Verificar que se guardó correctamente
        if (!$path) {
            throw new \Exception('No se pudo guardar el archivo');
        }
        
        $model->filename  = $filename;
        $model->path_file = $relativePath;
        $model->update();
    }
    
    /**
     * Determinar la carpeta de destino basado en el conteo de archivos
     */
    private function getDestinationFolder($basePath)
    {
        try {
            
            // Verificar si la carpeta base existe, si no, crearla
            if (!Storage::disk('public')->exists($basePath)) {
                Storage::disk('public')->makeDirectory($basePath, 0755, true);
            }
            
            // Obtener todos los archivos existentes en todas las subcarpetas
            $allFiles   = Storage::disk('public')->allFiles($basePath);
            $totalFiles = count($allFiles);
            
            // Calcular el número de carpeta (cada 1000 archivos)
            $folderNumber = floor($totalFiles / 1000) + 1;
            
            // Crear la estructura de carpetas: pdfs/0001, pdfs/0002, etc.
            $folderName = str_pad($folderNumber, 4, '0', STR_PAD_LEFT);
            $fullPath   = $basePath . '/' . $folderName;
            
            // Verificar si la carpeta específica existe, si no, crearla
            if (!Storage::disk('public')->exists($fullPath)) {
                Storage::disk('public')->makeDirectory($fullPath, 0755, true);
            }
            
            return $fullPath;
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            $fallbackPath = 'pdfs/fallback';
            if (!Storage::disk('public')->exists($fallbackPath)) {
                Storage::disk('public')->makeDirectory($fallbackPath, 0755, true);
            }
            
            return $fallbackPath;
        }
    }
    
    /**
     * Generar nombre único para el archivo
     */
    private function generateUniqueFilename($file)
    {
        $extension    = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        // Limpiar el nombre original (quitar caracteres especiales)
        $cleanName = Str::slug($originalName);
        
        // Generar nombre único con timestamp y uuid
        $uniqueId = uniqid() . '_' . Str::uuid();
        
        return sprintf(
            '%s_%s.%s',
            $cleanName,
            $uniqueId,
            $extension
        );
    }
    
    public function deleteFile($model)
    {
        $path = storage_path('app/public/' . $model->path_file);
        if (file_exists($path)) {
            unlink($path);
        }
        
        $model->filename       = null;
        $model->path_file      = null;
        $model->total_download = null;
        $model->update();
    }
    
}