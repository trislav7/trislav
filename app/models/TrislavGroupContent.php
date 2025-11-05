<?php
class TrislavGroupContent extends Model {
    protected $table = 'trislav_group_content';

    public function getByType($type) {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE type = ? AND is_active = 1 
            ORDER BY order_index
        ", [$type]);
    }

    public function getAllByType($type) {
        return $this->db->fetchAll("
            SELECT * FROM {$this->table} 
            WHERE type = ? 
            ORDER BY order_index, id DESC
        ", [$type]);
    }

    public function getSlides() {
        return $this->getByType('slide');
    }

    public function getReviews() {
        return $this->getByType('review');
    }

    public function getAdvantages() {
        return $this->getByType('advantage');
    }

    public function getClients() {
        return $this->getByType('client');
    }

    public function getProjects() {
        return $this->getByType('project');
    }

    public function toggleStatus($id) {
        $current = $this->find($id);
        $newStatus = $current['is_active'] ? 0 : 1;

        return $this->update($id, ['is_active' => $newStatus]);
    }

    public function updateOrder($id, $orderIndex) {
        return $this->update($id, ['order_index' => $orderIndex]);
    }
}
?>