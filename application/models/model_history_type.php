<?php

class model_history_type extends CI_Model {

    public function insert($data) {
        $this->db->insert('history_type', $data);
    }

    public function getAll() {
        $this->db->select('history_type_id, detail')
                ->from('history_type');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('history_type_id, detail')
                ->from('history_type')
                ->where('history_type_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('history_type_id', $id);
        $this->db->update('history_type', $data);
    }
    
    public function delete($id) {
        $this->db->where('history_type_id', $id);
        $this->db->delete('history_type');
    }
}

?>