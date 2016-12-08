<?php

class model_permission extends CI_Model {

    public function insert($data) {
        $this->db->insert('permission', $data);
    }

    public function getAll() {
        $query = $this->db->query('SELECT permission_id, detail, case when status = "1" then "Developer" else "User" end as "permission_status" from permission');        
        return $query->result();
    }
    
    public function getAllUser() {
        $query = $this->db->query('SELECT permission_id, detail, case when status = "1" then "Developer" else "User" end as "permission_status" from permission WHERE status=0');        
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('permission_id, detail')
                ->from('permission')
                ->where('permission_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('permission_id', $id);
        $this->db->update('permission', $data);
    }
    
    public function delete($id) {
        $this->db->where('permission_id', $id);
        $this->db->delete('permission');
    }
}

?>