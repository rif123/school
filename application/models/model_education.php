<?php

class model_education extends CI_Model {

    public function insert($data) {
        $this->db->insert('education', $data);
    }

    public function getAll() {
        $this->db->select('education_id, detail')
                ->from('education');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllNew() {
       $q = 'SELECT SUBSTR(detail, LOCATE(" ", detail)+1, LENGTH(detail )) AS nameEdu FROM education GROUP BY nameEdu';
       $query  = $this->db->query($q);
        return $query->result();
    }

    public function getOne() {
        $this->db->select('education_id, detail')
                ->from('education');
        $query = $this->db->get();
        return $query->row();
    }

    public function getById($id) {
        $this->db->select('education_id, detail')
                ->from('education')
                ->where('education_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function edit($id, $data) {
        $this->db->where('education_id', $id);
        $this->db->update('education', $data);
    }

    public function delete($id) {
        $this->db->where('education_id', $id);
        $this->db->delete('education');
    }
}

?>
