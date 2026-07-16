@echo off
title Limpieza de logs - NovaTech Inventory

set "PROJECT_DIR=C:\xampp\htdocs\novatech_inventory"
set "LOG_FILE=%PROJECT_DIR%\storage\logs\app.log"
set "LOG_BACKUP_DIR=%PROJECT_DIR%\backups\logs"

for /f %%i in ('powershell -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set FECHA=%%i

if not exist "%LOG_BACKUP_DIR%" mkdir "%LOG_BACKUP_DIR%"

if exist "%LOG_FILE%" (
    copy "%LOG_FILE%" "%LOG_BACKUP_DIR%\app_log_%FECHA%.log"
    echo. > "%LOG_FILE%"
    echo Log principal respaldado y limpiado correctamente.
    echo [%FECHA%] Log app.log respaldado y limpiado. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"
) else (
    echo No se encontro el archivo app.log.
    echo [%FECHA%] ADVERTENCIA: No se encontro app.log. >> "%PROJECT_DIR%\storage\logs\mantenimiento.log"
)

pause