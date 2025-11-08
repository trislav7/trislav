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
        try {
            $stmt = $this->pdo->prepare($sql);

            // 🔥 ДОБАВЛЯЕМ ЛОГИРОВАНИЕ

            // 🔥 ПРАВИЛЬНЫЙ БИНДИНГ ПАРАМЕТРОВ
            foreach ($params as $index => $value) {
                $paramNumber = $index + 1;

                if (is_int($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_INT);
                } elseif (is_bool($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_BOOL);
                } elseif (is_null($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_NULL);
                } else {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_STR);
                }
            }

            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            // 🔥 ДЕТАЛЬНОЕ ЛОГИРОВАНИЕ ОШИБОК
            $errorInfo = [
                'error' => $e->getMessage(),
                'sql' => $sql,
                'params' => $params,
                'trace' => $e->getTraceAsString()
            ];

            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }


    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result;
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}