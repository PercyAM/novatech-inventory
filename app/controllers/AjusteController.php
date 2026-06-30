<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/MovimientoDAO.php";
require_once "app/services/AjusteService.php";

class AjusteController
{
    private AjusteService $ajusteService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $movimientoDAO = new MovimientoDAO($conexion);
        $this->ajusteService = new AjusteService($movimientoDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();

        $productos = $this->ajusteService->listarProductosDisponibles();
        $ajustes = $this->ajusteService->listarAjustesRecientes();

        require_once "views/ajustes/index.php";
    }

    public function registrar(): void
    {
        SessionHelper::verificarSesion();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?controller=ajuste&action=index");
            exit();
        }

        try {
            $idUsuario = (int) $_SESSION["usuario"]["id_usuario"];

            $this->ajusteService->registrarAjuste($_POST, $idUsuario);

            $_SESSION["mensaje_exito"] = "Ajuste de inventario registrado correctamente.";
        } catch (Exception $e) {
            $_SESSION["mensaje_error"] = $e->getMessage();
        }

        header("Location: index.php?controller=ajuste&action=index");
        exit();
    }
}