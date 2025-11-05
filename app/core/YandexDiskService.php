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
}
?>