<?php

require_once "app/dao/interfaces/IDashboardDAO.php";

class DashboardService
{
    private IDashboardDAO $dashboardDAO;

    public function __construct(IDashboardDAO $dashboardDAO)
    {
        $this->dashboardDAO = $dashboardDAO;
    }

    public function obtenerResumenGeneral(): array
    {
        return $this->dashboardDAO->obtenerResumenGeneral();
    }

    public function listarUltimosMovimientos(): array
    {
        return $this->dashboardDAO->listarUltimosMovimientos();
    }

    public function listarProductosStockBajo(): array
    {
        return $this->dashboardDAO->listarProductosStockBajo();
    }
}