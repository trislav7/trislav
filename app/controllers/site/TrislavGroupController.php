<?php
// app/controllers/site/TrislavGroupController.php
class TrislavGroupController extends Controller {
    
    public function index() {
        $this->view('site/trislav_group', [
            'title' => 'Трислав Групп | Развитие бизнеса через креативные решения'
        ]);
    }
    
    public function contactSubmit() {
        // Обработка формы обратной связи для Трислав Групп
        if ($_POST) {
            try {
                $leadModel = new Lead();
                
                $data = [
                    'name' => $_POST['name'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'company' => $_POST['company'] ?? '',
                    'service_type' => 'trislav_group_general',
                    'message' => $_POST['message'] ?? '',
                    'status' => 'new',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $leadId = $leadModel->create($data);
                
                // Редирект с сообщением об успехе
                header('Location: /?success=1');
                exit;
                
            } catch (Exception $e) {
                // В случае ошибки редирект с сообщением об ошибке
                header('Location: /?error=1');
                exit;
            }
        }
        
        // Если не POST запрос, редирект на главную
        header('Location: /');
        exit;
    }
}
?>