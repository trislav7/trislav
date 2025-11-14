<?php
class RecaptchaValidator {
    private $secretKey;
    private $scoreThreshold;
    
    public function __construct() {
        $config = require ROOT_PATH . '/config/recaptcha.php';
        $this->secretKey = IS_TRISLAV_MEDIA ? $config['secret_key'] : $config['trislav_secret_key'];
        $this->scoreThreshold = $config['score_threshold'];
    }

    public function validate($recaptchaToken) {
        if (empty($recaptchaToken)) {
            
            return false;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $this->secretKey,
            'response' => $recaptchaToken,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);

        // Детальное логирование для отладки
        
        

        if (isset($result['score'])) {
            
        }

        if (isset($result['error-codes'])) {
            
        }

        // Упрощенная валидация - только success и score
        return $result['success'] &&
            isset($result['score']) &&
            $result['score'] >= $this->scoreThreshold;
        // Убрали проверку action: && $result['action'] === 'submit'
    }
}
?>