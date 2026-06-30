<?php
declare(strict_types=1);

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/ProductoDAO.php";
require_once "app/services/ProductoService.php";
require_once "app/helpers/AppLogger.php";

class ProductoController
{
    private ProductoService $productoService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $productoDAO = new ProductoDAO($conexion);
        $this->productoService = new ProductoService($productoDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $busqueda = trim((string)($_GET["buscar"] ?? ""));
        $productos = $this->productoService->listarProductos($busqueda);

        require_once "views/productos/index.php";
    }

    public function crear(): void
    {
        SessionHelper::verificarSesion();

        require_once "views/productos/crear.php";
    }

    public function guardar(): void
    {
        SessionHelper::verificarSesion();

        $resultado = $this->productoService->registrarProducto($_POST);

        if (!$resultado) {
            AppLogger::getInstance()->warning("Product registration failed", [
                'codigo_producto' => $_POST["codigo_producto"] ?? null,
                'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
            ]);
            header("Location: index.php?controller=producto&action=crear&error=1");
            exit();
        }

        AppLogger::getInstance()->info("Product registered successfully", [
            'codigo_producto' => $_POST["codigo_producto"] ?? null,
            'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
        ]);

        header("Location: index.php?controller=producto&action=index&mensaje=registrado");
        exit();
    }

    public function editar(): void
    {
        SessionHelper::verificarSesion();

        $idProducto = filter_var($_GET["id"] ?? 0, FILTER_VALIDATE_INT);
        if ($idProducto === false || $idProducto <= 0) {
            header("Location: index.php?controller=producto&action=index&error=no_encontrado");
            exit();
        }

        $producto = $this->productoService->obtenerProducto($idProducto);

        if (!$producto) {
            header("Location: index.php?controller=producto&action=index&error=no_encontrado");
            exit();
        }

        require_once "views/productos/editar.php";
    }

    public function actualizar(): void
    {
        SessionHelper::verificarSesion();

        $resultado = $this->productoService->actualizarProducto($_POST);

        if (!$resultado) {
            AppLogger::getInstance()->warning("Product update failed", [
                'id_producto' => $_POST["id_producto"] ?? null,
                'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
            ]);
            header("Location: index.php?controller=producto&action=index&error=actualizar");
            exit();
        }

        AppLogger::getInstance()->info("Product updated successfully", [
            'id_producto' => $_POST["id_producto"] ?? null,
            'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
        ]);

        header("Location: index.php?controller=producto&action=index&mensaje=actualizado");
        exit();
    }

    public function eliminar(): void
    {
        SessionHelper::verificarSesion();

        $idProducto = filter_var($_GET["id"] ?? 0, FILTER_VALIDATE_INT);
        if ($idProducto === false || $idProducto <= 0) {
            header("Location: index.php?controller=producto&action=index&error=eliminar");
            exit();
        }

        $resultado = $this->productoService->eliminarProducto($idProducto);

        if (!$resultado) {
            AppLogger::getInstance()->warning("Product deletion/deactivation failed", [
                'id_producto' => $idProducto,
                'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
            ]);
            header("Location: index.php?controller=producto&action=index&error=eliminar");
            exit();
        }

        AppLogger::getInstance()->info("Product deleted/deactivated successfully", [
            'id_producto' => $idProducto,
            'usuario' => $_SESSION["usuario"]["nombre_usuario"] ?? 'system'
        ]);

        header("Location: index.php?controller=producto&action=index&mensaje=eliminado");
        exit();
    }
}