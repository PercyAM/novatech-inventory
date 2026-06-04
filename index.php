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

    default:
        require_once "app/controllers/LoginController.php";
        $controllerObject = new LoginController();
        break;
}

if (method_exists($controllerObject, $action)) {
    $controllerObject->$action();
} else {
    echo "Acción no encontrada.";
}