<?php
class ContactController extends Controller {
    public function submit() {
        if ($_POST) {
            try {
                $leadModel = new Lead();
                $leadModel->create([
                    'name' => $_POST['name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'company' => $_POST['company'] ?? '',
                    'service_type' => $_POST['service_type'] ?? 'general',
                    'budget' => $_POST['budget'] ?? '',
                    'message' => $_POST['message'] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

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