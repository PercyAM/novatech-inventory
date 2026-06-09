<?php
$titulo = "Gestión de Usuarios";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Gestión de Usuarios</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Gestión de usuarios</h1>
        <p class="page-subtitle">
            Administre los usuarios que tendrán acceso al sistema de inventario.
        </p>

        <div class="card">
            <div class="card-header">
                <h2>Registrar nuevo usuario</h2>
            </div>

            <div class="card-body">
                <form action="#" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" name="nombres" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input type="text" name="nombre_usuario" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico</label>
                            <input type="email" name="correo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="contrasena" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Rol</label>
                            <select name="id_rol" class="form-control" required>
                                <option value="">Seleccione un rol</option>
                                <option value="1">Administrador</option>
                                <option value="2">Encargado de almacén</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="reset" class="btn btn-light">Limpiar</button>
                        <button type="submit" class="btn btn-dark">Guardar usuario</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="toolbar">
            <form method="GET" action="#">
                <input 
                    type="text" 
                    name="buscar" 
                    class="search-input" 
                    placeholder="Buscar por nombre, usuario o correo"
                >

                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="#" class="btn btn-light">Limpiar</a>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Lista de usuarios</h2>
            </div>

            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Administrador</td>
                            <td>Principal</td>
                            <td>admin</td>
                            <td>admin@novatech.com</td>
                            <td>Administrador</td>
                            <td><span class="badge badge-success">Activo</span></td>
                            <td>
                                <a href="#" class="btn btn-light">Editar</a>
                                <a href="#" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>