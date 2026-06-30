package com.novatech.tools;

import com.google.common.collect.ImmutableList;
import org.apache.commons.lang3.StringUtils;
import org.apache.poi.ss.usermodel.*;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.io.FileOutputStream;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.List;

public class InventoryExcelReport {

    private static final Logger logger = LoggerFactory.getLogger(InventoryExcelReport.class);

    // Google Guava: lista inmutable para cabeceras del reporte
    private static final List<String> HEADERS = ImmutableList.of(
            "Código",
            "Producto",
            "Categoría",
            "Marca",
            "Modelo",
            "Stock actual",
            "Stock mínimo",
            "Estado"
    );

    public static void main(String[] args) {
        try {
            Path outputPath = Path.of("../storage/reportes/reporte_inventario.xlsx");
            generarReporteInventario(outputPath);
            logger.info("Reporte Excel generado correctamente en: {}", outputPath.toAbsolutePath());
        } catch (Exception e) {
            logger.error("Error al generar reporte Excel de inventario", e);
        }
    }

    public static void generarReporteInventario(Path outputPath) throws IOException {
        Files.createDirectories(outputPath.getParent());

        try (Workbook workbook = new XSSFWorkbook()) {
            Sheet sheet = workbook.createSheet("Inventario");

            crearCabecera(workbook, sheet);
            agregarDatosEjemplo(sheet);
            ajustarColumnas(sheet);

            try (FileOutputStream fileOut = new FileOutputStream(outputPath.toFile())) {
                workbook.write(fileOut);
            }
        }
    }

    private static void crearCabecera(Workbook workbook, Sheet sheet) {
        Row headerRow = sheet.createRow(0);

        CellStyle headerStyle = workbook.createCellStyle();
        Font font = workbook.createFont();
        font.setBold(true);
        headerStyle.setFont(font);

        for (int i = 0; i < HEADERS.size(); i++) {
            Cell cell = headerRow.createCell(i);
            cell.setCellValue(HEADERS.get(i));
            cell.setCellStyle(headerStyle);
        }

        logger.info("Cabecera del reporte creada con {} columnas", HEADERS.size());
    }

    private static void agregarDatosEjemplo(Sheet sheet) {
        Object[][] productos = {
                {"PROD-001", limpiarTexto("Laptop Lenovo"), "Laptop", "Lenovo", "ThinkPad E14", 12, 5, "Activo"},
                {"PROD-002", limpiarTexto("Mouse Logitech"), "Accesorio", "Logitech", "M185", 4, 10, "Stock bajo"},
                {"PROD-003", limpiarTexto("Monitor Samsung"), "Monitor", "Samsung", "24 pulgadas", 8, 3, "Activo"}
        };

        int rowIndex = 1;

        for (Object[] producto : productos) {
            Row row = sheet.createRow(rowIndex++);

            for (int i = 0; i < producto.length; i++) {
                Cell cell = row.createCell(i);
                Object value = producto[i];

                if (value instanceof Number number) {
                    cell.setCellValue(number.doubleValue());
                } else {
                    cell.setCellValue(String.valueOf(value));
                }
            }
        }

        logger.info("Se agregaron {} productos de ejemplo al reporte", productos.length);
    }

    private static String limpiarTexto(String texto) {
        // Apache Commons Lang: valida texto en blanco y normaliza espacios
        if (StringUtils.isBlank(texto)) {
            return "Sin descripción";
        }

        return StringUtils.normalizeSpace(texto);
    }

    private static void ajustarColumnas(Sheet sheet) {
        for (int i = 0; i < HEADERS.size(); i++) {
            sheet.autoSizeColumn(i);
        }
    }
}