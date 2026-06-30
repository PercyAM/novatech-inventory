<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/ReporteDAO.php";
require_once "app/services/ReporteService.php";

class ReporteController
{
    private ReporteService $reporteService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $reporteDAO = new ReporteDAO($conexion);
        $this->reporteService = new ReporteService($reporteDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $resumen = $this->reporteService->obtenerResumenGeneral();
        $inventario = $this->reporteService->listarInventario();
        $stockBajo = $this->reporteService->listarStockBajo();
        $movimientos = $this->reporteService->listarMovimientosRecientes();

        require_once "views/reportes/index.php";
    }

    public function exportarInventario(): void
    {
        SessionHelper::verificarSesion();

        $this->reporteService->exportarInventarioCSV();
    }
}