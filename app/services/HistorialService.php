<?php

require_once "app/dao/interfaces/IMovimientoDAO.php";

class HistorialService
{
    private IMovimientoDAO $movimientoDAO;

    public function __construct(IMovimientoDAO $movimientoDAO)
    {
        $this->movimientoDAO = $movimientoDAO;
    }

    public function listarProductosDisponibles(): array
    {
        return $this->movimientoDAO->listarProductosDisponibles();
    }

    public function listarHistorial(array $datos): array
    {
        $filtros = [
            "id_producto" => $datos["id_producto"] ?? "",
            "tipo_movimiento" => $datos["tipo_movimiento"] ?? "",
            "fecha_inicio" => $datos["fecha_inicio"] ?? "",
            "fecha_fin" => $datos["fecha_fin"] ?? ""
        ];

        return $this->movimientoDAO->listarHistorial($filtros);
    }
}