<?php
// app/controllers/admin/AdminSettingsController.php
class AdminSettingsController extends AdminBaseController {

    public function index() {
        $settingModel = new SiteSetting();

        if ($_POST) {
            // Обрабатываем основные настройки
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'setting_') === 0) {
                    $settingKey = str_replace('setting_', '', $key);
                    $settingModel->updateByKey($settingKey, $value);
                }
            }

            // Обрабатываем преимущества
            if (isset($_POST['advantages']) && is_array($_POST['advantages'])) {
                $advantageModel = new TrislavGroupAdvantage();
                foreach ($_POST['advantages'] as $id => $advantageData) {
                    if (!empty($advantageData['title'])) {
                        $data = [
                            'title' => $advantageData['title'],
                            'description' => $advantageData['description'] ?? '',
                            'icon_class' => $advantageData['icon_class'] ?? '',
                            'order_index' => $advantageData['order_index'] ?? 0,
                            'is_active' => isset($advantageData['is_active']) ? 1 : 0
                        ];
                        $advantageModel->update($id, $data);
                    }
                }
            }

            $this->setFlashMessage('success', 'Настройки успешно обновлены');
            $this->redirect('/admin.php?action=settings');
        }

        $settingModel = new SiteSetting();
        $advantageModel = new TrislavGroupAdvantage();

        $data = [
            'settings' => $settingModel->getAllSettings(),
            'title' => 'Настройки сайта',
            'current_action' => 'settings'
        ];

        $this->view('admin/settings', $data);
    }
}
?>