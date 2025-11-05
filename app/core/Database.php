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
            debug_log("Database Query: " . $sql);
            debug_log("Query Params: " . print_r($params, true));

            // 🔥 ПРАВИЛЬНЫЙ БИНДИНГ ПАРАМЕТРОВ
            foreach ($params as $index => $value) {
                $paramNumber = $index + 1;

                if (is_int($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_INT);
                    debug_log("Binding param $paramNumber as INT: $value");
                } elseif (is_bool($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_BOOL);
                    debug_log("Binding param $paramNumber as BOOL: $value");
                } elseif (is_null($value)) {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_NULL);
                    debug_log("Binding param $paramNumber as NULL");
                } else {
                    $stmt->bindValue($paramNumber, $value, PDO::PARAM_STR);
                    debug_log("Binding param $paramNumber as STRING: $value");
                }
            }

            $stmt->execute();
            debug_log("Query executed successfully");

            return $stmt;

        } catch (PDOException $e) {
            // 🔥 ДЕТАЛЬНОЕ ЛОГИРОВАНИЕ ОШИБОК
            $errorInfo = [
                'error' => $e->getMessage(),
                'sql' => $sql,
                'params' => $params,
                'trace' => $e->getTraceAsString()
            ];
            debug_log("DATABASE ERROR: " . print_r($errorInfo, true));

            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }


    public function fetchAll($sql, $params = []) {
        debug_log("fetchAll called with SQL: " . $sql);
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetchAll();
        debug_log("fetchAll result count: " . count($result));
        return $result;
    }

    public function fetch($sql, $params = []) {
        debug_log("fetch called with SQL: " . $sql);
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        debug_log("fetch result: " . ($result ? 'found' : 'not found'));
        return $result;
    }
    
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}