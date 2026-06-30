<?php
/** @var array $productos */
/** @var array $entradas */

$productos = $productos ?? [];
$entradas = $entradas ?? [];
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .entradas-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .entradas-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .entradas-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .entradas-card {
        width: 100%;
        max-width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        overflow: hidden;
        border: 1px solid #d1d5db;
    }

    .entradas-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .entradas-formulario {
        width: 100%;
    }

    .entradas-form-group {
        width: 100%;
        margin-bottom: 15px;
    }

    .entradas-form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #111827;
    }

    .entradas-form-group input,
    .entradas-form-group select,
    .entradas-form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .entradas-form-group textarea {
        resize: vertical;
        min-height: 90px;
    }

    .entradas-btn-primary {
        width: 100%;
        padding: 12px;
        background-color: #111827;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .entradas-btn-primary:hover {
        background-color: #1f2937;
    }

    .entradas-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .entradas-tabla {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .entradas-tabla th,
    .entradas-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .entradas-tabla th {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: bold;
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
        .entradas-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }

        .entradas-tabla {
            min-width: 750px;
        }
    }
</style>

<main class="content entradas-content">
    <h1>Entrada de productos</h1>
    <p>Registra ingresos de productos al inventario y actualiza automáticamente el stock disponible.</p>

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

    <section class="entradas-card">
        <h2>Registrar entrada</h2>

        <form action="index.php?controller=entrada&action=registrar" method="POST" class="entradas-formulario">
            <div class="entradas-form-group">
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

            <div class="entradas-form-group">
                <label for="cantidad">Cantidad</label>
                <input 
                    type="number" 
                    name="cantidad" 
                    id="cantidad" 
                    min="1" 
                    required
                    placeholder="Ingrese la cantidad que ingresará al stock"
                >
            </div>

            <div class="entradas-form-group">
                <label for="motivo">Motivo</label>
                <input 
                    type="text" 
                    name="motivo" 
                    id="motivo" 
                    required
                    placeholder="Ejemplo: Compra, reposición, devolución de cliente"
                >
            </div>

            <div class="entradas-form-group">
                <label for="observacion">Observación</label>
                <textarea 
                    name="observacion" 
                    id="observacion"
                    placeholder="Ingrese una observación adicional"
                ></textarea>
            </div>

            <button type="submit" class="entradas-btn-primary">Registrar entrada</button>
        </form>
    </section>

    <section class="entradas-card">
        <h2>Últimas entradas registradas</h2>

        <div class="entradas-tabla-responsive">
            <table class="entradas-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($entradas)) { ?>
                        <?php foreach ($entradas as $entrada) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($entrada["fecha_movimiento"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["codigo_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["nombre_producto"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["nombre_usuario"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["cantidad"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["motivo"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($entrada["observacion"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7">No hay entradas registradas.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>