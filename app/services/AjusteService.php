<?php

require_once "app/dao/interfaces/IMovimientoDAO.php";

class AjusteService
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

    public function listarAjustesRecientes(): array
    {
        return $this->movimientoDAO->listarAjustesRecientes();
    }

    public function registrarAjuste(array $datos, int $idUsuario): void
    {
        $idProducto = (int) ($datos["id_producto"] ?? 0);
        $stockNuevo = (int) ($datos["stock_nuevo"] ?? -1);
        $motivoDetalle = trim($datos["motivo"] ?? "");
        $observacion = trim($datos["observacion"] ?? "");

        if ($idProducto <= 0) {
            throw new Exception("Debe seleccionar un producto.");
        }

        if ($stockNuevo < 0) {
            throw new Exception("El stock nuevo no puede ser negativo.");
        }

        if ($motivoDetalle === "") {
            throw new Exception("Debe ingresar el motivo del ajuste.");
        }

        $producto = $this->movimientoDAO->obtenerProductoPorId($idProducto);

        if (!$producto) {
            throw new Exception("El producto seleccionado no existe.");
        }

        if ($producto["estado"] !== "Activo") {
            throw new Exception("No se puede ajustar un producto inactivo.");
        }

        $stockActual = (int) $producto["stock_actual"];

        if ($stockNuevo === $stockActual) {
            throw new Exception("El stock nuevo es igual al stock actual. No se realizó ningún ajuste.");
        }

        $diferencia = abs($stockNuevo - $stockActual);
        $tipoMovimiento = ($stockNuevo > $stockActual) ? "Entrada" : "Salida";

        $motivo = "Ajuste de inventario: " . htmlspecialchars($motivoDetalle, ENT_QUOTES, "UTF-8");

        $observacionCompleta = "Stock anterior: " . $stockActual .
            " | Stock nuevo: " . $stockNuevo;

        if ($observacion !== "") {
            $observacionCompleta .= " | Observación: " . htmlspecialchars($observacion, ENT_QUOTES, "UTF-8");
        }

        $this->movimientoDAO->registrarAjusteStock(
            $idProducto,
            $idUsuario,
            $stockNuevo,
            $diferencia,
            $tipoMovimiento,
            $motivo,
            $observacionCompleta
        );
    }
}