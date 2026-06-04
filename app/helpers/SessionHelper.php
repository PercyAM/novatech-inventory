<?php

class SessionHelper
{
    public static function verificarSesion(): void
    {
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?controller=login&action=index");
            exit();
        }
    }

    public static function destruirSesion(): void
    {
        session_destroy();
        header("Location: index.php?controller=login&action=index");
        exit();
    }
}