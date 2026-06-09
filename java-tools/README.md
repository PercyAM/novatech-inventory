    # Módulo Java de apoyo - NovaTech Inventory

Este módulo complementa el sistema principal NovaTech Inventory, desarrollado en PHP, agregando herramientas auxiliares en Java para cumplir con el uso de librerías de apoyo solicitadas en la rúbrica del proyecto.

## Librerías utilizadas

| Librería | Uso en el proyecto |
|---|---|
| Google Guava | Se usa `ImmutableList` para definir cabeceras inmutables del reporte de inventario. |
| Apache POI | Se usa para generar reportes Excel `.xlsx` del inventario. |
| Apache Commons Lang | Se usa `StringUtils` para validar y normalizar textos antes de agregarlos al reporte. |
| Logback | Se usa para registrar eventos y errores durante la generación de reportes. |
| JUnit | Se usa para validar mediante prueba unitaria que el reporte Excel se genere correctamente. |

## Comandos

Compilar el módulo:

```bash
mvn clean compile