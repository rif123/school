<?php

class model_menu_type extends CI_Model {

    public function insert($data) {
        $this->db->insert('menu_type', $data);
    }

    public function getAll() {
        $query = $this->db->query('SELECT * from menu_type');
        return $query->result();
    }
    
    public function getById($id) {        
        $query = $this->db->query('SELECT * from menu_type where menu_type_id="'.$id.'"');
        return $query->row();
    } 
  
    public function edit($id, $data) {
        $this->db->where('menu_type_id', $id);
        $this->db->update('menu_type', $data);
    }
    
    public function delete($id) {
        $this->db->where('menu_type_id', $id);
        $this->db->delete('menu_type');
    }
}

?>