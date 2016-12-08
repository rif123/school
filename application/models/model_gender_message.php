<?php

class model_gender_message extends CI_Model {

    public function insert($data) {
        $this->db->insert('gender_message', $data);
    }

    public function getAll() {
        $this->db->select('gender_message.gender_message_id, gender_message.detail as "gender_message_detail", gender.detail as "gender_detail", language.detail as "language_detail"')
                ->from('gender_message')
                ->join('gender', 'gender.gender_id = gender_message.gender_id')
                ->join('language', 'language.language_id = gender_message.language_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('gender_message.gender_message_id, gender_message.detail, gender.gender_id, language.language_id')
                ->from('gender_message')
                ->join('gender', 'gender.gender_id = gender_message.gender_id')
                ->join('language', 'language.language_id = gender_message.language_id')
                ->where('gender_message_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('gender_message_id', $id);
        $this->db->update('gender_message', $data);
    }
    
    public function delete($id) {
        $this->db->where('gender_message_id', $id);
        $this->db->delete('gender_message');
    }
}

?>