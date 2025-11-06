<?php
class AdminLeadsController extends AdminBaseController {


    public function list() {
        $leadModel = new Lead();

        // Получаем выбранный фильтр
        $filter = $_GET['filter'] ?? 'all';

        // Получаем лиды
        if ($filter === 'all') {
            $leads = $leadModel->getAll();
        } else {
            $leads = $leadModel->getByServiceType($filter);
        }

        $this->view('admin/leads_list', [
            'leads' => $leads,
            'current_filter' => $filter,
            'title' => 'Управление заявками'
        ]);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin.php?action=leads_list');
            exit;
        }

        $leadModel = new Lead();
        $lead = $leadModel->find($id);

        $tariff = null;
        if (!empty($lead['tariff_id'])) {
            $tariffModel = new Tariff();
            $tariff = $tariffModel->find($lead['tariff_id']);
        }

        $this->view('admin/leads_detail', [
            'title' => 'Детали заявки #' . $lead['id'],
            'lead' => $lead,
            'tariff' => $tariff
        ]);
    }

    public function process() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $leadModel = new Lead();
            $leadModel->markAsProcessed($id);
        }

        header('Location: /admin.php?action=leads_list&success=1');
        exit;
    }

    public function getServiceTypeLabel($serviceType) {
        $labels = [
            'trislav_group_general' => 'Трислав Групп',
            'led' => 'LED Экраны',
            'btl' => 'BTL Мероприятия',
            'video' => 'Видео и Лого',
            'general' => 'Трислав Медиа (главная)'
        ];

        return $labels[$serviceType] ?? $serviceType;
    }
}