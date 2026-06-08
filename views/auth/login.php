<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión - NovaTech Inventory</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-card">
            <h1>NovaTech</h1>
            <p class="login-subtitle">Sistema de Gestión de Inventario</p>

            <?php if (isset($_GET["error"])) { ?>
                <div class="alert-error">
                    Usuario o contraseña incorrectos.
                </div>
            <?php } ?>

            <form action="index.php?controller=login&action=autenticar" method="POST">
                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" name="nombre_usuario" required>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" required>
                </div>

                <button type="submit" class="btn-primary">Iniciar sesión</button>
            </form>
        </div>
    </div>

</body>
</html>