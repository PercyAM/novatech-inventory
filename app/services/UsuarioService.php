<?php

require_once "app/dao/interfaces/IUsuarioDAO.php";

class UsuarioService
{
    private IUsuarioDAO $usuarioDAO;

    public function __construct(IUsuarioDAO $usuarioDAO)
    {
        $this->usuarioDAO = $usuarioDAO;
    }

    public function listarUsuarios(): array
    {
        return $this->usuarioDAO->listarUsuarios();
    }

    public function listarRoles(): array
    {
        return $this->usuarioDAO->listarRoles();
    }

    public function registrarUsuario(array $datos): void
    {
        $idRol = (int) ($datos["id_rol"] ?? 0);
        $nombres = trim($datos["nombres"] ?? "");
        $apellidos = trim($datos["apellidos"] ?? "");
        $nombreUsuario = trim($datos["nombre_usuario"] ?? "");
        $correo = trim($datos["correo"] ?? "");
        $contrasena = trim($datos["contrasena"] ?? "");

        if ($idRol <= 0) {
            throw new Exception("Debe seleccionar un rol.");
        }

        if ($nombres === "") {
            throw new Exception("Debe ingresar los nombres.");
        }

        if ($apellidos === "") {
            throw new Exception("Debe ingresar los apellidos.");
        }

        if ($nombreUsuario === "") {
            throw new Exception("Debe ingresar el nombre de usuario.");
        }

        if ($correo === "") {
            throw new Exception("Debe ingresar el correo.");
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Debe ingresar un correo válido.");
        }

        if ($contrasena === "") {
            throw new Exception("Debe ingresar una contraseña.");
        }

        if (strlen($contrasena) < 6) {
            throw new Exception("La contraseña debe tener como mínimo 6 caracteres.");
        }

        if ($this->usuarioDAO->existeNombreUsuario($nombreUsuario)) {
            throw new Exception("El nombre de usuario ya existe.");
        }

        if ($this->usuarioDAO->existeCorreo($correo)) {
            throw new Exception("El correo ya está registrado.");
        }

        $datosLimpios = [
            "id_rol" => $idRol,
            "nombres" => htmlspecialchars($nombres, ENT_QUOTES, "UTF-8"),
            "apellidos" => htmlspecialchars($apellidos, ENT_QUOTES, "UTF-8"),
            "nombre_usuario" => htmlspecialchars($nombreUsuario, ENT_QUOTES, "UTF-8"),
            "correo" => htmlspecialchars($correo, ENT_QUOTES, "UTF-8"),
            "contrasena" => password_hash($contrasena, PASSWORD_DEFAULT)
        ];

        $this->usuarioDAO->registrarUsuario($datosLimpios);
    }

    public function cambiarEstado(int $idUsuario, string $estadoActual, int $idUsuarioSesion): void
    {
        if ($idUsuario <= 0) {
            throw new Exception("Usuario no válido.");
        }

        if ($idUsuario === $idUsuarioSesion) {
            throw new Exception("No puedes cambiar el estado de tu propio usuario.");
        }

        $nuevoEstado = ($estadoActual === "Activo") ? "Inactivo" : "Activo";

        $this->usuarioDAO->cambiarEstado($idUsuario, $nuevoEstado);
    }
}