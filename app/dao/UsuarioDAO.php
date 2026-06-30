<?php

require_once "app/dao/interfaces/IUsuarioDAO.php";

class UsuarioDAO implements IUsuarioDAO
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function listarUsuarios(): array
    {
        $sql = "SELECT 
                    u.id_usuario,
                    u.nombres,
                    u.apellidos,
                    u.nombre_usuario,
                    u.correo,
                    u.estado,
                    u.fecha_registro,
                    r.nombre_rol
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                ORDER BY u.fecha_registro DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarRoles(): array
    {
        $sql = "SELECT id_rol, nombre_rol 
                FROM rol 
                ORDER BY nombre_rol ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarUsuario(array $datos): bool
    {
        $sql = "INSERT INTO usuario
                (id_rol, nombres, apellidos, nombre_usuario, contrasena, correo, estado)
                VALUES
                (:id_rol, :nombres, :apellidos, :nombre_usuario, :contrasena, :correo, 'Activo')";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindValue(":id_rol", $datos["id_rol"], PDO::PARAM_INT);
        $stmt->bindValue(":nombres", $datos["nombres"]);
        $stmt->bindValue(":apellidos", $datos["apellidos"]);
        $stmt->bindValue(":nombre_usuario", $datos["nombre_usuario"]);
        $stmt->bindValue(":contrasena", $datos["contrasena"]);
        $stmt->bindValue(":correo", $datos["correo"]);

        return $stmt->execute();
    }

    public function existeNombreUsuario(string $nombreUsuario): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM usuario 
                WHERE nombre_usuario = :nombre_usuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":nombre_usuario", $nombreUsuario);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function existeCorreo(string $correo): bool
    {
        $sql = "SELECT COUNT(*) 
                FROM usuario 
                WHERE correo = :correo";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":correo", $correo);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function cambiarEstado(int $idUsuario, string $estado): bool
    {
        $sql = "UPDATE usuario
                SET estado = :estado
                WHERE id_usuario = :id_usuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(":estado", $estado);
        $stmt->bindValue(":id_usuario", $idUsuario, PDO::PARAM_INT);

        return $stmt->execute();
    }
}