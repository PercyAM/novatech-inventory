<?php
declare(strict_types=1);

require_once 'app/config/Database.php';
require_once 'app/helpers/AppLogger.php';

class ReportService
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Streams the entire inventory of products as a CSV report to avoid memory exhaustion.
     * Memory complexity: O(1)
     */
    public function exportarInventarioCsv(): void
    {
        try {
            $conexion = $this->database->getConnection();

            // Set SQL buffering to false for memory efficiency on massive queries
            $conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

            $sql = "SELECT 
                        p.codigo_producto,
                        p.nombre_producto,
                        d.categoria,
                        d.marca,
                        p.modelo,
                        p.stock_actual,
                        p.stock_minimo,
                        p.precio_referencial,
                        p.estado
                    FROM producto p
                    INNER JOIN detalle_producto d 
                        ON p.id_detalle_producto = d.id_detalle_producto
                    ORDER BY p.nombre_producto ASC";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            // Open stream to PHP output
            $out = fopen('php://output', 'w');
            if ($out === false) {
                throw new RuntimeException("Could not open output stream");
            }

            // UTF-8 BOM for proper Spanish characters detection in Excel
            fwrite($out, "\xEF\xBB\xBF");

            // Write CSV headers
            fputcsv($out, [
                'Código',
                'Producto',
                'Categoría',
                'Marca',
                'Modelo',
                'Stock Actual',
                'Stock Mínimo',
                'Precio Referencial',
                'Estado'
            ]);

            // Stream records one by one
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // If any product has low stock, we can log a warning once as requested in criteria
                if ((int)$row['stock_actual'] <= (int)$row['stock_minimo']) {
                    AppLogger::getInstance()->warning("Low stock detected on report stream", [
                        'codigo' => $row['codigo_producto'],
                        'producto' => $row['nombre_producto'],
                        'stock_actual' => $row['stock_actual']
                    ]);
                }

                fputcsv($out, [
                    $row['codigo_producto'],
                    $row['nombre_producto'],
                    $row['categoria'],
                    $row['marca'],
                    $row['modelo'],
                    $row['stock_actual'],
                    $row['stock_minimo'],
                    number_format((float)$row['precio_referencial'], 2, '.', ''),
                    $row['estado']
                ]);
            }

            fclose($out);

            // Restore SQL buffered query setting for normal queries
            $conexion->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

        } catch (Exception $e) {
            AppLogger::getInstance()->error("Error generating inventory CSV report", [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
