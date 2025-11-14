<?php
trait FormHandlerTrait {
    protected function handleFormSubmission($serviceType, $additionalData = []) {
        if (!$_POST) {
            return $this->sendErrorResponse('Неверные данные');
        }
        
        try {
            // Валидация reCAPTCHA
            $recaptchaValidator = new RecaptchaValidator();
            $recaptchaToken = $_POST['recaptcha_token'] ?? '';
            
            if (!$recaptchaValidator->validate($recaptchaToken)) {
                debug_log("reCAPTCHA validation failed for: $serviceType");
                return $this->sendErrorResponse('Проверка безопасности не пройдена');
            }
            
            $leadModel = new Lead();
            $data = array_merge([
                'name' => $_POST['name'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'company' => $_POST['company'] ?? '',
                'service_type' => $serviceType,
                'budget' => $_POST['budget'] ?? '',
                'message' => $_POST['message'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'tariff_id' => $_POST['tariff_id'] ?? null,
                'service_id' => $_POST['service_id'] ?? null,
            ], $additionalData);
            
            $leadId = $leadModel->create($data);
            debug_log("Lead created successfully: $leadId for $serviceType");
            
            return $this->sendSuccessResponse('Заявка успешно отправлена');
            
        } catch (Exception $e) {
            debug_log("Form submission error for $serviceType: " . $e->getMessage());
            return $this->sendErrorResponse('Ошибка при отправке заявки');
        }
    }
    
    private function sendSuccessResponse($message) {
        header('HTTP/1.1 200 OK');
        echo json_encode(['success' => true, 'message' => $message]);
        exit;
    }
    
    private function sendErrorResponse($message) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => $message]);
        exit;
    }
}