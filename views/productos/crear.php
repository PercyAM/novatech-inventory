<?php
$titulo = "Registrar Producto";
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";

$rolUsuario = $_SESSION["usuario"]["rol"] ?? "Usuario";
?>

<style>
    .registrar-producto-content {
        margin-left: 260px !important;
        width: calc(100vw - 260px) !important;
        min-height: 100vh;
        padding: 24px;
        box-sizing: border-box;
        background-color: #f3f4f6;
        overflow-x: hidden;
    }

    .registrar-producto-topbar {
        background-color: #ffffff;
        padding: 16px 22px;
        border-radius: 12px;
        margin-bottom: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        box-sizing: border-box;
    }

    .registrar-producto-topbar strong {
        font-size: 18px;
        color: #111827;
    }

    .registrar-producto-topbar span {
        font-size: 14px;
        color: #6b7280;
        font-weight: 600;
    }

    .registrar-producto-header {
        margin-bottom: 20px;
    }

    .registrar-producto-title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 6px 0;
    }

    .registrar-producto-subtitle {
        font-size: 15px;
        color: #6b7280;
        margin: 0;
    }

    .registrar-producto-card {
        width: 100%;
        background-color: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        box-sizing: border-box;
    }

    .registrar-producto-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    .registrar-producto-card-header h2 {
        margin: 0;
        font-size: 19px;
        color: #111827;
    }

    .registrar-producto-card-body {
        padding: 24px;
        box-sizing: border-box;
    }

    .registrar-producto-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 22px;
        width: 100%;
        box-sizing: border-box;
    }

    .registrar-producto-form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .registrar-producto-form-group label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .registrar-producto-form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        font-size: 14px;
        color: #111827;
        background-color: #ffffff;
        box-sizing: border-box;
        outline: none;
    }

    .registrar-producto-form-control:focus {
        border-color: #111827;
        box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.10);
    }

    textarea.registrar-producto-form-control {
        min-height: 95px;
        resize: vertical;
    }

    .registrar-producto-full {
        grid-column: span 2;
    }

    .registrar-producto-actions {
        margin-top: 26px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .registrar-producto-btn {
        padding: 11px 18px;
        border-radius: 9px;
        border: none;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .registrar-producto-btn-light {
        background-color: #e5e7eb;
        color: #111827;
    }

    .registrar-producto-btn-light:hover {
        background-color: #d1d5db;
    }

    .registrar-producto-btn-dark {
        background-color: #111827;
        color: #ffffff;
    }

    .registrar-producto-btn-dark:hover {
        background-color: #1f2937;
    }

    .registrar-producto-alert-error {
        width: 100%;
        padding: 13px 16px;
        margin-bottom: 18px;
        border-radius: 10px;
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        font-size: 14px;
        box-sizing: border-box;
    }

    @media (max-width: 900px) {
        .registrar-producto-content {
            margin-left: 0 !important;
            width: 100vw !important;
            padding: 18px;
        }

        .registrar-producto-grid {
            grid-template-columns: 1fr;
        }

        .registrar-producto-full {
            grid-column: span 1;
        }

        .registrar-producto-topbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .registrar-producto-actions {
            justify-content: stretch;
        }

        .registrar-producto-btn {
            width: 100%;
        }
    }
</style>

<main class="registrar-producto-content">
    <div class="registrar-producto-topbar">
        <strong>Registrar Producto</strong>
        <span><?php echo htmlspecialchars($rolUsuario, ENT_QUOTES, 'UTF-8'); ?></span>
    </div>

    <div class="registrar-producto-header">
        <h1 class="registrar-producto-title">Registrar producto</h1>
        <p class="registrar-producto-subtitle">Complete los datos para registrar un nuevo producto.</p>
    </div>

    <?php if (isset($_GET["error"])) { ?>
        <div class="registrar-producto-alert-error">
            Verifique los datos ingresados.
        </div>
    <?php } ?>

    <div class="registrar-producto-card">
        <div class="registrar-producto-card-header">
            <h2>Datos del producto</h2>
        </div>

        <div class="registrar-producto-card-body">
            <form action="index.php?controller=producto&action=guardar" method="POST">
                <div class="registrar-producto-grid">

                    <div class="registrar-producto-form-group">
                        <label>Código</label>
                        <input type="text" name="codigo_producto" class="registrar-producto-form-control" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Nombre del producto</label>
                        <input type="text" name="nombre_producto" class="registrar-producto-form-control" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Categoría</label>
                        <input type="text" name="categoria" class="registrar-producto-form-control" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Marca</label>
                        <input type="text" name="marca" class="registrar-producto-form-control" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Modelo</label>
                        <input type="text" name="modelo" class="registrar-producto-form-control">
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Stock actual</label>
                        <input type="number" name="stock_actual" class="registrar-producto-form-control" min="0" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Stock mínimo</label>
                        <input type="number" name="stock_minimo" class="registrar-producto-form-control" min="0" required>
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Precio referencial</label>
                        <input type="number" name="precio_referencial" class="registrar-producto-form-control" min="0" step="0.01" value="0">
                    </div>

                    <div class="registrar-producto-form-group">
                        <label>Estado</label>
                        <select name="estado" class="registrar-producto-form-control">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="registrar-producto-form-group registrar-producto-full">
                        <label>Descripción del producto</label>
                        <textarea name="descripcion" class="registrar-producto-form-control"></textarea>
                    </div>

                    <div class="registrar-producto-form-group registrar-producto-full">
                        <label>Descripción del detalle</label>
                        <textarea name="descripcion_detalle" class="registrar-producto-form-control"></textarea>
                    </div>
                </div>

                <div class="registrar-producto-actions">
                    <a href="index.php?controller=producto&action=index" class="registrar-producto-btn registrar-producto-btn-light">
                        Cancelar
                    </a>

                    <button type="submit" class="registrar-producto-btn registrar-producto-btn-dark">
                        Guardar producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once "views/layouts/footer.php"; ?>