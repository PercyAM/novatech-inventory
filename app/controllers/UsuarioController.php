<?php

require_once "app/helpers/SessionHelper.php";

class UsuarioController
{
    public function index(): void
    {
        SessionHelper::verificarSesion();

        if ($_SESSION["usuario"]["rol"] !== "Administrador") {
            header("Location: index.php?controller=dashboard&action=index");
            exit();
        }

        require_once "views/usuarios/index.php";
    }
}