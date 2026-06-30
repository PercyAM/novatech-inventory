<?php
/** @var array $productos */
/** @var string $busqueda */

$productos = $productos ?? [];
$busqueda = $busqueda ?? "";
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .stock-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .stock-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .stock-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .stock-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .stock-search {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .stock-search input {
        width: 360px;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .stock-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .stock-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .stock-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .stock-tabla {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .stock-tabla th,
    .stock-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .stock-tabla th {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: bold;
    }

    .stock-btn {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .stock-btn-primary {
        background-color: #111827;
        color: #ffffff;
    }

    .stock-btn-primary:hover {
        background-color: #1f2937;
    }

    .stock-btn-light {
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .stock-btn-light:hover {
        background-color: #f8fafc;
    }

    .stock-btn-danger {
        background-color: #dc2626;
        color: #ffffff;
    }

    .stock-btn-danger:hover {
        background-color: #b91c1c;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-ok {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }

    @media (max-width: 768px) {
        .stock-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .stock-toolbar {
            align-items: stretch;
        }

        .stock-search {
            width: 100%;
        }

        .stock-search input,
        .stock-btn {
            width: 100%;
            text-align: center;
        }

        .stock-tabla {
            min-width: 900px;
        }
    }
</style>

<main class="content stock-content">
    <h1>Consulta y control de stock</h1>
    <p>Consulta el stock actual de los productos registrados en el inventario.</p>

    <section class="stock-toolbar">
        <form method="GET" action="index.php" class="stock-search">
            <input type="hidden" name="controller" value="stock">
            <input type="hidden" name="action" value="index">

            <input
                type="text"
                name="buscar"
                placeholder="Buscar por código, producto, categoría o marca"
                value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, "UTF-8"); ?>"
            >

            <button type="submit" class="stock-btn stock-btn-primary">Buscar</button>

            <a href="index.php?controller=stock&action=index" class="stock-btn stock-btn-light">
                Limpiar
            </a>
        </form>

        <a href="index.php?controller=stock&action=bajo" class="stock-btn stock-btn-danger">
            Ver stock bajo
        </a>
    </section>

    <section class="stock-card">
        <h2>Stock de productos</h2>

        <div class="stock-tabla-responsive">
            <table class="stock-tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Estado stock</th>
                        <th>Estado producto</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($productos)) { ?>
                        <?php foreach ($productos as $producto) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["categoria"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["marca"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($producto["modelo"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>

                                <td>
                                    <?php if ((int) $producto["stock_actual"] <= (int) $producto["stock_minimo"]) { ?>
                                        <span class="badge badge-warning">
                                            <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-ok">
                                            <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                        </span>
                                    <?php } ?>
                                </td>

                                <td><?php echo htmlspecialchars((string) $producto["stock_minimo"], ENT_QUOTES, "UTF-8"); ?></td>

                                <td>
                                    <?php if ((int) $producto["stock_actual"] <= (int) $producto["stock_minimo"]) { ?>
                                        <span class="badge badge-warning">Stock bajo</span>
                                    <?php } else { ?>
                                        <span class="badge badge-ok">Stock suficiente</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if ($producto["estado"] === "Activo") { ?>
                                        <span class="badge badge-ok">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9">No se encontraron productos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>