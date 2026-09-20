# Configuración de Intelephense para Laravel

Esta configuración mejora la experiencia de desarrollo con Laravel en VS Code usando Intelephense.

## Archivos instalados/modificados

1. **`.vscode/settings.json`** - Configuración de VS Code mejorada para Laravel
2. **`.vscode/intelephense.json`** - Configuración específica de Intelephense
3. **`composer.json`** - Scripts para generar helpers de IDE automáticamente
4. **`app/Providers/AppServiceProvider.php`** - Registro condicional de Laravel IDE Helper
5. **`.gitignore`** - Archivos generados excluidos del control de versiones
6. **`ide-helper.bat`** - Script para generar helpers manualmente (Windows)

## Paquetes instalados

- **`barryvdh/laravel-ide-helper`** - Genera archivos de ayuda para el autocompletado

## Características habilitadas

### Para Intelephense:
- Autocompletado para facades de Laravel (`Auth::`, `Route::`, `Config::`, etc.)
- Navegación a definiciones en `config()` (ej: `config('app.npage')`)
- Autocompletado para modelos de Eloquent
- Detección de métodos mágicos en modelos
- Soporte para helpers de Laravel (`view()`, `route()`, `asset()`, etc.)

### Archivos generados por Laravel IDE Helper:
1. **`_ide_helper.php`** - Definiciones para facades y helpers
2. **`_ide_helper_models.php`** - Definiciones para modelos Eloquent
3. **`.phpstorm.meta.php`** - Metadatos para el autocompletado

## Uso

### Generar helpers automáticamente:
Los helpers se generan automáticamente al ejecutar `composer install` o `composer update`.

### Generar helpers manualmente:
Ejecuta el script batch:
```bash
ide-helper.bat
```

O los comandos manualmente:
```bash
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta
```

### Para navegar a configuraciones:
Cuando uses `config('app.npage')` o cualquier configuración:
1. **Ctrl+Click** (Windows/Linux) o **Cmd+Click** (Mac) en `config('app.npage')`
2. Esto te llevará al archivo `config/app.php`
3. Intelephense mostrará el valor actual de la configuración en hover

### Para autocompletado de modelos:
Al escribir código como:
```php
$user = User::where('email', '...')
```

Intelephense mostrará:
- Autocompletado de columnas de la tabla
- Métodos de relación definidos en el modelo
- Scopes definidos en el modelo

## Solución de problemas

### Si el autocompletado no funciona:
1. Verifica que Intelephense esté instalado en VS Code
2. Reinicia VS Code después de generar los helpers
3. Ejecuta `composer dump-autoload`

### Si no puedes navegar a configuraciones:
1. Verifica que el archivo `.phpstorm.meta.php` esté presente
2. Ejecuta `php artisan ide-helper:meta` nuevamente
3. Reinicia el servidor de lenguaje en VS Code (Ctrl+Shift+P → "Intelephense: Restart Language Server")

### Errores comunes:
- **"Class not found"**: Ejecuta `composer dump-autoload`
- **"Undefined method"**: Genera los helpers nuevamente con `ide-helper.bat`
- **"Cannot navigate to config"**: Verifica que el archivo `.phpstorm.meta.php` exista

## Actualización de helpers

Recomendado ejecutar después de:
- Agregar nuevos modelos
- Agregar nuevas configuraciones
- Cambiar estructuras de base de datos
- Actualizar Laravel o paquetes

```bash
ide-helper.bat
```

## Notas

- Los archivos generados (`_ide_helper.php`, `_ide_helper_models.php`, `.phpstorm.meta.php`) están excluidos de git en `.gitignore`
- La configuración solo se aplica en entorno local (`APP_ENV=local`)
- Para producción, estos helpers no se cargan