<?php
/** @var array $resumen */
/** @var array $ultimosMovimientos */
/** @var array $productosStockBajo */

$resumen = $resumen ?? [];
$ultimosMovimientos = $ultimosMovimientos ?? [];
$productosStockBajo = $productosStockBajo ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .dashboard-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .dashboard-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .dashboard-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #d1d5db;
        box-sizing: border-box;
    }

    .dashboard-card h3 {
        margin: 0 0 10px 0;
        color: #374151;
        font-size: 15px;
    }

    .dashboard-card strong {
        font-size: 30px;
        color: #111827;
    }

    .dashboard-card span {
        display: block;
        margin-top: 8px;
        font-size: 13px;
        color: #6b7280;
    }

    .dashboard-section {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #d1d5db;
        box-sizing: border-box;
        overflow: hidden;
    }

    .dashboard-section h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .dashboard-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .dashboard-table th,
    .dashboard-table td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .dashboard-table th {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: bold;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-entrada {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-salida {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .stock-alerta {
        color: #991b1b;
        font-weight: bold;
    }

    .dashboard-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .dashboard-btn {
        display: inline-block;
        padding: 11px 16px;
        background-color: #111827;
        color: #ffffff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
    }

    .dashboard-btn:hover {
        background-color: #1f2937;
    }

    @media (max-width: 900px) {
        .dashboard-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-table {
            min-width: 780px;
        }
    }
</style>

<main class="content dashboard-content">
    <h1>Panel principal</h1>

    <p>
        Bienvenido, 
        <strong>
            <?php echo htmlspecialchars($_SESSION["usuario"]["nombres"] ?? "Usuario", ENT_QUOTES, "UTF-8"); ?>
        </strong>. 
        Aquí puedes visualizar el resumen general del sistema de inventario.
    </p>

    <section class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Productos activos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["productos_activos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Total de productos disponibles en el sistema</span>
        </div>

        <div class="dashboard-card">
            <h3>Stock bajo</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["stock_bajo"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Productos que requieren reposición</span>
        </div>

        <div class="dashboard-card">
            <h3>Usuarios activos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["usuarios_activos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Usuarios habilitados en el sistema</span>
        </div>

        <div class="dashboard-card">
            <h3>Total movimientos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_movimientos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Entradas, salidas y ajustes registrados</span>
        </div>

        <div class="dashboard-card">
            <h3>Entradas registradas</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_entradas"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Movimientos que aumentaron el stock</span>
        </div>

        <div class="dashboard-card">
            <h3>Salidas registradas</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_salidas"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
            <span>Movimientos que redujeron el stock</span>
        </div>
    </section>

    <section class="dashboard-actions">
        <a href="index.php?controller=producto&action=index" class="dashboard-btn">Gestionar productos</a>
        <a href="index.php?controller=entrada&action=index" class="dashboard-btn">Registrar entrada</a>
        <a href="index.php?controller=salida&action=index" class="dashboard-btn">Registrar salida</a>
        <a href="index.php?controller=historial&action=index" class="dashboard-btn">Ver historial</a>
        <a href="index.php?controller=reporte&action=index" class="dashboard-btn">Ver reportes</a>
    </section>

    <section class="dashboard-section">
        <h2>Últimos movimientos registrados</h2>

        <div class="dashboard-table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ultimosMovimientos)) { ?>
                        <?php foreach ($ultimosMovimientos as $movimiento) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($movimiento["fecha_movimiento"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                    <?php if ($movimiento["tipo_movimiento"] === "Entrada") { ?>
                                        <span class="badge badge-entrada">Entrada</span>
                                    <?php } else { ?>
                                        <span class="badge badge-salida">Salida</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($movimiento["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($movimiento["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($movimiento["nombre_usuario"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars((string) $movimiento["cantidad"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($movimiento["motivo"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7">No hay movimientos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="dashboard-section">
        <h2>Productos con stock bajo</h2>

        <div class="dashboard-table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productosStockBajo)) { ?>
                        <?php foreach ($productosStockBajo as $producto) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["categoria"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["marca"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td class="stock-alerta">
                                    <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                </td>
                                <td><?php echo htmlspecialchars((string) $producto["stock_minimo"], ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6">No hay productos con stock bajo.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>