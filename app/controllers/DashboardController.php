<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/DashboardDAO.php";
require_once "app/services/DashboardService.php";

class DashboardController
{
    private DashboardService $dashboardService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $dashboardDAO = new DashboardDAO($conexion);
        $this->dashboardService = new DashboardService($dashboardDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $resumen = $this->dashboardService->obtenerResumenGeneral();
        $ultimosMovimientos = $this->dashboardService->listarUltimosMovimientos();
        $productosStockBajo = $this->dashboardService->listarProductosStockBajo();

        require_once "views/dashboard/index.php";
    }
}