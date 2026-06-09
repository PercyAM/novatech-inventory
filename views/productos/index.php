<?php
$titulo = "Gestión de Productos";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Gestión de Productos</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Gestión de Productos</h1>
        <p class="page-subtitle">Registre, consulte, edite y administre los productos del inventario.</p>

        <?php if (isset($_GET["mensaje"])) { ?>
            <div class="alert-success">Operación realizada correctamente.</div>
        <?php } ?>

        <?php if (isset($_GET["error"])) { ?>
            <div class="alert-error">Ocurrió un error al realizar la operación.</div>
        <?php } ?>

        <div class="toolbar">
            <form method="GET" action="index.php">
                <input type="hidden" name="controller" value="producto">
                <input type="hidden" name="action" value="index">

                <input 
                    type="text" 
                    name="buscar" 
                    class="search-input" 
                    placeholder="Buscar por código, producto, categoría o marca"
                    value="<?php echo htmlspecialchars($busqueda ?? ""); ?>"
                >

                <button type="submit" class="btn btn-dark">Buscar</button>
                <a href="index.php?controller=producto&action=index" class="btn btn-light">Limpiar</a>
            </form>

            <a href="index.php?controller=producto&action=crear" class="btn btn-dark">
                Nuevo producto
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Lista de productos</h2>
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
                            <th>Stock</th>
                            <th>Stock mín.</th>
                            <th>Estado</th>
                            <th>Acciones</th>
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
                                            <?php echo $fila["stock_actual"]; ?>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $fila["stock_minimo"]; ?></td>
                                    <td>
                                        <?php if ($fila["estado"] === "Activo") { ?>
                                            <span class="badge badge-success">Activo</span>
                                        <?php } else { ?>
                                            <span class="badge badge-danger">Inactivo</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a 
                                            href="index.php?controller=producto&action=editar&id=<?php echo $fila["id_producto"]; ?>"
                                            class="btn btn-light"
                                        >
                                            Editar
                                        </a>

                                        <a 
                                            href="index.php?controller=producto&action=eliminar&id=<?php echo $fila["id_producto"]; ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar este producto?');"
                                        >
                                            Eliminar
                                        </a>
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