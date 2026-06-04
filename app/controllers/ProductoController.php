<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/ProductoDAO.php";
require_once "app/services/ProductoService.php";

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

        $busqueda = $_GET["buscar"] ?? "";
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

        if ($resultado) {
            header("Location: index.php?controller=producto&action=index&mensaje=registrado");
            exit();
        }

        header("Location: index.php?controller=producto&action=crear&error=1");
        exit();
    }

    public function editar(): void
    {
        SessionHelper::verificarSesion();

        $idProducto = (int) ($_GET["id"] ?? 0);
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

        if ($resultado) {
            header("Location: index.php?controller=producto&action=index&mensaje=actualizado");
            exit();
        }

        header("Location: index.php?controller=producto&action=index&error=actualizar");
        exit();
    }

    public function eliminar(): void
    {
        SessionHelper::verificarSesion();

        $idProducto = (int) ($_GET["id"] ?? 0);
        $resultado = $this->productoService->eliminarProducto($idProducto);

        if ($resultado) {
            header("Location: index.php?controller=producto&action=index&mensaje=eliminado");
            exit();
        }

        header("Location: index.php?controller=producto&action=index&error=eliminar");
        exit();
    }
}