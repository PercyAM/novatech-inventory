<?php
$titulo = "Editar Producto";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
?>

<div class="main">
    <div class="topbar">
        <strong>Editar Producto</strong>
        <span><?php echo $_SESSION["usuario"]["rol"]; ?></span>
    </div>

    <div class="content">
        <h1 class="page-title">Editar producto</h1>
        <p class="page-subtitle">Modifique los datos del producto seleccionado.</p>

        <div class="card">
            <div class="card-header">
                <h2>Datos del producto</h2>
            </div>

            <div class="card-body">
                <form action="index.php?controller=producto&action=actualizar" method="POST">
                    <input type="hidden" name="id_producto" value="<?php echo $producto["id_producto"]; ?>">
                    <input type="hidden" name="id_detalle_producto" value="<?php echo $producto["id_detalle_producto"]; ?>">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Código</label>
                            <input 
                                type="text" 
                                name="codigo_producto" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($producto["codigo_producto"]); ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Nombre del producto</label>
                            <input 
                                type="text" 
                                name="nombre_producto" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($producto["nombre_producto"]); ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Categoría</label>
                            <input 
                                type="text" 
                                name="categoria" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($producto["categoria"]); ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Marca</label>
                            <input 
                                type="text" 
                                name="marca" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($producto["marca"]); ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Modelo</label>
                            <input 
                                type="text" 
                                name="modelo" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($producto["modelo"]); ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label>Stock actual</label>
                            <input 
                                type="number" 
                                name="stock_actual" 
                                class="form-control" 
                                min="0"
                                value="<?php echo $producto["stock_actual"]; ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Stock mínimo</label>
                            <input 
                                type="number" 
                                name="stock_minimo" 
                                class="form-control" 
                                min="0"
                                value="<?php echo $producto["stock_minimo"]; ?>" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Precio referencial</label>
                            <input 
                                type="number" 
                                name="precio_referencial" 
                                class="form-control" 
                                min="0"
                                step="0.01"
                                value="<?php echo $producto["precio_referencial"]; ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" class="form-control">
                                <option value="Activo" <?php echo $producto["estado"] === "Activo" ? "selected" : ""; ?>>
                                    Activo
                                </option>
                                <option value="Inactivo" <?php echo $producto["estado"] === "Inactivo" ? "selected" : ""; ?>>
                                    Inactivo
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Descripción del producto</label>
                            <textarea name="descripcion" class="form-control"><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Descripción del detalle</label>
                            <textarea name="descripcion_detalle" class="form-control"><?php echo htmlspecialchars($producto["descripcion_detalle"]); ?></textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="index.php?controller=producto&action=index" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-dark">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once "views/layouts/footer.php"; ?>