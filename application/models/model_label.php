<?php

class model_label extends CI_Model {

    public function insert($data) {
        $this->db->insert('label', $data);
    }

    public function getAll() {
        $this->db->select('label_id, detail')
                ->from('label');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('label_id, detail')
                ->from('label')
                ->where('label_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('label_id', $id);
        $this->db->update('label', $data);
    }
    
    public function delete($id) {
        $this->db->where('label_id', $id);
        $this->db->delete('label');
    }
}

?>