<?php

class model_period extends CI_Model {

    public function insert($data) {
        $this->db->insert('period', $data);
    }

    public function getAll() {
        $this->db->select('period_id, detail')
                ->from('period');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('period_id, detail')
                ->from('period')
                ->where('period_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('period_id', $id);
        $this->db->update('period', $data);
    }
    
    public function delete($id) {
        $this->db->where('period_id', $id);
        $this->db->delete('period');
    }
}

?>