<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesSlugsTrait
{
    public function generateSlug(string $text, string $modelClass, string $column = 'source', ?int $ignoreId=null): string
    {
        // Limpiar texto
        $cleaned = $this->cleanForSlug($text);
        
        // Generar slug base
        $slug = Str::slug($cleaned, '-');
        
        // Si está vacío
        if (empty($slug)) {
            $slug = 'item-' . time();
        }
        
        // Hacer único
        return $this->makeSlugUnique($slug, $modelClass, $column, $ignoreId);
    }
    
    public function cleanForSlug(string $text): string
    {
        return (string)Str::of($text)
            ->trim()
            ->lower()
            ->ascii()
            ->replaceMatches('/[^\w\s]/', '')
            ->replaceMatches('/\s+/', ' ');
    }
    
    public function makeSlugUnique(string $slug, string $modelClass, string $column, $ignoreId = null): string
    {
        // Construir la consulta base
        $query = $modelClass::where($column, $slug);
        
        // Si estamos actualizando un registro, ignorar su propio ID
        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }
        
        // Si el slug original no existe, devolverlo tal cual
        if (!$query->exists()) {
            return $slug;
        }
        
        // IMPORTANTE: Si el slug ya contiene un número al final (como -3),
        // mantenerlo y buscar incrementando desde ese número
        if (preg_match('/^(.+)-(\d+)$/', $slug, $matches)) {
            $baseSlug = $matches[1]; // Parte sin el número final
            $existingNumber = (int)$matches[2]; // Número que ya tenía
            
            // Empezar desde el número original + 1
            $count = $existingNumber + 1;
            $newSlug = $baseSlug . '-' . $count;
            
            // Verificar si ya existe
            while ($modelClass::where($column, $newSlug)->when($ignoreId, function ($q) use ($ignoreId) {
                return $q->where('id', '!=', $ignoreId);
            })->exists()) {
                $count++;
                $newSlug = $baseSlug . '-' . $count;
            }
            
            return $newSlug;
        }
        
        // Si no terminaba con número, añadir -2, -3, etc.
        $original = $slug;
        $count = 2;
        
        while ($modelClass::where($column, $original . '-' . $count)->when($ignoreId, function ($q) use ($ignoreId) {
            return $q->where('id', '!=', $ignoreId);
        })->exists()) {
            $count++;
        }
        
        return $original . '-' . $count;
    }
}