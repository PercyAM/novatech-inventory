<?php
/** @var array $resumen */
/** @var array $inventario */
/** @var array $stockBajo */
/** @var array $movimientos */

$resumen = $resumen ?? [];
$inventario = $inventario ?? [];
$stockBajo = $stockBajo ?? [];
$movimientos = $movimientos ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .reportes-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .reportes-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .reportes-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .reportes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .reporte-resumen-card {
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 20px;
        box-sizing: border-box;
    }

    .reporte-resumen-card h3 {
        margin: 0 0 10px 0;
        color: #374151;
        font-size: 15px;
    }

    .reporte-resumen-card strong {
        font-size: 28px;
        color: #111827;
    }

    .reportes-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .reportes-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .reportes-actions {
        margin-bottom: 20px;
    }

    .reportes-btn {
        display: inline-block;
        padding: 11px 16px;
        background-color: #111827;
        color: #ffffff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    .reportes-btn:hover {
        background-color: #1f2937;
    }

    .reportes-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .reportes-tabla {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .reportes-tabla th,
    .reportes-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .reportes-tabla th {
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

    .badge-activo {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-inactivo {
        background-color: #fee2e2;
        color: #991b1b;
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

    @media (max-width: 900px) {
        .reportes-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .reportes-grid {
            grid-template-columns: 1fr;
        }

        .reportes-tabla {
            min-width: 850px;
        }
    }
</style>

<main class="content reportes-content">
    <h1>Reportes del sistema</h1>
    <p>Consulta el resumen general del inventario, productos registrados, stock bajo y movimientos recientes.</p>

    <section class="reportes-grid">
        <div class="reporte-resumen-card">
            <h3>Productos activos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["productos_activos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>

        <div class="reporte-resumen-card">
            <h3>Productos con stock bajo</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["productos_stock_bajo"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>

        <div class="reporte-resumen-card">
            <h3>Usuarios activos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["usuarios_activos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>

        <div class="reporte-resumen-card">
            <h3>Total movimientos</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_movimientos"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>

        <div class="reporte-resumen-card">
            <h3>Total entradas</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_entradas"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>

        <div class="reporte-resumen-card">
            <h3>Total salidas</h3>
            <strong><?php echo htmlspecialchars((string) ($resumen["total_salidas"] ?? 0), ENT_QUOTES, "UTF-8"); ?></strong>
        </div>
    </section>

    <section class="reportes-card">
        <h2>Reporte de inventario</h2>

        <div class="reportes-actions">
            <a href="index.php?controller=reporte&action=exportarInventario" class="reportes-btn">
                Exportar inventario CSV
            </a>
        </div>

        <div class="reportes-tabla-responsive">
            <table class="reportes-tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($inventario)) { ?>
                        <?php foreach ($inventario as $producto) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["categoria"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["marca"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["modelo"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>
                                <td class="<?php echo ((int) $producto["stock_actual"] <= (int) $producto["stock_minimo"]) ? "stock-alerta" : ""; ?>">
                                    <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                </td>
                                <td><?php echo htmlspecialchars((string) $producto["stock_minimo"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>S/ <?php echo htmlspecialchars((string) $producto["precio_referencial"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                    <?php if ($producto["estado"] === "Activo") { ?>
                                        <span class="badge badge-activo">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge badge-inactivo">Inactivo</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9">No hay productos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="reportes-card">
        <h2>Productos con stock bajo</h2>

        <div class="reportes-tabla-responsive">
            <table class="reportes-tabla">
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
                    <?php if (!empty($stockBajo)) { ?>
                        <?php foreach ($stockBajo as $producto) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["categoria"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["marca"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td class="stock-alerta"><?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?></td>
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

    <section class="reportes-card">
        <h2>Movimientos recientes</h2>

        <div class="reportes-tabla-responsive">
            <table class="reportes-tabla">
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
                    <?php if (!empty($movimientos)) { ?>
                        <?php foreach ($movimientos as $movimiento) { ?>
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
</main>

<?php require_once "views/layouts/footer.php"; ?>