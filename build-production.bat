@echo off
echo ========================================
echo   COMPILANDO ASSETS PARA PRODUCCION
echo ========================================
echo.

echo [1/4] Instalando dependencias faltantes...
call npm install
echo.

echo [2/4] Limpiando directorio build anterior...
if exist public\build rmdir /s /q public\build
echo.

echo [3/4] Compilando assets con Vite (produccion)...
call npm run build:prod
echo.

echo [4/4] Verificando archivos generados...
if exist public\build\manifest.json (
    echo ✓ Compilacion exitosa!
    echo ✓ Archivos generados en public/build/
    echo.
    echo IMPORTANTE: Sube la carpeta public/build/ a tu servidor de produccion
) else (
    echo × Error en la compilacion
)
echo.
pause
