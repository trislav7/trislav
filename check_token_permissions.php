<?php
define('ROOT_PATH', __DIR__);
require_once 'app/core/debug_helper.php';
require_once 'app/core/YandexDiskService.php';

$yandexConfig = require 'config/yandex_disk.php';
$diskService = new YandexDiskService($yandexConfig['token']);

// Проверим информацию о диске
$url = 'https://cloud-api.yandex.net/v1/disk';
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: OAuth ' . $yandexConfig['token']
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $diskInfo = json_decode($response, true);
} else {
}

// Проверим создание папки с разными путями
$testPaths = [
    'app:/slides/test', // Попробуем с префиксом app:/
    'slides/test',
    'disk:/slides/test' // Попробуем с префиксом disk:/
];

foreach ($testPaths as $testPath) {

    $url = 'https://cloud-api.yandex.net/v1/disk/resources?path=' . urlencode($testPath);
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_HTTPHEADER => [
            'Authorization: OAuth ' . $yandexConfig['token']
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
}

echo "Check debug.log for token permissions";
?>