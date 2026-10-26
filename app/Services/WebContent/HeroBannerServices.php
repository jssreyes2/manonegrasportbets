<?php

namespace App\Services\WebContent;

use App\Models\HeroBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroBannerServices
{
    private function banner(): HeroBanner
    {
        return HeroBanner::first() ?? new HeroBanner(['overlay' => 45, 'show_video' => true]);
    }
    
    public function index()
    {
        return view('admin.web_content.hero.form-hero', ['hero' => $this->banner()]);
    }
    
    public function update($request): RedirectResponse
    {
        $hero = $this->banner();
        
        $hero->overlay    = (int)$request->overlay;
        $hero->show_video = $request->boolean('show_video');
        
        // Cada archivo nuevo reemplaza al anterior, que se borra del disco
        foreach (HeroBanner::FILE_FIELDS as $field) {
            if (!$request->hasFile($field)) {
                continue;
            }
            
            $file = $request->file($field);
            $name = str_replace('_', '-', $field) . '-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . strtolower($file->getClientOriginalExtension());
            $path = $file->storeAs(HeroBanner::FOLDER, $name, 'public');
            
            $this->deleteFile($hero->{$field});
            $hero->{$field} = $path;
        }
        
        $hero->save();
        
        return redirect()->route('hero.index')->with('success', 'Banner principal actualizado.');
    }
    
    public function restore(): RedirectResponse
    {
        $hero = $this->banner();
        
        foreach (HeroBanner::FILE_FIELDS as $field) {
            $this->deleteFile($hero->{$field});
            $hero->{$field} = null;
        }
        
        $hero->save();
        
        return redirect()->route('hero.index')->with('success', 'Se restauró el video de prueba.');
    }
    
    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
