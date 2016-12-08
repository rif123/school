<?php

class model_payment_type extends CI_Model {

    public function insert($data) {
        $this->db->insert('payment_type', $data);
    }

    public function getAll() {
        $query = $this->db->query('SELECT payment_type.*, period.detail as "period", education.detail as "education", case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type join period on payment_type.period_id = period.period_id join education on payment_type.education_id = education.education_id');
        return $query->result();
    }
    
    public function getAllGrouped() {
        $query = $this->db->query('SELECT payment_type.*, period.detail as "period", education.detail as "education", case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type join period on payment_type.period_id = period.period_id join education on payment_type.education_id = education.education_id group by payment_type.detail');
        return $query->result();
    }
    
    public function getByStatus($status) {
        $query = $this->db->query('SELECT *, case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type where status="'.$status.'"');
        return $query->result();
    }
    
    public function getByStatusEducationPeriod($status, $education_id, $period_id) {
        $query = $this->db->query('SELECT *, case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type where status="'.$status.'" and education_id="'.$education_id.'" and period_id="'.$period_id.'"');
        return $query->result();
    }
    
    public function getById($id) {        
        $query = $this->db->query('SELECT payment_type.*, case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type join period on payment_type.period_id = period.period_id where payment_type_id="'.$id.'"');
        return $query->row();
    } 
    
    public function getByEducationStatus($id, $status) {        
        $query = $this->db->query('SELECT payment_type.*, case when status = "1" then "Primary" else "Other" end as "payment_status" from payment_type join period on payment_type.period_id = period.period_id where education_id="'.$id.'" and status="'.$status.'"');
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('payment_type_id', $id);
        $this->db->update('payment_type', $data);
    }
    
    public function delete($id) {
        $this->db->where('payment_type_id', $id);
        $this->db->delete('payment_type');
    }
}

?>