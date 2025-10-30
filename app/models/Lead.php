<?php
class Lead extends Model {
    protected $table = 'leads';

    public function getNewLeads() {
        return $this->db->fetchAll("
            SELECT * FROM leads 
            WHERE status = 'new' 
            ORDER BY created_at DESC
        ");
    }

    public function markAsProcessed($id) {
        return $this->db->query(
            "UPDATE leads SET status = 'processed' WHERE id = ?",
            [$id]
        );
    }
}