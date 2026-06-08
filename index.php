<?php
session_start();

$controller = $_GET["controller"] ?? "login";
$action = $_GET["action"] ?? "index";

switch ($controller) {
    case "login":
        require_once "app/controllers/LoginController.php";
        $controllerObject = new LoginController();
        break;

    case "dashboard":
        require_once "app/controllers/DashboardController.php";
        $controllerObject = new DashboardController();
        break;

    case "producto":
        require_once "app/controllers/ProductoController.php";
        $controllerObject = new ProductoController();
        break;

    case "stock":
        require_once "app/controllers/StockController.php";
        $controllerObject = new StockController();
        break;

    case "report":
        require_once "app/controllers/ReportController.php";
        $controllerObject = new ReportController();
        break;

    case "salida":
        require_once "app/controllers/SalidaController.php";
        $controllerObject = new SalidaController();
        break;

    case "usuario":
        require_once "app/controllers/UsuarioController.php";
        $controllerObject = new UsuarioController();
        break;

    case "reporte":
        require_once "app/controllers/ReporteController.php";
        $controllerObject = new ReporteController();
        break;

    case "historial":
        require_once "app/controllers/HistorialController.php";
        $controllerObject = new HistorialController();
        break;

    default:
        require_once "app/controllers/LoginController.php";
        $controllerObject = new LoginController();
        break;
}

if (method_exists($controllerObject, $action)) {
    $controllerObject->$action();
} else {
    // Escaping output to prevent potential DOM XSS
    echo "Acción no encontrada.";
}