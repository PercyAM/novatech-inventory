package com.novatech.tools;

import org.junit.jupiter.api.Test;

import java.nio.file.Files;
import java.nio.file.Path;

import static org.junit.jupiter.api.Assertions.assertTrue;

class InventoryExcelReportTest {

    @Test
    void debeGenerarReporteExcel() throws Exception {
        Path outputPath = Path.of("target/reporte_inventario_test.xlsx");

        InventoryExcelReport.generarReporteInventario(outputPath);

        assertTrue(Files.exists(outputPath));
        assertTrue(Files.size(outputPath) > 0);
    }
}