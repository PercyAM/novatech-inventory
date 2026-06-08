<?php
declare(strict_types=1);

require_once "app/models/Producto.php";
require_once "app/models/DetalleProducto.php";
require_once "app/dao/interfaces/IProductoDAO.php";
require_once "app/helpers/AppLogger.php";

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
            AppLogger::getInstance()->warning("Failed product registration: Validation failed", ['input_keys' => array_keys($datos)]);
            return false;
        }

        $detalle = new DetalleProducto(
            null,
            $this->sanitizeString($datos["categoria"]),
            $this->sanitizeString($datos["marca"]),
            $this->sanitizeString($datos["descripcion_detalle"] ?? "")
        );

        $producto = new Producto(
            null,
            null,
            $this->sanitizeString($datos["codigo_producto"]),
            $this->sanitizeString($datos["nombre_producto"]),
            $this->sanitizeString($datos["modelo"] ?? ""),
            (int)$datos["stock_actual"],
            (int)$datos["stock_minimo"],
            (float)$datos["precio_referencial"],
            $this->sanitizeString($datos["descripcion"] ?? ""),
            $this->sanitizeString($datos["estado"] ?? "Activo")
        );

        return $this->productoDAO->registrar($producto, $detalle);
    }

    public function actualizarProducto(array $datos): bool
    {
        if (!$this->validarDatosProducto($datos)) {
            AppLogger::getInstance()->warning("Failed product update: Validation failed", ['id_producto' => $datos["id_producto"] ?? null]);
            return false;
        }

        $idDetalleProducto = filter_var($datos["id_detalle_producto"] ?? null, FILTER_VALIDATE_INT);
        $idProducto = filter_var($datos["id_producto"] ?? null, FILTER_VALIDATE_INT);

        if ($idDetalleProducto === false || $idProducto === false) {
            AppLogger::getInstance()->warning("Failed product update: Invalid IDs", $datos);
            return false;
        }

        $detalle = new DetalleProducto(
            $idDetalleProducto,
            $this->sanitizeString($datos["categoria"]),
            $this->sanitizeString($datos["marca"]),
            $this->sanitizeString($datos["descripcion_detalle"] ?? "")
        );

        $producto = new Producto(
            $idProducto,
            $idDetalleProducto,
            $this->sanitizeString($datos["codigo_producto"]),
            $this->sanitizeString($datos["nombre_producto"]),
            $this->sanitizeString($datos["modelo"] ?? ""),
            (int)$datos["stock_actual"],
            (int)$datos["stock_minimo"],
            (float)$datos["precio_referencial"],
            $this->sanitizeString($datos["descripcion"] ?? ""),
            $this->sanitizeString($datos["estado"] ?? "Activo")
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

    private function sanitizeString(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        $str = is_scalar($value) ? (string)$value : '';
        return trim(strip_tags($str));
    }

    private function validarDatosProducto(array $datos): bool
    {
        // Guard clauses checking required non-empty string fields
        if (empty($this->sanitizeString($datos["codigo_producto"] ?? ""))) {
            return false;
        }

        if (empty($this->sanitizeString($datos["nombre_producto"] ?? ""))) {
            return false;
        }

        if (empty($this->sanitizeString($datos["categoria"] ?? ""))) {
            return false;
        }

        if (empty($this->sanitizeString($datos["marca"] ?? ""))) {
            return false;
        }

        // Numeric checks
        $stockActual = filter_var($datos["stock_actual"] ?? null, FILTER_VALIDATE_INT);
        if ($stockActual === false || $stockActual < 0) {
            return false;
        }

        $stockMinimo = filter_var($datos["stock_minimo"] ?? null, FILTER_VALIDATE_INT);
        if ($stockMinimo === false || $stockMinimo < 0) {
            return false;
        }

        $precioReferencial = filter_var($datos["precio_referencial"] ?? null, FILTER_VALIDATE_FLOAT);
        if ($precioReferencial === false || $precioReferencial < 0) {
            return false;
        }

        return true;
    }
}