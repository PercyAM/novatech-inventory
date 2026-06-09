<?php
$titulo = "Salida de Productos";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Salida de Productos</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Salida de productos</h1>
        <p class="page-subtitle">
            Registre la salida de productos del inventario y actualice el stock disponible.
        </p>

        <div class="card">
            <div class="card-header">
                <h2>Registrar salida</h2>
            </div>

            <div class="card-body">
                <form action="#" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Producto</label>
                            <select name="id_producto" class="form-control" required>
                                <option value="">Seleccione un producto</option>
                                <option value="1">Laptop HP 15 - Stock: 10</option>
                                <option value="2">Mouse Logitech - Stock: 25</option>
                                <option value="3">Monitor LG 24" - Stock: 8</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Cantidad a retirar</label>
                            <input type="number" name="cantidad" class="form-control" min="1" required>
                        </div>

                        <div class="form-group">
                            <label>Motivo de salida</label>
                            <select name="motivo" class="form-control" required>
                                <option value="">Seleccione un motivo</option>
                                <option value="Venta">Venta</option>
                                <option value="Uso interno">Uso interno</option>
                                <option value="Producto dañado">Producto dañado</option>
                                <option value="Traslado">Traslado</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Responsable</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                value="<?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>" 
                                readonly
                            >
                        </div>

                        <div class="form-group">
                            <label>Fecha de salida</label>
                            <input type="date" name="fecha_salida" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label>Observación</label>
                            <textarea name="observacion" class="form-control" placeholder="Ingrese una observación opcional"></textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="reset" class="btn btn-light">Limpiar</button>
                        <button type="submit" class="btn btn-dark">Registrar salida</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Últimas salidas registradas</h2>
            </div>

            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Motivo</th>
                            <th>Responsable</th>
                            <th>Observación</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="6">Aún no hay salidas registradas.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>