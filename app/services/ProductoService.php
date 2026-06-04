<?php

require_once "app/models/Producto.php";
require_once "app/models/DetalleProducto.php";
require_once "app/dao/interfaces/IProductoDAO.php";

class ProductoService
{
    private IProductoDAO $productoDAO;

    public function __construct(IProductoDAO $productoDAO)
    {
        $this->productoDAO = $productoDAO;
    }

    public function listarProductos(string $busqueda = ""): array
    {
        return $this->productoDAO->listar($busqueda);
    }

    public function obtenerProducto(int $idProducto): ?array
    {
        return $this->productoDAO->obtenerPorId($idProducto);
    }

    public function registrarProducto(array $datos): bool
    {
        if (!$this->validarDatosProducto($datos)) {
            return false;
        }

        $detalle = new DetalleProducto(
            null,
            trim($datos["categoria"]),
            trim($datos["marca"]),
            trim($datos["descripcion_detalle"])
        );

        $producto = new Producto(
            null,
            null,
            trim($datos["codigo_producto"]),
            trim($datos["nombre_producto"]),
            trim($datos["modelo"]),
            (int) $datos["stock_actual"],
            (int) $datos["stock_minimo"],
            (float) $datos["precio_referencial"],
            trim($datos["descripcion"]),
            $datos["estado"]
        );

        return $this->productoDAO->registrar($producto, $detalle);
    }

    public function actualizarProducto(array $datos): bool
    {
        if (!$this->validarDatosProducto($datos)) {
            return false;
        }

        $detalle = new DetalleProducto(
            (int) $datos["id_detalle_producto"],
            trim($datos["categoria"]),
            trim($datos["marca"]),
            trim($datos["descripcion_detalle"])
        );

        $producto = new Producto(
            (int) $datos["id_producto"],
            (int) $datos["id_detalle_producto"],
            trim($datos["codigo_producto"]),
            trim($datos["nombre_producto"]),
            trim($datos["modelo"]),
            (int) $datos["stock_actual"],
            (int) $datos["stock_minimo"],
            (float) $datos["precio_referencial"],
            trim($datos["descripcion"]),
            $datos["estado"]
        );

        return $this->productoDAO->actualizar($producto, $detalle);
    }

    public function eliminarProducto(int $idProducto): bool
    {
        if ($idProducto <= 0) {
            return false;
        }

        return $this->productoDAO->eliminar($idProducto);
    }

    public function listarProductosConStockBajo(): array
    {
        return $this->productoDAO->listarStockBajo();
    }

    private function validarDatosProducto(array $datos): bool
    {
        if (empty(trim($datos["codigo_producto"] ?? ""))) {
            return false;
        }

        if (empty(trim($datos["nombre_producto"] ?? ""))) {
            return false;
        }

        if (empty(trim($datos["categoria"] ?? ""))) {
            return false;
        }

        if (empty(trim($datos["marca"] ?? ""))) {
            return false;
        }

        if ((int) $datos["stock_actual"] < 0) {
            return false;
        }

        if ((int) $datos["stock_minimo"] < 0) {
            return false;
        }

        if ((float) $datos["precio_referencial"] < 0) {
            return false;
        }

        return true;
    }
}