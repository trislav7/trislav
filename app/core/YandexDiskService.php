<?php
//        $logFile = ROOT_PATH . '/debug.log';
//        $timestamp = date('Y-m-d H:i:s');
//        $formattedMessage = "[$timestamp] $message\n";
//        file_put_contents($logFile, $formattedMessage, FILE_APPEND | LOCK_EX);
//    }
//}
// app/core/YandexDiskService.php
class YandexDiskService {
    private $token;
    private $baseUrl = 'https://cloud-api.yandex.net/v1/disk/resources';
    
    public function __construct($token) {
        $this->token = $token;
    }
    
    /**
     * Создает папку на Яндекс.Диске
     */
    public function createFolder($path) {
        $url = $this->baseUrl . '?path=' . urlencode($path);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => [
                'Authorization: OAuth ' . $this->token,
                'Content-Type: application/json'
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode === 201 || $httpCode === 409; // 409 - папка уже существует
    }
    
    /**
     * Загружает файл на Яндекс.Диск
     */
    private function getUploadUrl($remotePath) {
        $url = $this->baseUrl . '/upload?path=' . urlencode($remotePath) . '&overwrite=true';


        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: OAuth ' . $this->token
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);


        if ($httpCode === 200) {
            $data = json_decode($response, true);
            return $data['href'] ?? null;
        }

        return null;
    }
    

    /**
     * Загружает видео файл в папку ТЦ
     */
    public function uploadVideoToShoppingCenter($localFilePath, $shoppingCenterId, $filename) {

        $folderPath = "slides/{$shoppingCenterId}";
        $remotePath = "{$folderPath}/{$filename}";

        // Создаем папку если нужно
        if (!$this->createFolder($folderPath)) {
            return false;
        }


        // Загружаем файл
        return $this->uploadFile($localFilePath, $remotePath);
    }
    
    /**
     * Проверяет доступность Яндекс.Диска
     */
    public function checkConnection() {
        $url = 'https://cloud-api.yandex.net/v1/disk';


        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: OAuth ' . $this->token
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);


        return $httpCode === 200;
    }

    /**
     * Загружает файл на Яндекс.Диск
     */
    public function uploadFile($localFilePath, $remotePath) {

        $uploadUrl = $this->getUploadUrl($remotePath);
        if (!$uploadUrl) {
            return false;
        }


        // Загружаем файл
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $uploadUrl,
            CURLOPT_PUT => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_INFILE => fopen($localFilePath, 'r'),
            CURLOPT_INFILESIZE => filesize($localFilePath),
            CURLOPT_HTTPHEADER => [
                'Content-Type: ' . mime_content_type($localFilePath)
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);


        return $httpCode === 201;
    }

    public function downloadFile($remotePath, $localPath) {

        try {
            $url = $this->baseUrl . '/download?path=' . urlencode($remotePath);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => [
                    'Authorization: OAuth ' . $this->token,
                    'Accept: application/json'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false, // Важно: не следовать редиректам автоматически
                CURLOPT_TIMEOUT => 300
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode !== 200) {
                return false;
            }

            $data = json_decode($response, true);

            if (!isset($data['href'])) {
                return false;
            }


            // Скачиваем файл по полученной ссылке
            $fileHandle = fopen($localPath, 'wb');
            if (!$fileHandle) {
                return false;
            }

            $downloadCh = curl_init();
            curl_setopt_array($downloadCh, [
                CURLOPT_URL => $data['href'],
                CURLOPT_FILE => $fileHandle,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 300
            ]);

            $downloadResult = curl_exec($downloadCh);
            $downloadCode = curl_getinfo($downloadCh, CURLINFO_HTTP_CODE);
            $downloadError = curl_error($downloadCh);

            curl_close($downloadCh);
            fclose($fileHandle);

            if ($downloadResult && $downloadCode === 200) {
                return true;
            } else {
                @unlink($localPath); // Удаляем частично скачанный файл
                return false;
            }

        } catch (Exception $e) {
            @unlink($localPath);
            return false;
        }
    }

    /**
     * Переименовывает файл на Яндекс.Диске
     */
    public function renameFile($oldPath, $newPath) {
        $url = $this->baseUrl . '/move?from=' . urlencode($oldPath) . '&path=' . urlencode($newPath) . '&overwrite=true';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: OAuth ' . $this->token,
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        return $httpCode === 201 || $httpCode === 200;
    }

    /**
     * Удаляет файл с Яндекс.Диска
     */
    public function deleteFile($remotePath) {
        $url = $this->baseUrl . '?path=' . urlencode($remotePath) . '&permanently=true';


        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Authorization: OAuth ' . $this->token
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);


        return $httpCode === 204 || $httpCode === 202; // 204 - удалено, 202 - принято в обработку
    }

    public function getPublicUrl($remotePath) {

        try {
            // Сначала получаем ссылку для скачивания
            $downloadUrl = $this->baseUrl . '/download?path=' . urlencode($remotePath);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $downloadUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: OAuth ' . $this->token,
                    'Accept: application/json'
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if (isset($data['href'])) {
                    return $data['href'];
                }
            }


            // Фолбэк: попробуем получить через публикацию
            return $this->getPublicUrlFallback($remotePath);

        } catch (Exception $e) {
            return $this->getPublicUrlFallback($remotePath);
        }
    }

    /**
     * Фолбэк метод через публикацию файла
     */
    private function getPublicUrlFallback($remotePath) {

        try {
            // Публикуем файл
            $publishUrl = $this->baseUrl . '/publish?path=' . urlencode($remotePath);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $publishUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_HTTPHEADER => [
                    'Authorization: OAuth ' . $this->token
                ],
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 || $httpCode === 202) {

                // Получаем информацию о файле
                $metaUrl = $this->baseUrl . '?path=' . urlencode($remotePath);

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $metaUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: OAuth ' . $this->token
                    ],
                    CURLOPT_TIMEOUT => 30
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200) {
                    $data = json_decode($response, true);
                    if (isset($data['public_url'])) {

                        // Преобразуем URL страницы в прямую ссылку на файл
                        return $this->convertToDirectLink($data['public_url']);
                    }
                }
            }

            return null;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Преобразует URL страницы Яндекс.Диска в прямую ссылку на файл
     */
    private function convertToDirectLink($pageUrl) {

        // Для ссылок вида https://yadi.sk/i/XXX извлекаем ID и формируем прямую ссылку
        if (preg_match('/yadi\.sk\/i\/([a-zA-Z0-9_-]+)/', $pageUrl, $matches)) {
            $fileId = $matches[1];
            $directUrl = "https://yadi.sk/d/{$fileId}";
            return $directUrl;
        }

        return $pageUrl;
    }

    public function getTemporaryDirectUrl($remotePath) {

        try {
            $url = $this->baseUrl . '/download?path=' . urlencode($remotePath);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: OAuth ' . $this->token,
                    'Accept: application/json'
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                if (isset($data['href'])) {
                    return $data['href'];
                }
            }

            return null;

        } catch (Exception $e) {
            return null;
        }
    }
}
?>