<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        
        // Настройки SMTP
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.yandex.ru'; // или ваш SMTP сервер
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'info@trislav.ru';
        $this->mail->Password = 'your_password_here'; // Заменить на реальный пароль
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->CharSet = 'UTF-8';
        
        // От кого
        $this->mail->setFrom('info@trislav.ru', 'Трислав Групп');
    }
    
    /**
     * Отправка письма с заявкой
     */
    public function sendLeadNotification($leadData) {
        try {
            // Кому
            $this->mail->addAddress('info@trislav.ru', 'Трислав Групп');
            
            // Тема
            $this->mail->Subject = 'Новая заявка с сайта Трислав';
            
            // HTML содержимое
            $this->mail->isHTML(true);
            $this->mail->Body = $this->buildLeadEmailBody($leadData);
            
            // Альтернативное текстовое содержимое
            $this->mail->AltBody = $this->buildLeadTextBody($leadData);
            
            // Отправка
            $this->mail->send();
            
            return true;
            
        } catch (Exception $e) {
            
            return false;
        }
    }
    
    /**
     * Создание HTML тела письма
     */
    private function buildLeadEmailBody($data) {
        $source = $data['source'] ?? 'general';
        $sourceNames = [
            'general' => 'Общая заявка',
            'led' => 'LED экраны',
            'video' => 'Видеопроизводство',
            'btl' => 'BTL мероприятия',
            'trislav_group' => 'Трислав Групп'
        ];
        
        $sourceName = $sourceNames[$source] ?? 'Неизвестный источник';
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1a1a2e; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #1a1a2e; }
                .value { color: #666; }
                .footer { background: #16213e; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Новая заявка с сайта</h1>
                    <p>Источник: <?= $sourceName ?></p>
                </div>
                
                <div class="content">
                    <div class="field">
                        <span class="label">Имя:</span>
                        <span class="value"><?= htmlspecialchars($data['name'] ?? 'Не указано') ?></span>
                    </div>
                    
                    <div class="field">
                        <span class="label">Телефон:</span>
                        <span class="value"><?= htmlspecialchars($data['phone'] ?? 'Не указан') ?></span>
                    </div>
                    
                    <?php if (!empty($data['email'])): ?>
                    <div class="field">
                        <span class="label">Email:</span>
                        <span class="value"><?= htmlspecialchars($data['email']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['company'])): ?>
                    <div class="field">
                        <span class="label">Компания:</span>
                        <span class="value"><?= htmlspecialchars($data['company']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['budget'])): ?>
                    <div class="field">
                        <span class="label">Бюджет:</span>
                        <span class="value"><?= htmlspecialchars($data['budget']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['message'])): ?>
                    <div class="field">
                        <span class="label">Сообщение:</span>
                        <div class="value"><?= nl2br(htmlspecialchars($data['message'])) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['project_title'])): ?>
                    <div class="field">
                        <span class="label">Интересующий проект:</span>
                        <span class="value"><?= htmlspecialchars($data['project_title']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['service_title'])): ?>
                    <div class="field">
                        <span class="label">Услуга:</span>
                        <span class="value"><?= htmlspecialchars($data['service_title']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="field">
                        <span class="label">Дата и время:</span>
                        <span class="value"><?= date('d.m.Y H:i:s') ?></span>
                    </div>
                </div>
                
                <div class="footer">
                    <p>Это письмо отправлено автоматически с сайта Трислав Групп</p>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Создание текстовой версии письма
     */
    private function buildLeadTextBody($data) {
        $source = $data['source'] ?? 'general';
        $sourceNames = [
            'general' => 'Общая заявка',
            'led' => 'LED экраны',
            'video' => 'Видеопроизводство',
            'btl' => 'BTL мероприятия',
            'trislav_group' => 'Трислав Групп'
        ];
        
        $sourceName = $sourceNames[$source] ?? 'Неизвестный источник';
        
        $text = "НОВАЯ ЗАЯВКА С САЙТА\n";
        $text .= "====================\n\n";
        $text .= "Источник: {$sourceName}\n";
        $text .= "Имя: " . ($data['name'] ?? 'Не указано') . "\n";
        $text .= "Телефон: " . ($data['phone'] ?? 'Не указан') . "\n";
        
        if (!empty($data['email'])) {
            $text .= "Email: " . $data['email'] . "\n";
        }
        
        if (!empty($data['company'])) {
            $text .= "Компания: " . $data['company'] . "\n";
        }
        
        if (!empty($data['budget'])) {
            $text .= "Бюджет: " . $data['budget'] . "\n";
        }
        
        if (!empty($data['message'])) {
            $text .= "Сообщение: " . $data['message'] . "\n";
        }
        
        if (!empty($data['project_title'])) {
            $text .= "Проект: " . $data['project_title'] . "\n";
        }
        
        if (!empty($data['service_title'])) {
            $text .= "Услуга: " . $data['service_title'] . "\n";
        }
        
        $text .= "\nДата: " . date('d.m.Y H:i:s');
        
        return $text;
    }
}
?>