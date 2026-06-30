<?php
/** @var array $usuarios */
/** @var array $roles */

$usuarios = $usuarios ?? [];
$roles = $roles ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .usuarios-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .usuarios-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .usuarios-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .usuarios-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .usuarios-card h2 {
        margin-top: 0;
        margin-bottom: 18px;
        color: #111827;
    }

    .usuarios-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .usuarios-form-group {
        width: 100%;
    }

    .usuarios-form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #111827;
    }

    .usuarios-form-group input,
    .usuarios-form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .usuarios-form-actions {
        margin-top: 18px;
    }

    .usuarios-btn-primary {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: #111827;
        color: #ffffff;
        font-weight: bold;
        cursor: pointer;
    }

    .usuarios-btn-primary:hover {
        background-color: #1f2937;
    }

    .usuarios-btn-estado {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-inactivar {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-activar {
        background-color: #dcfce7;
        color: #166534;
    }

    .usuarios-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .usuarios-tabla {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .usuarios-tabla th,
    .usuarios-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .usuarios-tabla th {
        background-color: #f3f4f6;
        color: #111827;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-activo {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-inactivo {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .alert {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 18px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    @media (max-width: 900px) {
        .usuarios-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .usuarios-form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="content usuarios-content">
    <h1>Gestión de usuarios</h1>
    <p>Administra los usuarios del sistema, asigna roles y controla su estado de acceso.</p>

    <?php if (isset($_SESSION["mensaje_exito"])) { ?>
        <div class="alert alert-success">
            <?php 
                echo htmlspecialchars($_SESSION["mensaje_exito"], ENT_QUOTES, "UTF-8"); 
                unset($_SESSION["mensaje_exito"]);
            ?>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION["mensaje_error"])) { ?>
        <div class="alert alert-error">
            <?php 
                echo htmlspecialchars($_SESSION["mensaje_error"], ENT_QUOTES, "UTF-8"); 
                unset($_SESSION["mensaje_error"]);
            ?>
        </div>
    <?php } ?>

    <section class="usuarios-card">
        <h2>Registrar nuevo usuario</h2>

        <form action="index.php?controller=usuario&action=registrar" method="POST">
            <div class="usuarios-form-grid">
                <div class="usuarios-form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombres" id="nombres" required>
                </div>

                <div class="usuarios-form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" required>
                </div>

                <div class="usuarios-form-group">
                    <label for="nombre_usuario">Nombre de usuario</label>
                    <input type="text" name="nombre_usuario" id="nombre_usuario" required>
                </div>

                <div class="usuarios-form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" id="correo" required>
                </div>

                <div class="usuarios-form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" minlength="6" required>
                </div>

                <div class="usuarios-form-group">
                    <label for="id_rol">Rol</label>
                    <select name="id_rol" id="id_rol" required>
                        <option value="">Seleccione un rol</option>

                        <?php foreach ($roles as $rol) { ?>
                            <option value="<?php echo htmlspecialchars($rol["id_rol"], ENT_QUOTES, "UTF-8"); ?>">
                                <?php echo htmlspecialchars($rol["nombre_rol"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="usuarios-form-actions">
                <button type="submit" class="usuarios-btn-primary">Registrar usuario</button>
            </div>
        </form>
    </section>

    <section class="usuarios-card">
        <h2>Usuarios registrados</h2>

        <div class="usuarios-tabla-responsive">
            <table class="usuarios-tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha registro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)) { ?>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario["id_usuario"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($usuario["nombres"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($usuario["apellidos"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($usuario["nombre_usuario"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($usuario["correo"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($usuario["nombre_rol"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                    <?php if ($usuario["estado"] === "Activo") { ?>
                                        <span class="badge badge-activo">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge badge-inactivo">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($usuario["fecha_registro"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                    <?php if ((int) $usuario["id_usuario"] !== (int) $_SESSION["usuario"]["id_usuario"]) { ?>
                                        <form action="index.php?controller=usuario&action=cambiarEstado" method="POST">
                                            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario["id_usuario"], ENT_QUOTES, "UTF-8"); ?>">
                                            <input type="hidden" name="estado_actual" value="<?php echo htmlspecialchars($usuario["estado"], ENT_QUOTES, "UTF-8"); ?>">

                                            <?php if ($usuario["estado"] === "Activo") { ?>
                                                <button type="submit" class="usuarios-btn-estado btn-inactivar">Inactivar</button>
                                            <?php } else { ?>
                                                <button type="submit" class="usuarios-btn-estado btn-activar">Activar</button>
                                            <?php } ?>
                                        </form>
                                    <?php } else { ?>
                                        Usuario actual
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9">No hay usuarios registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>