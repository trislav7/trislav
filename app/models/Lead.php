<?php
class Lead extends Model {
    protected $table = 'leads';

    public function getNewLeads() {
        return $this->db->fetchAll("
            SELECT l.*, 
                   p.title as project_title, 
                   s.title as service_title 
            FROM leads l 
            LEFT JOIN trislav_group_projects p ON l.project_id = p.id 
            LEFT JOIN services s ON l.service_id = s.id 
            WHERE l.status = 'new' 
            ORDER BY l.created_at DESC
        ");
    }

    public function getAll() {
        return $this->db->fetchAll("
            SELECT l.*, 
                   p.title as project_title, 
                   s.title as service_title 
            FROM leads l 
            LEFT JOIN trislav_group_projects p ON l.project_id = p.id 
            LEFT JOIN services s ON l.service_id = s.id 
            ORDER BY l.created_at DESC
        ");
    }

    public function findWithDetails($id) {
        return $this->db->fetch("
            SELECT l.*, 
                   p.title as project_title,
                   p.id as project_id,
                   s.title as service_title,
                   s.id as service_id
            FROM leads l 
            LEFT JOIN trislav_group_projects p ON l.project_id = p.id 
            LEFT JOIN services s ON l.service_id = s.id 
            WHERE l.id = ?
        ", [$id]);
    }

    public function getLeadServices($leadId) {
        return $this->db->fetchAll("
            SELECT s.* 
            FROM lead_services ls 
            JOIN services s ON ls.service_id = s.id 
            WHERE ls.lead_id = ?
        ", [$leadId]);
    }

    public function addLeadService($leadId, $serviceId) {
        return $this->db->query(
            "INSERT INTO lead_services (lead_id, service_id) VALUES (?, ?)",
            [$leadId, $serviceId]
        );
    }

    public function removeLeadServices($leadId) {
        return $this->db->query(
            "DELETE FROM lead_services WHERE lead_id = ?",
            [$leadId]
        );
    }

    public function markAsProcessed($id) {
        return $this->db->query(
            "UPDATE leads SET status = 'processed' WHERE id = ?",
            [$id]
        );
    }
}
?>