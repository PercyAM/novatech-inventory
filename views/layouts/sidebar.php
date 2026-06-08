<div class="sidebar">
    <div class="logo">
        <h2>NovaTech</h2>
        <p>Gestión de Inventario</p>
    </div>

    <div class="menu">
        <a href="index.php?controller=dashboard&action=index">Panel principal</a>
        <a href="index.php?controller=producto&action=index">Productos</a>
        <a href="index.php?controller=stock&action=index">Consulta de stock</a>
        <a href="index.php?controller=stock&action=bajo">Stock bajo</a>
        <a href="index.php?controller=salida&action=index">Salida de productos</a>

        <?php if ($_SESSION["usuario"]["rol"] === "Administrador") { ?>
            <a href="index.php?controller=usuario&action=index">Usuarios</a>
        <?php } ?>

        <a href="index.php?controller=reporte&action=index">Reportes</a>
        <a href="index.php?controller=historial&action=index">Historial</a>
    </div>

    <div class="cerrar">
        <a href="index.php?controller=login&action=salir">Cerrar sesión</a>
    </div>
</div>