@echo off
echo Generando helpers de IDE para Laravel...
echo.

php artisan ide-helper:generate
if %errorlevel% neq 0 (
    echo Error generando ide-helper:generate
    exit /b %errorlevel%
)

php artisan ide-helper:models --nowrite
if %errorlevel% neq 0 (
    echo Error generando ide-helper:models
    exit /b %errorlevel%
)

php artisan ide-helper:meta
if %errorlevel% neq 0 (
    echo Error generando ide-helper:meta
    exit /b %errorlevel%
)

echo.
echo Helpers de IDE generados exitosamente!
echo Archivos creados:
echo   - _ide_helper.php
echo   - _ide_helper_models.php
echo   - .phpstorm.meta.php
echo.
echo Estos archivos deben ser agregados al .gitignore
echo.