<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/MovimientoDAO.php";
require_once "app/services/HistorialService.php";

class HistorialController
{
    private HistorialService $historialService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $movimientoDAO = new MovimientoDAO($conexion);
        $this->historialService = new HistorialService($movimientoDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $productos = $this->historialService->listarProductosDisponibles();
        $movimientos = $this->historialService->listarHistorial($_GET);

        require_once "views/historial/index.php";
    }
}