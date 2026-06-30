<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/MovimientoDAO.php";
require_once "app/services/SalidaService.php";

class SalidaController
{
    private SalidaService $salidaService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $movimientoDAO = new MovimientoDAO($conexion);
        $this->salidaService = new SalidaService($movimientoDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $productos = $this->salidaService->listarProductosDisponibles();
        $salidas = $this->salidaService->listarSalidasRecientes();

        require_once "views/salidas/index.php";
    }

    public function registrar(): void
    {
        SessionHelper::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?controller=salida&action=index");
            exit();
        }

        try {
            $idUsuario = (int) $_SESSION["usuario"]["id_usuario"];

            $this->salidaService->registrarSalida($_POST, $idUsuario);

            $_SESSION["mensaje_exito"] = "Salida de producto registrada correctamente.";
        } catch (Exception $e) {
            $_SESSION["mensaje_error"] = $e->getMessage();
        }

        header("Location: index.php?controller=salida&action=index");
        exit();
    }
}