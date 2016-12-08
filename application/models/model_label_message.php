<?php

class model_label_message extends CI_Model {

    public function insert($data) {
        $this->db->insert('label_message', $data);
    }

    public function getAll() {
//        label_message.label_message_id, label_message.detail as "label_message_detail", label.detail as "label_detail", language.detail as "language_detail"
        $this->db->select('label_message.label_message_id, label_message.detail as "label_message_detail", label.detail as "label_detail", language.detail as "language_detail"')
                ->from('label_message')
                ->join('label', 'label.label_id = label_message.label_id')
                ->join('language', 'language.language_id = label_message.language_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('label_message.label_message_id, label_message.detail, label.label_id, language.language_id')
                ->from('label_message')
                ->join('label', 'label.label_id = label_message.label_id')
                ->join('language', 'language.language_id = label_message.language_id')
                ->where('label_message_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('label_message_id', $id);
        $this->db->update('label_message', $data);
    }
    
    public function delete($id) {
        $this->db->where('label_message_id', $id);
        $this->db->delete('label_message');
    }
}

?>