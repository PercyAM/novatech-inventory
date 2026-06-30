<?php
$controllerActual = $_GET["controller"] ?? "";
$actionActual = $_GET["action"] ?? "";

function menuActivo(string $controller, ?string $action = null): string
{
    $controllerActual = $_GET["controller"] ?? "";
    $actionActual = $_GET["action"] ?? "";

    if ($action !== null) {
        return ($controllerActual === $controller && $actionActual === $action) ? "active" : "";
    }

    return ($controllerActual === $controller) ? "active" : "";
}
?>

<div class="sidebar">
    <div class="logo">
        <h2>NovaTech</h2>
        <p>Gestión de Inventario</p>
    </div>

    <div class="menu">
        <a href="index.php?controller=dashboard&action=index" class="<?php echo menuActivo("dashboard"); ?>">
            <span class="sidebar-icon">📊</span>
            <span>Panel principal</span>
        </a>

        <a href="index.php?controller=producto&action=index" class="<?php echo menuActivo("producto"); ?>">
            <span class="sidebar-icon">📦</span>
            <span>Productos</span>
        </a>

        <a href="index.php?controller=stock&action=index" class="<?php echo menuActivo("stock", "index"); ?>">
            <span class="sidebar-icon">🔍</span>
            <span>Consulta de stock</span>
        </a>

        <a href="index.php?controller=stock&action=bajo" class="<?php echo menuActivo("stock", "bajo"); ?>">
            <span class="sidebar-icon">⚠️</span>
            <span>Stock bajo</span>
        </a>

        <a href="index.php?controller=ajuste&action=index" class="<?php echo menuActivo("ajuste"); ?>">
            <span class="sidebar-icon">🛠️</span>
            <span>Ajuste de inventario</span>
        </a>

        <a href="index.php?controller=entrada&action=index" class="<?php echo menuActivo("entrada"); ?>">
            <span class="sidebar-icon">⬆️</span>
            <span>Entrada de productos</span>
        </a>

        <a href="index.php?controller=salida&action=index" class="<?php echo menuActivo("salida"); ?>">
            <span class="sidebar-icon">⬇️</span>
            <span>Salida de productos</span>
        </a>

        <?php if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]["rol"] === "Administrador") { ?>
            <a href="index.php?controller=usuario&action=index" class="<?php echo menuActivo("usuario"); ?>">
                <span class="sidebar-icon">👤</span>
                <span>Usuarios</span>
            </a>
        <?php } ?>

        <a href="index.php?controller=reporte&action=index" class="<?php echo menuActivo("reporte"); ?>">
            <span class="sidebar-icon">📄</span>
            <span>Reportes</span>
        </a>

        <a href="index.php?controller=historial&action=index" class="<?php echo menuActivo("historial"); ?>">
            <span class="sidebar-icon">🕒</span>
            <span>Historial</span>
        </a>
    </div>

    <div class="cerrar">
        <a href="index.php?controller=login&action=salir">
            <span class="sidebar-icon">🚪</span>
            <span>Cerrar sesión</span>
        </a>
    </div>
</div>