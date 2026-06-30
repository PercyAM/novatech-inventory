<?php

require_once "app/dao/interfaces/IReporteDAO.php";

class ReporteDAO implements IReporteDAO
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerResumenGeneral(): array
    {
        $resumen = [];

        $sqlProductos = "SELECT COUNT(*) FROM producto WHERE estado = 'Activo'";
        $stmt = $this->conexion->prepare($sqlProductos);
        $stmt->execute();
        $resumen["productos_activos"] = (int) $stmt->fetchColumn();

        $sqlStockBajo = "SELECT COUNT(*) 
                         FROM producto 
                         WHERE estado = 'Activo' 
                         AND stock_actual <= stock_minimo";
        $stmt = $this->conexion->prepare($sqlStockBajo);
        $stmt->execute();
        $resumen["productos_stock_bajo"] = (int) $stmt->fetchColumn();

        $sqlUsuarios = "SELECT COUNT(*) FROM usuario WHERE estado = 'Activo'";
        $stmt = $this->conexion->prepare($sqlUsuarios);
        $stmt->execute();
        $resumen["usuarios_activos"] = (int) $stmt->fetchColumn();

        $sqlMovimientos = "SELECT COUNT(*) FROM movimiento_inventario";
        $stmt = $this->conexion->prepare($sqlMovimientos);
        $stmt->execute();
        $resumen["total_movimientos"] = (int) $stmt->fetchColumn();

        $sqlEntradas = "SELECT COUNT(*) 
                        FROM movimiento_inventario 
                        WHERE tipo_movimiento = 'Entrada'";
        $stmt = $this->conexion->prepare($sqlEntradas);
        $stmt->execute();
        $resumen["total_entradas"] = (int) $stmt->fetchColumn();

        $sqlSalidas = "SELECT COUNT(*) 
                       FROM movimiento_inventario 
                       WHERE tipo_movimiento = 'Salida'";
        $stmt = $this->conexion->prepare($sqlSalidas);
        $stmt->execute();
        $resumen["total_salidas"] = (int) $stmt->fetchColumn();

        return $resumen;
    }

    public function listarInventario(): array
    {
        $sql = "SELECT 
                    p.id_producto,
                    p.codigo_producto,
                    p.nombre_producto,
                    p.modelo,
                    p.stock_actual,
                    p.stock_minimo,
                    p.precio_referencial,
                    p.estado,
                    d.categoria,
                    d.marca
                FROM producto p
                INNER JOIN detalle_producto d 
                    ON p.id_detalle_producto = d.id_detalle_producto
                ORDER BY p.nombre_producto ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarStockBajo(): array
    {
        $sql = "SELECT 
                    p.codigo_producto,
                    p.nombre_producto,
                    p.modelo,
                    p.stock_actual,
                    p.stock_minimo,
                    d.categoria,
                    d.marca
                FROM producto p
                INNER JOIN detalle_producto d 
                    ON p.id_detalle_producto = d.id_detalle_producto
                WHERE p.estado = 'Activo'
                AND p.stock_actual <= p.stock_minimo
                ORDER BY p.stock_actual ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarMovimientosRecientes(): array
    {
        $sql = "SELECT 
                    m.fecha_movimiento,
                    m.tipo_movimiento,
                    m.cantidad,
                    m.motivo,
                    m.observacion,
                    p.codigo_producto,
                    p.nombre_producto,
                    u.nombre_usuario
                FROM movimiento_inventario m
                INNER JOIN producto p ON m.id_producto = p.id_producto
                INNER JOIN usuario u ON m.id_usuario = u.id_usuario
                ORDER BY m.fecha_movimiento DESC
                LIMIT 10";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}