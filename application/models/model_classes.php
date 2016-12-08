<?php

class model_classes extends CI_Model {

    public function insert($data) {
        $this->db->insert('class', $data);
    }

    public function getAll() {
        $this->db->select('class.class_id, class.detail, class.capacity, education.education_id, education.detail as "education_detail"')
                ->join('education', 'education.education_id = class.education_id')
                ->from('class');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('class_id, detail, capacity, education_id')
                ->from('class')
                ->where('class_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('class_id', $id);
        $this->db->update('class', $data);
    }
    
    public function delete($id) {
        $this->db->where('class_id', $id);
        $this->db->delete('class');
    }
}

?>