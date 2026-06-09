<?php
$titulo = "Reportes";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Reportes</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Reportes del inventario</h1>
        <p class="page-subtitle">
            Genere y consulte reportes relacionados con productos, stock y movimientos del inventario.
        </p>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Productos registrados</h3>
                <p class="dashboard-number">0</p>
                <span>Total de productos disponibles en el sistema.</span>
            </div>

            <div class="dashboard-card">
                <h3>Productos con stock bajo</h3>
                <p class="dashboard-number warning">0</p>
                <span>Productos que requieren reposición.</span>
            </div>

            <div class="dashboard-card">
                <h3>Movimientos registrados</h3>
                <p class="dashboard-number">0</p>
                <span>Entradas y salidas registradas.</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Generar reportes</h2>
            </div>

            <div class="card-body">
                <div class="quick-actions">
                    <a href="index.php?controller=report&action=inventario" class="quick-card">
                        <strong>Reporte de inventario</strong>
                        <span>Exportar listado general de productos en formato CSV.</span>
                    </a>

                    <a href="#" class="quick-card">
                        <strong>Reporte de stock bajo</strong>
                        <span>Consultar productos que se encuentran por debajo del stock mínimo.</span>
                    </a>

                    <a href="#" class="quick-card">
                        <strong>Reporte de movimientos</strong>
                        <span>Visualizar entradas y salidas registradas en el sistema.</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Filtros de reporte</h2>
            </div>

            <div class="card-body">
                <form action="#" method="GET">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Tipo de reporte</label>
                            <select name="tipo_reporte" class="form-control">
                                <option value="">Seleccione un tipo</option>
                                <option value="inventario">Inventario general</option>
                                <option value="stock_bajo">Stock bajo</option>
                                <option value="movimientos">Movimientos</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fecha inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Fecha fin</label>
                            <input type="date" name="fecha_fin" class="form-control">
                        </div>
                    </div>

                    <div class="actions">
                        <button type="reset" class="btn btn-light">Limpiar</button>
                        <button type="submit" class="btn btn-dark">Consultar reporte</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>