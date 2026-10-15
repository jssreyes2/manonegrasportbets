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

echo [3/4] Compilando assets con Vite (vite.config.js, incluye Tailwind)...
call npm run build
echo.

echo [4/4] Verificando archivos generados...
if exist public\build\manifest.json (
    echo [OK] Compilacion exitosa!
    echo [OK] Archivos generados en public/build/
    echo.
    echo IMPORTANTE: Sube la carpeta public/build/ a tu servidor de produccion
    echo            ^(reemplaza la anterior^).
) else (
    echo [ERROR] Fallo la compilacion: revisa los mensajes de arriba.
)
echo.

if exist public\hot (
    echo [AVISO] Existe public\hot ^(lo crea "npm run dev"^).
    echo         NO lo subas al servidor: haria que la web cargue los assets
    echo         desde 127.0.0.1 y se vea sin estilos.
    echo.
)

pause
