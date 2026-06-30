<?php
/** @var array $productos */

$productos = $productos ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .stock-bajo-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .stock-bajo-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .stock-bajo-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .stock-bajo-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .stock-bajo-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .stock-bajo-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .stock-bajo-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .stock-bajo-tabla {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .stock-bajo-tabla th,
    .stock-bajo-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .stock-bajo-tabla th {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: bold;
    }

    .stock-bajo-btn {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .stock-bajo-btn-primary {
        background-color: #111827;
        color: #ffffff;
    }

    .stock-bajo-btn-primary:hover {
        background-color: #1f2937;
    }

    .stock-bajo-btn-light {
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .stock-bajo-btn-light:hover {
        background-color: #f8fafc;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    @media (max-width: 768px) {
        .stock-bajo-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .stock-bajo-toolbar {
            align-items: stretch;
        }

        .stock-bajo-btn {
            width: 100%;
            text-align: center;
        }

        .stock-bajo-tabla {
            min-width: 800px;
        }
    }
</style>

<main class="content stock-bajo-content">
    <h1>Productos con stock bajo</h1>
    <p>Lista de productos cuyo stock actual es menor o igual al stock mínimo establecido.</p>

    <section class="stock-bajo-toolbar">
        <a href="index.php?controller=stock&action=index" class="stock-bajo-btn stock-bajo-btn-light">
            Volver a consulta de stock
        </a>

        <a href="index.php?controller=entrada&action=index" class="stock-bajo-btn stock-bajo-btn-primary">
            Registrar entrada
        </a>
    </section>

    <section class="stock-bajo-card">
        <h2>Alertas de stock bajo</h2>

        <div class="stock-bajo-tabla-responsive">
            <table class="stock-bajo-tabla">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Estado</th>
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
                                    <span class="badge badge-warning">
                                        <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                    </span>
                                </td>

                                <td><?php echo htmlspecialchars((string) $producto["stock_minimo"], ENT_QUOTES, "UTF-8"); ?></td>

                                <td>
                                    <span class="badge badge-warning">
                                        Requiere reposición
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8">No hay productos con stock bajo.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>