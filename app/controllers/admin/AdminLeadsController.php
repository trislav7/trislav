<?php
class AdminLeadsController extends AdminBaseController {
    
    public function list() {
        $leadModel = new Lead();
        $leads = $leadModel->getAll();

        $this->view('admin/leads_list', [
            'leads' => $leads,
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

        $this->view('admin/leads_detail', [
            'lead' => $lead,
            'title' => 'Заявка #' . $lead['id']
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
}