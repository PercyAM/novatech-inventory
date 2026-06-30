<?php

require_once "app/dao/interfaces/IMovimientoDAO.php";

class MovimientoDAO implements IMovimientoDAO
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function listarProductosDisponibles(): array
    {
        $sql = "SELECT 
                    id_producto,
                    codigo_producto,
                    nombre_producto,
                    modelo,
                    stock_actual
                FROM producto
                WHERE estado = 'Activo'
                ORDER BY nombre_producto ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarSalida(
        int $idProducto,
        int $idUsuario,
        int $cantidad,
        string $motivo,
        string $observacion
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $sqlStock = "SELECT stock_actual 
                         FROM producto 
                         WHERE id_producto = :id_producto 
                         AND estado = 'Activo'
                         FOR UPDATE";

            $stmtStock = $this->conexion->prepare($sqlStock);
            $stmtStock->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtStock->execute();

            $producto = $stmtStock->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                throw new Exception("El producto no existe o está inactivo.");
            }

            $stockActual = (int) $producto["stock_actual"];

            if ($cantidad > $stockActual) {
                throw new Exception("La cantidad solicitada supera el stock disponible.");
            }

            $sqlActualizar = "UPDATE producto
                              SET stock_actual = stock_actual - :cantidad
                              WHERE id_producto = :id_producto";

            $stmtActualizar = $this->conexion->prepare($sqlActualizar);
            $stmtActualizar->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmtActualizar->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtActualizar->execute();

            $sqlMovimiento = "INSERT INTO movimiento_inventario
                              (id_producto, id_usuario, tipo_movimiento, cantidad, motivo, observacion)
                              VALUES
                              (:id_producto, :id_usuario, 'Salida', :cantidad, :motivo, :observacion)";

            $stmtMovimiento = $this->conexion->prepare($sqlMovimiento);
            $stmtMovimiento->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":id_usuario", $idUsuario, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":motivo", $motivo);
            $stmtMovimiento->bindParam(":observacion", $observacion);
            $stmtMovimiento->execute();

            $this->conexion->commit();

            return true;
        } catch (Exception $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $e;
        }
    }

    public function listarSalidasRecientes(): array
    {
        $sql = "SELECT 
                    m.id_movimiento,
                    m.fecha_movimiento,
                    p.codigo_producto,
                    p.nombre_producto,
                    u.nombre_usuario,
                    m.cantidad,
                    m.motivo,
                    m.observacion
                FROM movimiento_inventario m
                INNER JOIN producto p ON m.id_producto = p.id_producto
                INNER JOIN usuario u ON m.id_usuario = u.id_usuario
                WHERE m.tipo_movimiento = 'Salida'
                ORDER BY m.fecha_movimiento DESC
                LIMIT 10";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarEntrada(
        int $idProducto,
        int $idUsuario,
        int $cantidad,
        string $motivo,
        string $observacion
    ): bool {
        try {
            $this->conexion->beginTransaction();

            $sqlProducto = "SELECT id_producto, stock_actual
                            FROM producto
                            WHERE id_producto = :id_producto
                            AND estado = 'Activo'
                            FOR UPDATE";

            $stmtProducto = $this->conexion->prepare($sqlProducto);
            $stmtProducto->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtProducto->execute();

            $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                throw new Exception("El producto no existe o se encuentra inactivo.");
            }

            $sqlActualizar = "UPDATE producto
                              SET stock_actual = stock_actual + :cantidad
                              WHERE id_producto = :id_producto";

            $stmtActualizar = $this->conexion->prepare($sqlActualizar);
            $stmtActualizar->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmtActualizar->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtActualizar->execute();

            $sqlMovimiento = "INSERT INTO movimiento_inventario
                              (id_producto, id_usuario, tipo_movimiento, cantidad, motivo, observacion)
                              VALUES
                              (:id_producto, :id_usuario, 'Entrada', :cantidad, :motivo, :observacion)";

            $stmtMovimiento = $this->conexion->prepare($sqlMovimiento);
            $stmtMovimiento->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":id_usuario", $idUsuario, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmtMovimiento->bindParam(":motivo", $motivo);
            $stmtMovimiento->bindParam(":observacion", $observacion);
            $stmtMovimiento->execute();

            $this->conexion->commit();

            return true;
        } catch (Exception $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            throw $e;
        }
    }

    public function listarEntradasRecientes(): array
    {
        $sql = "SELECT 
                    m.id_movimiento,
                    m.fecha_movimiento,
                    p.codigo_producto,
                    p.nombre_producto,
                    u.nombre_usuario,
                    m.cantidad,
                    m.motivo,
                    m.observacion
                FROM movimiento_inventario m
                INNER JOIN producto p ON m.id_producto = p.id_producto
                INNER JOIN usuario u ON m.id_usuario = u.id_usuario
                WHERE m.tipo_movimiento = 'Entrada'
                ORDER BY m.fecha_movimiento DESC
                LIMIT 10";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarHistorial(array $filtros): array
    {
        $sql = "SELECT 
                    m.id_movimiento,
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
                WHERE 1 = 1";

        $parametros = [];

        if (!empty($filtros["id_producto"])) {
            $sql .= " AND m.id_producto = :id_producto";
            $parametros[":id_producto"] = $filtros["id_producto"];
        }

        if (!empty($filtros["tipo_movimiento"])) {
            $sql .= " AND m.tipo_movimiento = :tipo_movimiento";
            $parametros[":tipo_movimiento"] = $filtros["tipo_movimiento"];
        }

        if (!empty($filtros["fecha_inicio"])) {
            $sql .= " AND DATE(m.fecha_movimiento) >= :fecha_inicio";
            $parametros[":fecha_inicio"] = $filtros["fecha_inicio"];
        }

        if (!empty($filtros["fecha_fin"])) {
            $sql .= " AND DATE(m.fecha_movimiento) <= :fecha_fin";
            $parametros[":fecha_fin"] = $filtros["fecha_fin"];
        }

        $sql .= " ORDER BY m.fecha_movimiento DESC LIMIT 100";

        $stmt = $this->conexion->prepare($sql);

        foreach ($parametros as $clave => $valor) {
            $stmt->bindValue($clave, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}