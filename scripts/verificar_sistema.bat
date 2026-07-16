@echo off
title Verificacion del sistema - NovaTech Inventory

set "PROJECT_DIR=C:\xampp\htdocs\novatech_inventory"
set "REPORT_DIR=%PROJECT_DIR%\reports\health"

for /f %%i in ('powershell -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set FECHA=%%i

if not exist "%REPORT_DIR%" mkdir "%REPORT_DIR%"

echo Verificando acceso al sistema...
powershell -NoProfile -Command "try { $r = Invoke-WebRequest -Uri 'http://localhost/novatech_inventory' -UseBasicParsing -TimeoutSec 10; 'Estado HTTP: ' + $r.StatusCode; 'Sistema accesible correctamente.' } catch { 'ERROR: ' + $_.Exception.Message; exit 1 }" > "%REPORT_DIR%\health_%FECHA%.txt"

if errorlevel 1 (
    echo Error: el sistema no responde correctamente.
    echo [%FECHA%] ERROR: El sistema no responde en localhost. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"
    pause
    exit /b 1
)

echo Verificacion completada correctamente.
echo Reporte generado en:
echo %REPORT_DIR%\health_%FECHA%.txt

echo [%FECHA%] Verificacion del sistema completada correctamente. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"

pause