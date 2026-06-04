<?php
$titulo = "Productos con Stock Bajo";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Productos con Stock Bajo</strong>
        <span>
            <?php echo $_SESSION["usuario"]["nombres"] . " " . $_SESSION["usuario"]["apellidos"]; ?>
        </span>
    </div>

    <div class="content">
        <h1 class="page-title">Productos con stock bajo</h1>
        <p class="page-subtitle">
            Lista de productos cuyo stock actual es menor o igual al stock mínimo establecido.
        </p>

        <div class="toolbar">
            <a href="index.php?controller=stock&action=index" class="btn btn-light">
                Volver a consulta de stock
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Alertas de stock bajo</h2>
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
                            <th>Estado</th>
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
                                        <span class="badge badge-warning">
                                            <?php echo $fila["stock_actual"]; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $fila["stock_minimo"]; ?></td>
                                    <td>
                                        <span class="badge badge-warning">Requiere reposición</span>
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
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>