<?php

class model_language extends CI_Model {

    public function insert($data) {
        $this->db->insert('language', $data);
    }

    public function getAll() {
        $this->db->select('language_id, detail')
                ->from('language');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {       
        $this->db->select('language_id, detail')
                ->from('language')
                ->where('language_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('language_id', $id);
        $this->db->update('language', $data);
    }
    
    public function delete($id) {
        $this->db->where('language_id', $id);
        $this->db->delete('language');
    }
}

?>