<?php

class model_gender extends CI_Model {

    public function insert($data) {
        $this->db->insert('gender', $data);
    }

    public function getAll() {
        $this->db->select('gender_id, detail')
                ->from('gender');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('gender_id, detail')
                ->from('gender')
                ->where('gender_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('gender_id', $id);
        $this->db->update('gender', $data);
    }
    
    public function delete($id) {
        $this->db->where('gender_id', $id);
        $this->db->delete('gender');
    }
}

?>