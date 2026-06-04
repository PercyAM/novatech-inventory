<?php

require_once "app/config/Database.php";

class LoginController
{
    public function index(): void
    {
        require_once "views/auth/login.php";
    }

    public function autenticar(): void
    {
        $nombreUsuario = $_POST["nombre_usuario"] ?? "";
        $contrasena = $_POST["contrasena"] ?? "";

        $database = new Database();
        $conexion = $database->getConnection();

        $sql = "SELECT u.*, r.nombre_rol 
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                WHERE u.nombre_usuario = :nombre_usuario
                LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre_usuario", $nombreUsuario);
        $stmt->execute();

        $usuario = $stmt->fetch();

        if ($usuario && $usuario["contrasena"] === $contrasena && $usuario["estado"] === "Activo") {
            $_SESSION["usuario"] = [
                "id_usuario" => $usuario["id_usuario"],
                "nombres" => $usuario["nombres"],
                "apellidos" => $usuario["apellidos"],
                "nombre_usuario" => $usuario["nombre_usuario"],
                "rol" => $usuario["nombre_rol"]
            ];

            header("Location: index.php?controller=dashboard&action=index");
            exit();
        }

        header("Location: index.php?controller=login&action=index&error=1");
        exit();
    }

    public function salir(): void
    {
        require_once "app/helpers/SessionHelper.php";
        SessionHelper::destruirSesion();
    }
}