<?php

require_once "app/dao/interfaces/IMovimientoDAO.php";

class SalidaService
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

    public function listarSalidasRecientes(): array
    {
        return $this->movimientoDAO->listarSalidasRecientes();
    }

    public function registrarSalida(array $datos, int $idUsuario): void
    {
        $idProducto = (int) ($datos["id_producto"] ?? 0);
        $cantidad = (int) ($datos["cantidad"] ?? 0);
        $motivo = trim($datos["motivo"] ?? "");
        $observacion = trim($datos["observacion"] ?? "");

        if ($idProducto <= 0) {
            throw new Exception("Debe seleccionar un producto.");
        }

        if ($cantidad <= 0) {
            throw new Exception("La cantidad debe ser mayor a cero.");
        }

        if ($motivo === "") {
            throw new Exception("Debe ingresar el motivo de la salida.");
        }

        $motivo = htmlspecialchars($motivo, ENT_QUOTES, "UTF-8");
        $observacion = htmlspecialchars($observacion, ENT_QUOTES, "UTF-8");

        $this->movimientoDAO->registrarSalida(
            $idProducto,
            $idUsuario,
            $cantidad,
            $motivo,
            $observacion
        );
    }
}