<?php
$titulo = "Historial de Movimientos";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Historial de Movimientos</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Historial de movimientos</h1>
        <p class="page-subtitle">
            Consulte las entradas y salidas de productos registradas en el inventario.
        </p>

        <div class="card">
            <div class="card-header">
                <h2>Filtros de búsqueda</h2>
            </div>

            <div class="card-body">
                <form action="#" method="GET">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Producto</label>
                            <input 
                                type="text" 
                                name="producto" 
                                class="form-control" 
                                placeholder="Buscar por producto o código"
                            >
                        </div>

                        <div class="form-group">
                            <label>Tipo de movimiento</label>
                            <select name="tipo_movimiento" class="form-control">
                                <option value="">Todos</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Usuario responsable</label>
                            <input 
                                type="text" 
                                name="usuario" 
                                class="form-control" 
                                placeholder="Buscar por usuario"
                            >
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
                        <button type="submit" class="btn btn-dark">Buscar movimientos</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Movimientos registrados</h2>
            </div>

            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Motivo</th>
                            <th>Responsable</th>
                            <th>Observación</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="8">No hay movimientos registrados.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>