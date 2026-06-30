<?php
/** @var array $productos */
/** @var array $ajustes */

$productos = $productos ?? [];
$ajustes = $ajustes ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .ajustes-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .ajustes-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .ajustes-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .ajustes-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .ajustes-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .ajustes-form-group {
        width: 100%;
        margin-bottom: 15px;
    }

    .ajustes-form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #111827;
    }

    .ajustes-form-group input,
    .ajustes-form-group select,
    .ajustes-form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .ajustes-form-group textarea {
        resize: vertical;
        min-height: 90px;
    }

    .ajustes-btn-primary {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: #111827;
        color: #ffffff;
        font-weight: bold;
        cursor: pointer;
    }

    .ajustes-btn-primary:hover {
        background-color: #1f2937;
    }

    .ajustes-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .ajustes-tabla {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .ajustes-tabla th,
    .ajustes-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .ajustes-tabla th {
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
        .ajustes-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .ajustes-tabla {
            min-width: 850px;
        }
    }
</style>

<main class="content ajustes-content">
    <h1>Ajuste de inventario</h1>
    <p>Corrige el stock de los productos cuando existan diferencias entre el stock registrado y el stock físico.</p>

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

    <section class="ajustes-card">
        <h2>Registrar ajuste</h2>

        <form action="index.php?controller=ajuste&action=registrar" method="POST">
            <div class="ajustes-form-group">
                <label for="id_producto">Producto</label>
                <select name="id_producto" id="id_producto" required>
                    <option value="">Seleccione un producto</option>

                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo htmlspecialchars($producto["id_producto"], ENT_QUOTES, "UTF-8"); ?>">
                            <?php
                                echo htmlspecialchars(
                                    $producto["codigo_producto"] . " - " .
                                    $producto["nombre_producto"] . " - Stock actual: " .
                                    $producto["stock_actual"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                );
                            ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="ajustes-form-group">
                <label for="stock_nuevo">Stock físico / nuevo stock</label>
                <input 
                    type="number" 
                    name="stock_nuevo" 
                    id="stock_nuevo"
                    min="0"
                    required
                    placeholder="Ingrese el stock real contado físicamente"
                >
            </div>

            <div class="ajustes-form-group">
                <label for="motivo">Motivo del ajuste</label>
                <input 
                    type="text" 
                    name="motivo" 
                    id="motivo"
                    required
                    placeholder="Ejemplo: Conteo físico, pérdida, sobrante, error de registro"
                >
            </div>

            <div class="ajustes-form-group">
                <label for="observacion">Observación</label>
                <textarea 
                    name="observacion" 
                    id="observacion"
                    placeholder="Ingrese una observación adicional"
                ></textarea>
            </div>

            <button type="submit" class="ajustes-btn-primary">Registrar ajuste</button>
        </form>
    </section>

    <section class="ajustes-card">
        <h2>Últimos ajustes registrados</h2>

        <div class="ajustes-tabla-responsive">
            <table class="ajustes-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo generado</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Usuario</th>
                        <th>Diferencia</th>
                        <th>Motivo</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ajustes)) { ?>
                        <?php foreach ($ajustes as $ajuste) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ajuste["fecha_movimiento"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                    <?php if ($ajuste["tipo_movimiento"] === "Entrada") { ?>
                                        <span class="badge badge-entrada">Entrada</span>
                                    <?php } else { ?>
                                        <span class="badge badge-salida">Salida</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($ajuste["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($ajuste["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($ajuste["nombre_usuario"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($ajuste["cantidad"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($ajuste["motivo"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($ajuste["observacion"], ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8">No hay ajustes registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>