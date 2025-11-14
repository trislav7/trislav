<?php
class ContactController extends Controller {
    public function submit() {
        if ($_POST) {
            try {
                // ВАЛИДАЦИЯ reCAPTCHA
                $recaptchaValidator = new RecaptchaValidator();
                $recaptchaToken = $_POST['recaptcha_token'] ?? '';

                if (!$recaptchaValidator->validate($recaptchaToken)) {
                    
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['success' => false, 'message' => 'Проверка безопасности не пройдена']);
                    exit;
                }

                $leadModel = new Lead();

                // Подготавливаем данные
                $leadData = [
                    'name' => $_POST['name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'company' => $_POST['company'] ?? '',
                    'service_type' => $_POST['service_type'] ?? 'general',
                    'budget' => $_POST['budget'] ?? '',
                    'message' => $_POST['message'] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Добавляем информацию о проекте если есть
                if (!empty($_POST['project_id'])) {
                    $projectModel = new TrislavGroupProject();
                    $project = $projectModel->find($_POST['project_id']);
                    if ($project) {
                        $leadData['project_id'] = $project['id'];
                        $leadData['project_title'] = $project['title'];
                    }
                }

                // Создаем лид в БД
                $leadId = $leadModel->create($leadData);

                // Отправляем email уведомление
                $mailer = new Mailer();
                $emailSent = $mailer->sendLeadNotification($leadData);

                

                // Редирект с сообщением об успехе
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/') . '?success=1');
                exit;

            } catch (Exception $e) {
                
                // В случае ошибки просто редиректим обратно
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
                exit;
            }
        }

        header('Location: /');
        exit;
    }
}