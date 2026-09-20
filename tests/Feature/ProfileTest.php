<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpload()
    {
        Storage::fake('local');
        
        $response = $this->post('profile',
            [
                'photo' => $photo = UploadedFile::fake()->image('photo.png')
            ]);
        
        Storage::disk('local')->assertExists("profiles/{$photo->hashName()}");
        
        $response->assertRedirect('home');
    }
    
    
    public function testPhotoRequired()
    {
        $response=$this->post('profile', ['photo' => null]);
        
        $response->assertSessionHasErrors('photo');
    }
    
}
