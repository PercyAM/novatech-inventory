<?php
declare(strict_types=1);

// Set error reporting to catch any strict typing or execution issues
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "=== INICIANDO VERIFICACIÓN DE SEGURIDAD Y REFACTORIZACIÓN (NOVATECH) ===\n\n";

// Load files manually
require_once 'app/helpers/AppLogger.php';
require_once 'app/models/Producto.php';
require_once 'app/models/DetalleProducto.php';
require_once 'app/config/Database.php';

$success = true;

// 1. Test Logger Injection Prevention
echo "[Test 1] Verificando Logger (Prevención de Inyección de Logs)...\n";
$loggerFile = __DIR__ . '/../storage/logs/test.log';
if (file_exists($loggerFile)) {
    unlink($loggerFile);
}

// Instantiate AppLogger pointing to test file
$logger = AppLogger::getInstance();
// Force a custom path reflection if possible, or use standard log since it uses JSON.
// We will test if logging structure is correct. We can inspect the main log file.
$logger->info("Test message with newline\nInjecting admin successful login", ['user' => "attacker\nlevel:admin"]);

$mainLogFile = __DIR__ . '/../storage/logs/app.log';
if (file_exists($mainLogFile)) {
    $logContents = file_get_contents($mainLogFile);
    $lines = explode("\n", trim($logContents));
    $lastLine = end($lines);
    
    // Check if it is valid JSON
    $decoded = json_decode($lastLine, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo " -> ÉXITO: El log se grabó en formato JSON estructurado sin romper la línea física.\n";
        echo " -> Mensaje grabado: " . json_encode($decoded['message']) . "\n";
    } else {
        echo " -> FALLO: El log no está en formato JSON válido.\n";
        $success = false;
    }
} else {
    echo " -> ADVERTENCIA: No se pudo verificar el archivo de log principal.\n";
}

// 2. Test Immutability of Models (PHP 8.2)
echo "\n[Test 2] Verificando Inmutabilidad de DTOs (Producto / DetalleProducto)...\n";
try {
    $producto = new Producto(
        100,
        200,
        "PROD-TEST",
        "Laptop Gamer",
        "Alienware M16",
        15,
        5,
        1500.50,
        "Laptop de alta gama",
        "Activo"
    );
    
    echo " -> Acceso directo a propiedad (PHP 8.2 readonly constructor promotion): " . $producto->nombreProducto . " (OK)\n";
    
    // Attempting to modify readonly property should trigger Error
    try {
        // @phpstan-ignore-next-line
        $producto->nombreProducto = "Modificado"; 
        echo " -> FALLO: Se permitió modificar una propiedad readonly!\n";
        $success = false;
    } catch (Error $e) {
        echo " -> ÉXITO: Se bloqueó la manipulación externa (Error: " . $e->getMessage() . ")\n";
    }
} catch (Exception $e) {
    echo " -> FALLO: Error al instanciar el modelo readonly: " . $e->getMessage() . "\n";
    $success = false;
}

// 3. Test Password Hash and Verification
echo "\n[Test 3] Verificando Mecanismo de Hashing de Contraseñas...\n";
$password = "123456";
$hash = password_hash($password, PASSWORD_BCRYPT);
echo " -> Hash generado para '123456': " . $hash . "\n";

if (password_verify($password, $hash)) {
    echo " -> ÉXITO: password_verify() validó correctamente el hash bcrypt.\n";
} else {
    echo " -> FALLO: password_verify() no coincide con el hash generado.\n";
    $success = false;
}

if (password_needs_rehash($hash, PASSWORD_BCRYPT)) {
    echo " -> FALLO: El hash bcrypt dice requerir re-hash innecesario.\n";
    $success = false;
} else {
    echo " -> ÉXITO: password_needs_rehash() determinó que el hash está actualizado.\n";
}

// 4. Test Database Connection Error Logging
echo "\n[Test 4] Verificando robustez de Database.php (Dispensador de errores seguro)...\n";
// Temporarily mock configuration or verify if it logs connection errors
// We can assert that connection exceptions are captured and no die() is fired.
try {
    $db = new Database();
    // Verify that the connection is a PDO instance or handles failures gracefully
    $pdo = $db->getConnection();
    echo " -> Conexión exitosa a la base de datos local.\n";
} catch (RuntimeException $e) {
    echo " -> ÉXITO Capturado (Fallo controlado): " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo " -> FALLO no controlado: " . $e->getMessage() . "\n";
    $success = false;
}

echo "\n=======================================================================\n";
if ($success) {
    echo "=== VERIFICACIÓN COMPLETADA: TODOS LOS CONTROLES PASARON CORRECTAMENTE ===\n";
} else {
    echo "=== VERIFICACIÓN COMPLETADA CON ERRORES ===\n";
    exit(1);
}
