<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Проверяем, существует ли конфиг
        $configFile = ROOT_PATH . '/config/database.php';
        if (!file_exists($configFile)) {
            die("Файл конфигурации базы данных не найден: " . $configFile);
        }

        $config = require $configFile;

        // Проверяем наличие всех необходимых параметров
        $required = ['host', 'dbname', 'username', 'password'];
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                die("Отсутствует параметр конфигурации: $key. Доступные ключи: " . implode(', ', array_keys($config)));
            }
        }

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            $options = $config['options'] ?? [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 300
            ];

            $this->pdo = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $options
            );

            // Дополнительно устанавливаем таймауты
            $this->pdo->exec("SET wait_timeout=300");
            $this->pdo->exec("SET interactive_timeout=300");

        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}