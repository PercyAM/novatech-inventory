@echo off
title Mantenimiento semanal - NovaTech Inventory

set "PROJECT_DIR=C:\xampp\htdocs\novatech_inventory"

echo ==========================================
echo MANTENIMIENTO SEMANAL - NOVATECH INVENTORY
echo ==========================================

cd /d "%PROJECT_DIR%"

echo.
echo 1. Generando backup de base de datos...
call "%PROJECT_DIR%\scripts\backup_bd.bat"

echo.
echo 2. Verificando estado del sistema...
call "%PROJECT_DIR%\scripts\verificar_sistema.bat"

echo.
echo 3. Respaldando y limpiando logs...
call "%PROJECT_DIR%\scripts\limpiar_logs.bat"

echo.
echo Mantenimiento semanal finalizado.
pause