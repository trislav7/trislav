<?php
class AdminVideoScheduleController extends AdminBaseController {

    public function index() {
        $shoppingCenterModel = new ShoppingCenter();
        $videoScheduleModel = new VideoSchedule();

        $shoppingCenters = $shoppingCenterModel->getAllActive();
        $selectedCenter = $_GET['center_id'] ?? ($shoppingCenters[0]['id'] ?? null);

        $currentSchedule = [];
        $generatedSchedule = [];

        if ($selectedCenter) {
            // Генерируем сетку для предпросмотра
            $generatedSchedule = $videoScheduleModel->generateScheduleBlock($selectedCenter);
        }

        $this->view('admin/video_schedule', [
            'title' => 'Управление рекламной сеткой LED экранов',
            'shopping_centers' => $shoppingCenters,
            'selected_center' => $selectedCenter,
            'current_schedule' => $currentSchedule,
            'generated_schedule' => $generatedSchedule,
            'current_action' => 'video_schedule'
        ]);
    }
}
?>