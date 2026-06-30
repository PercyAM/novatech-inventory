<?php
declare(strict_types=1);

require_once "app/config/Database.php";
require_once "app/helpers/AppLogger.php";

class LoginController
{
    public function index(): void
    {
        require_once "views/auth/login.php";
    }

    public function autenticar(): void
    {
        $nombreUsuario = trim((string) ($_POST["nombre_usuario"] ?? ""));
        $contrasena = (string) ($_POST["contrasena"] ?? "");

        if ($nombreUsuario === "" || $contrasena === "") {
            AppLogger::getInstance()->warning("Login attempt with empty credentials");

            header("Location: index.php?controller=login&action=index&error=1");
            exit();
        }

        $database = new Database();
        $conexion = $database->getConnection();

        $sql = "SELECT 
                    u.*, 
                    r.nombre_rol 
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                WHERE u.nombre_usuario = :nombre_usuario
                LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre_usuario", $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $autenticado = false;
        $necesitaRehash = false;

        if ($usuario && $usuario["estado"] === "Activo") {
            if (password_verify($contrasena, $usuario["contrasena"])) {
                $autenticado = true;

                if (password_needs_rehash($usuario["contrasena"], PASSWORD_DEFAULT)) {
                    $necesitaRehash = true;
                }
            } elseif ($usuario["contrasena"] === $contrasena) {
                /*
                 * Compatibilidad con usuarios antiguos.
                 * Si la contraseña estaba guardada en texto plano,
                 * permite el ingreso y luego la migra automáticamente
                 * a un hash seguro.
                 */
                $autenticado = true;
                $necesitaRehash = true;
            }
        }

        if ($autenticado) {
            if ($necesitaRehash) {
                try {
                    $nuevoHash = password_hash($contrasena, PASSWORD_DEFAULT);

                    $sqlUpdate = "UPDATE usuario 
                                  SET contrasena = :contrasena 
                                  WHERE id_usuario = :id_usuario";

                    $stmtUpdate = $conexion->prepare($sqlUpdate);
                    $stmtUpdate->execute([
                        ":contrasena" => $nuevoHash,
                        ":id_usuario" => $usuario["id_usuario"]
                    ]);

                    AppLogger::getInstance()->info("User password migrated/rehashed successfully", [
                        "id_usuario" => $usuario["id_usuario"]
                    ]);
                } catch (Exception $e) {
                    AppLogger::getInstance()->error("Failed to migrate password hash", [
                        "id_usuario" => $usuario["id_usuario"],
                        "error" => $e->getMessage()
                    ]);
                }
            }

            /*
             * Regenera el ID de sesión para reducir el riesgo
             * de ataques de fijación de sesión.
             */
            session_regenerate_id(true);

            $_SESSION["usuario"] = [
                "id_usuario" => (int) $usuario["id_usuario"],
                "nombres" => $usuario["nombres"],
                "apellidos" => $usuario["apellidos"],
                "nombre_usuario" => $usuario["nombre_usuario"],
                "rol" => $usuario["nombre_rol"]
            ];

            AppLogger::getInstance()->info("User logged in successfully", [
                "id_usuario" => $usuario["id_usuario"],
                "nombre_usuario" => $usuario["nombre_usuario"]
            ]);

            header("Location: index.php?controller=dashboard&action=index");
            exit();
        }

        AppLogger::getInstance()->warning("Failed login attempt", [
            "nombre_usuario" => $nombreUsuario
        ]);

        header("Location: index.php?controller=login&action=index&error=1");
        exit();
    }

    public function salir(): void
    {
        require_once "app/helpers/SessionHelper.php";

        $idUsuario = $_SESSION["usuario"]["id_usuario"] ?? null;

        AppLogger::getInstance()->info("User logging out", [
            "id_usuario" => $idUsuario
        ]);

        SessionHelper::destruirSesion();
    }
}