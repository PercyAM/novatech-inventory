<?php
/** @var array $productos */
/** @var array $movimientos */

$productos = $productos ?? [];
$movimientos = $movimientos ?? [];

$idProductoSeleccionado = $_GET["id_producto"] ?? "";
$tipoSeleccionado = $_GET["tipo_movimiento"] ?? "";
$fechaInicio = $_GET["fecha_inicio"] ?? "";
$fechaFin = $_GET["fecha_fin"] ?? "";
?>

<?php require_once "views/layouts/header.php"; ?>
<?php require_once "views/layouts/sidebar.php"; ?>

<style>
    .historial-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        max-width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 30px;
        box-sizing: border-box;
        overflow-x: hidden;
        background-color: #f4f6f9;
    }

    .historial-content h1 {
        margin-top: 0;
        color: #111827;
    }

    .historial-content p {
        color: #374151;
        margin-bottom: 20px;
    }

    .historial-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        overflow: hidden;
    }

    .historial-card h2 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 18px;
    }

    .historial-filtros {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        align-items: end;
    }

    .historial-form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #111827;
    }

    .historial-form-group input,
    .historial-form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    .historial-btn {
        width: 100%;
        padding: 11px;
        border: none;
        border-radius: 6px;
        background-color: #111827;
        color: #ffffff;
        font-weight: bold;
        cursor: pointer;
    }

    .historial-btn:hover {
        background-color: #1f2937;
    }

    .historial-btn-secundario {
        display: block;
        text-align: center;
        text-decoration: none;
        width: 100%;
        padding: 11px;
        border-radius: 6px;
        background-color: #e5e7eb;
        color: #111827;
        font-weight: bold;
        box-sizing: border-box;
    }

    .historial-tabla-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .historial-tabla {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        background-color: #ffffff;
    }

    .historial-tabla th,
    .historial-tabla td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        white-space: nowrap;
        font-size: 14px;
    }

    .historial-tabla th {
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

    @media (max-width: 900px) {
        .historial-filtros {
            grid-template-columns: 1fr;
        }

        .historial-content {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 20px;
        }
    }
</style>

<main class="content historial-content">
    <h1>Historial de movimientos</h1>
    <p>Consulta los movimientos registrados en el inventario, como entradas y salidas de productos.</p>

    <section class="historial-card">
        <h2>Filtros de búsqueda</h2>

        <form action="index.php" method="GET" class="historial-filtros">
            <input type="hidden" name="controller" value="historial">
            <input type="hidden" name="action" value="index">

            <div class="historial-form-group">
                <label for="id_producto">Producto</label>
                <select name="id_producto" id="id_producto">
                    <option value="">Todos</option>

                    <?php foreach ($productos as $producto) { ?>
                        <option 
                            value="<?php echo htmlspecialchars($producto["id_producto"], ENT_QUOTES, "UTF-8"); ?>"
                            <?php echo ($idProductoSeleccionado == $producto["id_producto"]) ? "selected" : ""; ?>
                        >
                            <?php 
                                echo htmlspecialchars(
                                    $producto["codigo_producto"] . " - " . $producto["nombre_producto"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); 
                            ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="historial-form-group">
                <label for="tipo_movimiento">Tipo</label>
                <select name="tipo_movimiento" id="tipo_movimiento">
                    <option value="">Todos</option>
                    <option value="Entrada" <?php echo ($tipoSeleccionado === "Entrada") ? "selected" : ""; ?>>
                        Entrada
                    </option>
                    <option value="Salida" <?php echo ($tipoSeleccionado === "Salida") ? "selected" : ""; ?>>
                        Salida
                    </option>
                </select>
            </div>

            <div class="historial-form-group">
                <label for="fecha_inicio">Desde</label>
                <input 
                    type="date" 
                    name="fecha_inicio" 
                    id="fecha_inicio"
                    value="<?php echo htmlspecialchars($fechaInicio, ENT_QUOTES, "UTF-8"); ?>"
                >
            </div>

            <div class="historial-form-group">
                <label for="fecha_fin">Hasta</label>
                <input 
                    type="date" 
                    name="fecha_fin" 
                    id="fecha_fin"
                    value="<?php echo htmlspecialchars($fechaFin, ENT_QUOTES, "UTF-8"); ?>"
                >
            </div>

            <div class="historial-form-group">
                <button type="submit" class="historial-btn">Filtrar</button>
            </div>
        </form>

        <br>

        <a href="index.php?controller=historial&action=index" class="historial-btn-secundario">
            Limpiar filtros
        </a>
    </section>

    <section class="historial-card">
        <h2>Movimientos registrados</h2>

        <div class="historial-tabla-responsive">
            <table class="historial-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Usuario</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Observación</th>
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
                                <td><?php echo htmlspecialchars($movimiento["cantidad"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($movimiento["motivo"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($movimiento["observacion"] ?? "-", ENT_QUOTES, "UTF-8"); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8">No se encontraron movimientos registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once "views/layouts/footer.php"; ?>