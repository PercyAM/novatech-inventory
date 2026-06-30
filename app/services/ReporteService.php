<?php

require_once "app/dao/interfaces/IReporteDAO.php";

class ReporteService
{
    private IReporteDAO $reporteDAO;

    public function __construct(IReporteDAO $reporteDAO)
    {
        $this->reporteDAO = $reporteDAO;
    }

    public function obtenerResumenGeneral(): array
    {
        return $this->reporteDAO->obtenerResumenGeneral();
    }

    public function listarInventario(): array
    {
        return $this->reporteDAO->listarInventario();
    }

    public function listarStockBajo(): array
    {
        return $this->reporteDAO->listarStockBajo();
    }

    public function listarMovimientosRecientes(): array
    {
        return $this->reporteDAO->listarMovimientosRecientes();
    }

    public function exportarInventarioCSV(): void
    {
        $inventario = $this->reporteDAO->listarInventario();

        $nombreArchivo = "reporte_inventario_" . date("Y-m-d_H-i-s") . ".csv";

        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $salida = fopen("php://output", "w");

        fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($salida, [
            "Código",
            "Producto",
            "Categoría",
            "Marca",
            "Modelo",
            "Stock actual",
            "Stock mínimo",
            "Precio referencial",
            "Estado"
        ], ";");

        foreach ($inventario as $producto) {
            fputcsv($salida, [
                $producto["codigo_producto"],
                $producto["nombre_producto"],
                $producto["categoria"],
                $producto["marca"],
                $producto["modelo"],
                $producto["stock_actual"],
                $producto["stock_minimo"],
                $producto["precio_referencial"],
                $producto["estado"]
            ], ";");
        }

        fclose($salida);
        exit();
    }
}