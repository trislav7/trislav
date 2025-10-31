<?php
// config/domains.php

// Определяем текущий домен
$currentHost = $_SERVER['HTTP_HOST'] ?? 'xn--80aeqmxhe.xn--p1ai';

// Доменные имена в разных форматах
$domains = [
    'trislav_group' => [
        'primary' => 'трислав.рф',
        'punycode' => 'xn--80aeqmxhe.xn--p1ai'
    ],
    'trislav_media' => [
        'primary' => 'медиа.трислав.рф', 
        'punycode' => 'xn--80ahcnr.xn--80aeqmxhe.xn--p1ai',
        'alternative' => 'media.trislav.ru'
    ]
];

// Определяем тип сайта
$isTrislavMedia = (strpos($currentHost, $domains['trislav_media']['punycode']) !== false) ||
                  (strpos($currentHost, $domains['trislav_media']['alternative']) !== false);

$isTrislavGroup = !$isTrislavMedia;

// Сохраняем в глобальные константы для использования по всему сайту
define('CURRENT_HOST', $currentHost);
define('IS_TRISLAV_MEDIA', $isTrislavMedia);
define('IS_TRISLAV_GROUP', $isTrislavGroup);
define('SITE_TYPE', $isTrislavMedia ? 'media' : 'group');

// Для отладки
if (isset($_GET['debug_domains'])) {
    echo "<!-- DOMAIN DEBUG: ";
    echo "Current Host: " . CURRENT_HOST . " | ";
    echo "Is Trislav Media: " . (IS_TRISLAV_MEDIA ? 'true' : 'false') . " | ";
    echo "Is Trislav Group: " . (IS_TRISLAV_GROUP ? 'true' : 'false') . " | ";
    echo "Site Type: " . SITE_TYPE;
    echo " -->";
}
?>