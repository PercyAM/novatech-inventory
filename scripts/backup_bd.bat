@echo off
title Backup de base de datos - NovaTech Inventory

set "PROJECT_DIR=C:\xampp\htdocs\novatech_inventory"
set "MYSQLDUMP=C:\xampp\mysql\bin\mysqldump.exe"
set "BACKUP_DIR=%PROJECT_DIR%\backups"

for /f %%i in ('powershell -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set FECHA=%%i

if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

echo Generando backup de la base de datos...
"%MYSQLDUMP%" -u root bd_inventario_computo > "%BACKUP_DIR%\backup_bd_inventario_%FECHA%.sql"

if errorlevel 1 (
    echo Error al generar el backup.
    echo [%FECHA%] ERROR: No se pudo generar backup de la base de datos. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"
    pause
    exit /b 1
)

echo Backup generado correctamente:
echo %BACKUP_DIR%\backup_bd_inventario_%FECHA%.sql

echo [%FECHA%] Backup de base de datos generado correctamente. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"

pause