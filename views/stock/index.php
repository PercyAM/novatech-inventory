<?php
$titulo = "Consulta y Control de Stock";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Consulta y Control de Stock</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Consulta y Control de Stock</h1>
        <p class="page-subtitle">
            Consulte el stock actual de los productos registrados en el inventario.
        </p>

        <div class="toolbar">
            <form method="GET" action="index.php">
                <input type="hidden" name="controller" value="stock">
                <input type="hidden" name="action" value="index">

                <input 
                    type="text" 
                    name="buscar" 
                    class="search-input" 
                    placeholder="Buscar por código, producto, categoría o marca"
                    value="<?php echo htmlspecialchars($busqueda ?? ""); ?>"
                >

                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="index.php?controller=stock&action=index" class="btn btn-light">Limpiar</a>
                <a href="index.php?controller=stock&action=bajo" class="btn btn-danger">Ver stock bajo</a>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Stock de productos</h2>
            </div>

            <div class="card-body">
                <table>
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
                            <?php foreach ($productos as $fila) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila["codigo_producto"]); ?></td>
                                    <td><?php echo htmlspecialchars($fila["nombre_producto"]); ?></td>
                                    <td><?php echo htmlspecialchars($fila["categoria"]); ?></td>
                                    <td><?php echo htmlspecialchars($fila["marca"]); ?></td>
                                    <td><?php echo htmlspecialchars($fila["modelo"]); ?></td>

                                    <td>
                                        <?php if ($fila["stock_actual"] <= $fila["stock_minimo"]) { ?>
                                            <span class="badge badge-warning">
                                                <?php echo $fila["stock_actual"]; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge badge-success">
                                                <?php echo $fila["stock_actual"]; ?>
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td><?php echo $fila["stock_minimo"]; ?></td>

                                    <td>
                                        <?php if ($fila["stock_actual"] <= $fila["stock_minimo"]) { ?>
                                            <span class="badge badge-warning">Stock bajo</span>
                                        <?php } else { ?>
                                            <span class="badge badge-success">Stock suficiente</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($fila["estado"] === "Activo") { ?>
                                            <span class="badge badge-success">Activo</span>
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
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>