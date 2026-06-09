<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/ProductoDAO.php";
require_once "app/services/ProductoService.php";

class StockController
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

        require_once "views/stock/index.php";
    }

    public function bajo(): void
    {
        SessionHelper::verificarSesion();

        $productos = $this->productoService->listarProductosConStockBajo();

        require_once "views/stock/bajo.php";
    }
}