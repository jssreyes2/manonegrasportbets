<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ruta del menú del admin "Contenido Web > Banner principal"
    private const ROUTE = 'hero.index';

    public function up(): void
    {
        if (!Schema::hasTable('hero_banners')) {
            // Una sola fila: los campos vacíos usan el video de prueba de public/video/hero
            Schema::create('hero_banners', function (Blueprint $table) {
                $table->id();
                $table->string('video_desktop')->nullable()->comment('Video de escritorio (mp4/webm)');
                $table->string('video_mobile')->nullable()->comment('Video vertical para móvil (mp4/webm)');
                $table->string('poster')->nullable()->comment('Imagen mientras carga el video');
                $table->string('poster_mobile')->nullable()->comment('Imagen vertical para móvil');
                $table->unsignedTinyInteger('overlay')->default(45)->comment('Opacidad de la capa oscura (%)');
                $table->boolean('show_video')->default(true)->comment('false = solo imagen');
                $table->timestamps();
            });
        }

        $this->addMenu();
    }

    /**
     * Agrega la opción al menú "Contenido Web" con los mismos permisos que "Comentarios",
     * buscándolos por ruta para no depender de ids fijos.
     */
    private function addMenu(): void
    {
        if (!Schema::hasTable('menus') || DB::table('menus')->where('route', self::ROUTE)->exists()) {
            return;
        }

        $sibling = DB::table('menus')->where('route', 'staticpage.contacts')->first();
        if (!$sibling) {
            return;
        }

        $menuId = DB::table('menus')->insertGetId([
            'type'       => $sibling->type,
            'name'       => 'Banner principal',
            'icono'      => null,
            'position'   => 0,
            'parent'     => $sibling->parent,
            'route'      => self::ROUTE,
            'is_active'  => 1,
            'language'   => $sibling->language,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = DB::table('role_has_permissions')->where('id_menu', $sibling->id)->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'id_menu'    => $menuId,
                'parent'     => $permission->parent,
                'role_id'    => $permission->role_id,
                'new'        => $permission->new,
                'edit'       => $permission->edit,
                'delet'      => $permission->delet,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $menuIds = DB::table('menus')->where('route', self::ROUTE)->pluck('id');
        DB::table('role_has_permissions')->whereIn('id_menu', $menuIds)->delete();
        DB::table('menus')->whereIn('id', $menuIds)->delete();

        Schema::dropIfExists('hero_banners');
    }
};
