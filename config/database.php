<?php
return [
    'host' => 'localhost',
    'dbname' => 'cg00958_trislav',
    'username' => 'cg00958_trislav',
    'password' => '1wN3aNR6i7',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_TIMEOUT => 300, // 5 минут
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET wait_timeout=300, interactive_timeout=300"
    ]
];
