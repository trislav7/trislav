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
?>