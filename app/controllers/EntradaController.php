<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/MovimientoDAO.php";
require_once "app/services/EntradaService.php";

class EntradaController
{
    private EntradaService $entradaService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $movimientoDAO = new MovimientoDAO($conexion);
        $this->entradaService = new EntradaService($movimientoDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $productos = $this->entradaService->listarProductosDisponibles();
        $entradas = $this->entradaService->listarEntradasRecientes();

        require_once "views/entradas/index.php";
    }

    public function registrar(): void
    {
        SessionHelper::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?controller=entrada&action=index");
            exit();
        }

        try {
            $idUsuario = (int) $_SESSION["usuario"]["id_usuario"];

            $this->entradaService->registrarEntrada($_POST, $idUsuario);

            $_SESSION["mensaje_exito"] = "Entrada de producto registrada correctamente.";
        } catch (Exception $e) {
            $_SESSION["mensaje_error"] = $e->getMessage();
        }

        header("Location: index.php?controller=entrada&action=index");
        exit();
    }
}