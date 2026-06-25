<?php

require_once "app/helpers/SessionHelper.php";
require_once "app/config/Database.php";
require_once "app/dao/UsuarioDAO.php";
require_once "app/services/UsuarioService.php";

class UsuarioController
{
    private UsuarioService $usuarioService;

    public function __construct()
    {
        $database = new Database();
        $conexion = $database->getConnection();

        $usuarioDAO = new UsuarioDAO($conexion);
        $this->usuarioService = new UsuarioService($usuarioDAO);
    }

    public function index(): void
    {
        SessionHelper::verificarSesion();
        $this->verificarAdministrador();

        $usuarios = $this->usuarioService->listarUsuarios();
        $roles = $this->usuarioService->listarRoles();

        require_once "views/usuarios/index.php";
    }

    public function registrar(): void
    {
        SessionHelper::verificarSesion();
        $this->verificarAdministrador();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?controller=usuario&action=index");
            exit();
        }

        try {
            $this->usuarioService->registrarUsuario($_POST);
            $_SESSION["mensaje_exito"] = "Usuario registrado correctamente.";
        } catch (Exception $e) {
            $_SESSION["mensaje_error"] = $e->getMessage();
        }

        header("Location: index.php?controller=usuario&action=index");
        exit();
    }

    public function cambiarEstado(): void
    {
        SessionHelper::verificarSesion();
        $this->verificarAdministrador();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?controller=usuario&action=index");
            exit();
        }

        try {
            $idUsuario = (int) ($_POST["id_usuario"] ?? 0);
            $estadoActual = $_POST["estado_actual"] ?? "";
            $idUsuarioSesion = (int) $_SESSION["usuario"]["id_usuario"];

            $this->usuarioService->cambiarEstado($idUsuario, $estadoActual, $idUsuarioSesion);

            $_SESSION["mensaje_exito"] = "Estado del usuario actualizado correctamente.";
        } catch (Exception $e) {
            $_SESSION["mensaje_error"] = $e->getMessage();
        }

        header("Location: index.php?controller=usuario&action=index");
        exit();
    }

    private function verificarAdministrador(): void
    {
        if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"]["rol"] !== "Administrador") {
            header("Location: index.php?controller=dashboard&action=index");
            exit();
        }
    }
}