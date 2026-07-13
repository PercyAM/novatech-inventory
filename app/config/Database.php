<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/helpers/AppLogger.php';

class Database
{
    private string $dbHost = "localhost";
    private string $database = "bd_inventario_computo";
    private string $user = "root";
    private string $password = "";
    private ?PDO $connection = null;

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "mysql:host={$this->dbHost};dbname={$this->database};charset=utf8mb4",
                    $this->user,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_PERSISTENT => false,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]
                );
            } catch (PDOException $e) {
                AppLogger::getInstance()->critical("Database connection failed", [
                    'db_host' => $this->dbHost,
                    'database' => $this->database,
                    'error' => $e->getMessage()
                ]);

                throw new RuntimeException("Error interno de base de datos. Por favor contacte al administrador.");
            }
        }

        return $this->connection;
    }
}