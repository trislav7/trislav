<?php
// app/core/helpers.php
function safe_json_decode($json, $default = []) {
    if (empty($json) || !is_string($json)) {
        return $default;
    }
    
    $decoded = json_decode($json, true);
    return json_last_error() === JSON_ERROR_NONE ? $decoded : $default;
}

function safe_upper($string) {
    return $string ? strtoupper($string) : '';
}

function safe_lower($string) {
    return $string ? strtolower($string) : '';
}

function debug_log($message) {
    $logFile = ROOT_PATH . '/debug.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

function getPortfolioVideoUrl($portfolioItem) {
    debug_log("Getting video URL for portfolio item ID: " . ($portfolioItem['id'] ?? 'unknown'));

    // Приоритет 1: Прокси для Яндекс.Диска
    if (!empty($portfolioItem['yandex_disk_path']) && !empty($portfolioItem['id'])) {
        $proxyUrl = "/video/stream?id=" . $portfolioItem['id'];
        debug_log("Using proxy URL: " . $proxyUrl);
        return $proxyUrl;
    }

    // Приоритет 2: Локальный файл (если существует)
    if (!empty($portfolioItem['video_filename'])) {
        $localPath = '/uploads/videos/' . $portfolioItem['video_filename'];
        $fullLocalPath = ROOT_PATH . $localPath;

        if (file_exists($fullLocalPath)) {
            debug_log("Using existing local video file: " . $localPath);
            return $localPath;
        } else {
            debug_log("Local file not found: " . $fullLocalPath);
        }
    }

    // Приоритет 3: Внешняя ссылка
    if (!empty($portfolioItem['video_url'])) {
        debug_log("Using external video URL: " . $portfolioItem['video_url']);
        return $portfolioItem['video_url'];
    }

    debug_log("No video source found for portfolio item ID: " . ($portfolioItem['id'] ?? 'unknown'));
    return null;
}
?>