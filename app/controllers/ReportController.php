<?php
declare(strict_types=1);

require_once 'app/helpers/SessionHelper.php';
require_once 'app/config/Database.php';
require_once 'app/services/ReportService.php';
require_once 'app/helpers/AppLogger.php';

class ReportController
{
    private ReportService $reportService;

    public function __construct()
    {
        $database = new Database();
        $this->reportService = new ReportService($database);
    }

    public function inventario(): void
    {
        SessionHelper::verificarSesion();

        $nombreArchivo = 'reporte_inventario_' . date('Y-m-d') . '.csv';

        // Set streaming response headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        AppLogger::getInstance()->info("Inventory report CSV downloaded", [
            'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
        ]);

        $this->reportService->exportarInventarioCsv();
        exit();
    }
}
