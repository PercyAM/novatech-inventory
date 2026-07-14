<?php
/** @var array $productos */
/** @var string $busqueda */

$productos = $productos ?? [];
$busqueda = $busqueda ?? "";
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .productos-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .productos-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .productos-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .productos-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .productos-search {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .productos-search input {
        width: 360px;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .productos-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .productos-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .productos-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .productos-tabla {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .productos-tabla th,
    .productos-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .productos-tabla th {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: bold;
    }

    .productos-btn {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .productos-btn-primary {
        background-color: #111827;
        color: #ffffff;
    }

    .productos-btn-primary:hover {
        background-color: #1f2937;
    }

    .productos-btn-light {
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .productos-btn-light:hover {
        background-color: #f8fafc;
    }

    .productos-btn-danger {
        background-color: #dc2626;
        color: #ffffff;
    }

    .productos-btn-danger:hover {
        background-color: #b91c1c;
    }

    .productos-actions {
        display: flex;
        gap: 8px;
        align-items: center;
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

    .badge-stock-ok {
        background-color: #dcfce7;
        color: #166534;
    }

    .badge-stock-bajo {
        background-color: #fef3c7;
        color: #92400e;
    }

    .alert {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 18px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    @media (max-width: 768px) {
        .productos-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .productos-toolbar {
            align-items: stretch;
        }

        .productos-search {
            width: 100%;
        }

        .productos-search input,
        .productos-btn {
            width: 100%;
            text-align: center;
        }

        .productos-tabla {
            min-width: 950px;
        }
    }
</style>

<main class="content productos-content">
    <h1>Gestión de productos</h1>
    <p>Registra, consulta, edita y administra los productos del inventario.</p>

    <?php if (isset($_SESSION["mensaje_exito"])) { ?>
        <div class="alert alert-success">
            <?php 
                echo htmlspecialchars($_SESSION["mensaje_exito"], ENT_QUOTES, "UTF-8"); 
                unset($_SESSION["mensaje_exito"]);
            ?>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION["mensaje_error"])) { ?>
        <div class="alert alert-error">
            <?php 
                echo htmlspecialchars($_SESSION["mensaje_error"], ENT_QUOTES, "UTF-8"); 
                unset($_SESSION["mensaje_error"]);
            ?>
        </div>
    <?php } ?>

    <?php if (isset($_GET["mensaje"])) { ?>
        <div class="alert alert-success">
            Operación realizada correctamente.
        </div>
    <?php } ?>

    <?php if (isset($_GET["error"])) { ?>
        <div class="alert alert-error">
            Ocurrió un error al realizar la operación.
        </div>
    <?php } ?>

    <section class="productos-toolbar">
        <form method="GET" action="index.php" class="productos-search">
            <input type="hidden" name="controller" value="producto">
            <input type="hidden" name="action" value="index">

            <input
                type="text"
                name="buscar"
                placeholder="Buscar por código, producto, categoría o marca"
                value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, "UTF-8"); ?>"
            >

            <button type="submit" class="productos-btn productos-btn-primary">Buscar</button>

            <a href="index.php?controller=producto&action=index" class="productos-btn productos-btn-light">
                Limpiar
            </a>
        </form>

        <a href="index.php?controller=producto&action=crear" class="productos-btn productos-btn-primary">
            Nuevo producto
        </a>
    </section>

    <section class="productos-card">
        <h2>Lista de productos</h2>

        <div class="productos-tabla-responsive">
            <table class="productos-tabla">
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
                        <th>Acciones</th>
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
                                        <span class="badge badge-stock-bajo">
                                            <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-stock-ok">
                                            <?php echo htmlspecialchars((string) $producto["stock_actual"], ENT_QUOTES, "UTF-8"); ?>
                                        </span>
                                    <?php } ?>
                                </td>

                                <td><?php echo htmlspecialchars((string) $producto["stock_minimo"], ENT_QUOTES, "UTF-8"); ?></td>

                                <td>
                                    <?php if ($producto["estado"] === "Activo") { ?>
                                        <span class="badge badge-activo">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge badge-inactivo">Inactivo</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <div class="productos-actions">
                                        <a 
                                            href="index.php?controller=producto&action=editar&id=<?php echo htmlspecialchars((string) $producto["id_producto"], ENT_QUOTES, "UTF-8"); ?>" 
                                            class="productos-btn productos-btn-light"
                                        >
                                            Editar
                                        </a>

                                        <a 
                                            href="index.php?controller=producto&action=eliminar&id=<?php echo htmlspecialchars((string) $producto["id_producto"], ENT_QUOTES, "UTF-8"); ?>" 
                                            class="productos-btn productos-btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar este producto?');"
                                        >
                                            Eliminar
                                        </a>
                                    </div>
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
</main>

<?php require_once "views/layouts/footer.php"; ?>