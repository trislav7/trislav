<?php
// config/yandex_disk.php
return [
    'token' => 'y0__xC0xcuAARiOrTsgmOP3gRUw6InHlAheb8TKhaxfgz22F0Q3B_BZ9YY5YQ', // Замените на реальный токен
    'base_path' => 'slides/',
    'max_file_size' => 500 * 1024 * 1024, // 500MB
    'allowed_types' => ['mp4', 'avi', 'mov', 'wmv', 'flv']
];
?>