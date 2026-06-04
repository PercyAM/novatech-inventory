<?php

require_once "app/dao/interfaces/IProductoDAO.php";
require_once "app/models/Producto.php";
require_once "app/models/DetalleProducto.php";

class ProductoDAO implements IProductoDAO
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function listar(string $busqueda = ""): array
    {
        $sql = "SELECT 
                    p.id_producto,
                    p.id_detalle_producto,
                    p.codigo_producto,
                    p.nombre_producto,
                    p.modelo,
                    p.stock_actual,
                    p.stock_minimo,
                    p.precio_referencial,
                    p.descripcion,
                    p.estado,
                    d.categoria,
                    d.marca,
                    d.descripcion AS descripcion_detalle
                FROM producto p
                INNER JOIN detalle_producto d 
                    ON p.id_detalle_producto = d.id_detalle_producto
                WHERE p.codigo_producto LIKE :busqueda
                   OR p.nombre_producto LIKE :busqueda
                   OR d.categoria LIKE :busqueda
                   OR d.marca LIKE :busqueda
                ORDER BY p.id_producto DESC";

        $stmt = $this->conexion->prepare($sql);
        $parametro = "%" . $busqueda . "%";
        $stmt->bindParam(":busqueda", $parametro);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $idProducto): ?array
    {
        $sql = "SELECT 
                    p.id_producto,
                    p.id_detalle_producto,
                    p.codigo_producto,
                    p.nombre_producto,
                    p.modelo,
                    p.stock_actual,
                    p.stock_minimo,
                    p.precio_referencial,
                    p.descripcion,
                    p.estado,
                    d.categoria,
                    d.marca,
                    d.descripcion AS descripcion_detalle
                FROM producto p
                INNER JOIN detalle_producto d 
                    ON p.id_detalle_producto = d.id_detalle_producto
                WHERE p.id_producto = :id_producto
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
        $stmt->execute();

        $producto = $stmt->fetch();

        return $producto ?: null;
    }

    public function registrar(Producto $producto, DetalleProducto $detalle): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sqlDetalle = "INSERT INTO detalle_producto 
                           (categoria, marca, descripcion)
                           VALUES 
                           (:categoria, :marca, :descripcion)";

            $stmtDetalle = $this->conexion->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ":categoria" => $detalle->getCategoria(),
                ":marca" => $detalle->getMarca(),
                ":descripcion" => $detalle->getDescripcion()
            ]);

            $idDetalleProducto = (int) $this->conexion->lastInsertId();

            $sqlProducto = "INSERT INTO producto 
                            (
                                id_detalle_producto,
                                codigo_producto,
                                nombre_producto,
                                modelo,
                                stock_actual,
                                stock_minimo,
                                precio_referencial,
                                descripcion,
                                estado
                            )
                            VALUES
                            (
                                :id_detalle_producto,
                                :codigo_producto,
                                :nombre_producto,
                                :modelo,
                                :stock_actual,
                                :stock_minimo,
                                :precio_referencial,
                                :descripcion,
                                :estado
                            )";

            $stmtProducto = $this->conexion->prepare($sqlProducto);
            $stmtProducto->execute([
                ":id_detalle_producto" => $idDetalleProducto,
                ":codigo_producto" => $producto->getCodigoProducto(),
                ":nombre_producto" => $producto->getNombreProducto(),
                ":modelo" => $producto->getModelo(),
                ":stock_actual" => $producto->getStockActual(),
                ":stock_minimo" => $producto->getStockMinimo(),
                ":precio_referencial" => $producto->getPrecioReferencial(),
                ":descripcion" => $producto->getDescripcion(),
                ":estado" => $producto->getEstado()
            ]);

            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }

    public function actualizar(Producto $producto, DetalleProducto $detalle): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sqlDetalle = "UPDATE detalle_producto
                           SET categoria = :categoria,
                               marca = :marca,
                               descripcion = :descripcion
                           WHERE id_detalle_producto = :id_detalle_producto";

            $stmtDetalle = $this->conexion->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ":categoria" => $detalle->getCategoria(),
                ":marca" => $detalle->getMarca(),
                ":descripcion" => $detalle->getDescripcion(),
                ":id_detalle_producto" => $detalle->getIdDetalleProducto()
            ]);

            $sqlProducto = "UPDATE producto
                            SET codigo_producto = :codigo_producto,
                                nombre_producto = :nombre_producto,
                                modelo = :modelo,
                                stock_actual = :stock_actual,
                                stock_minimo = :stock_minimo,
                                precio_referencial = :precio_referencial,
                                descripcion = :descripcion,
                                estado = :estado
                            WHERE id_producto = :id_producto";

            $stmtProducto = $this->conexion->prepare($sqlProducto);
            $stmtProducto->execute([
                ":codigo_producto" => $producto->getCodigoProducto(),
                ":nombre_producto" => $producto->getNombreProducto(),
                ":modelo" => $producto->getModelo(),
                ":stock_actual" => $producto->getStockActual(),
                ":stock_minimo" => $producto->getStockMinimo(),
                ":precio_referencial" => $producto->getPrecioReferencial(),
                ":descripcion" => $producto->getDescripcion(),
                ":estado" => $producto->getEstado(),
                ":id_producto" => $producto->getIdProducto()
            ]);

            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }

    public function eliminar(int $idProducto): bool
    {
        $sqlMovimientos = "SELECT COUNT(*) AS total 
                           FROM movimiento_inventario 
                           WHERE id_producto = :id_producto";

        $stmt = $this->conexion->prepare($sqlMovimientos);
        $stmt->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if ($resultado["total"] > 0) {
            $sql = "UPDATE producto 
                    SET estado = 'Inactivo' 
                    WHERE id_producto = :id_producto";
        } else {
            $sql = "DELETE FROM producto 
                    WHERE id_producto = :id_producto";
        }

        $stmtEliminar = $this->conexion->prepare($sql);
        $stmtEliminar->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);

        return $stmtEliminar->execute();
    }

    public function listarStockBajo(): array
    {
    $sql = "SELECT 
                p.id_producto,
                p.id_detalle_producto,
                p.codigo_producto,
                p.nombre_producto,
                p.modelo,
                p.stock_actual,
                p.stock_minimo,
                p.precio_referencial,
                p.descripcion,
                p.estado,
                d.categoria,
                d.marca,
                d.descripcion AS descripcion_detalle
            FROM producto p
            INNER JOIN detalle_producto d 
                ON p.id_detalle_producto = d.id_detalle_producto
            WHERE p.stock_actual <= p.stock_minimo
            ORDER BY p.stock_actual ASC";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
    }
}