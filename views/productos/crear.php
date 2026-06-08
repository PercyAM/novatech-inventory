<?php
$titulo = "Registrar Producto";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Registrar Producto</strong>
        <span><?php echo $_SESSION["usuario"]["rol"]; ?></span>
    </div>

    <div class="content">
        <h1 class="page-title">Registrar producto</h1>
        <p class="page-subtitle">Complete los datos para registrar un nuevo producto.</p>

        <?php if (isset($_GET["error"])) { ?>
            <div class="alert-error">Verifique los datos ingresados.</div>
        <?php } ?>

        <div class="card">
            <div class="card-header">
                <h2>Datos del producto</h2>
            </div>

            <div class="card-body">
                <form action="index.php?controller=producto&action=guardar" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Código</label>
                            <input type="text" name="codigo_producto" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nombre del producto</label>
                            <input type="text" name="nombre_producto" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Categoría</label>
                            <input type="text" name="categoria" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" name="marca" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" name="modelo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Stock actual</label>
                            <input type="number" name="stock_actual" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Stock mínimo</label>
                            <input type="number" name="stock_minimo" class="form-control" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Precio referencial</label>
                            <input type="number" name="precio_referencial" class="form-control" min="0" step="0.01" value="0">
                        </div>

                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Descripción del producto</label>
                            <textarea name="descripcion" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Descripción del detalle</label>
                            <textarea name="descripcion_detalle" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="index.php?controller=producto&action=index" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-dark">Guardar producto</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>