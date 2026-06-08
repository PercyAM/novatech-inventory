<?php
$titulo = "Panel Principal";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Panel Principal</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Panel principal</h1>
        <p class="page-subtitle">
            Resumen general del sistema de gestión de inventario NovaTech.
        </p>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Productos registrados</h3>
                <p class="dashboard-number">0</p>
                <span>Total de productos en el inventario</span>
            </div>

            <div class="dashboard-card">
                <h3>Stock bajo</h3>
                <p class="dashboard-number warning">0</p>
                <span>Productos que requieren reposición</span>
            </div>

            <div class="dashboard-card">
                <h3>Usuarios activos</h3>
                <p class="dashboard-number">1</p>
                <span>Usuarios registrados en el sistema</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Accesos rápidos</h2>
            </div>

            <div class="card-body">
                <div class="quick-actions">
                    <a href="index.php?controller=producto&action=index" class="quick-card">
                        <strong>Gestión de productos</strong>
                        <span>Registrar, editar y consultar productos.</span>
                    </a>

                    <a href="index.php?controller=stock&action=index" class="quick-card">
                        <strong>Consulta de stock</strong>
                        <span>Verificar el stock actual y productos con stock bajo.</span>
                    </href=>

                    <a href="#" class="quick-card">
                        <strong>Salida de productos</strong>
                        <span>Registrar salidas y actualizar el inventario.</span>
                    </a>

                    <?php if ($_SESSION["usuario"]["rol"] === "Administrador") { ?>
                        <a href="#" class="quick-card">
                            <strong>Gestión de usuarios</strong>
                            <span>Administrar usuarios y roles del sistema.</span>
                        </a>
                    <?php } ?>

                    <a href="#" class="quick-card">
                        <strong>Reportes</strong>
                        <span>Consultar reportes del inventario.</span>
                    </a>

                    <a href="#" class="quick-card">
                        <strong>Historial</strong>
                        <span>Revisar movimientos de entrada y salida.</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>