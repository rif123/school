<?php

class model_history_message extends CI_Model {

    public function insert($data) {
        $this->db->insert('history_message', $data);
    }

    public function getAll() {
        $this->db->select('history_message.history_message_id, history_message.detail as "history_message_detail", history_type.detail as "history_detail", language.detail as "language_detail"')
                ->from('history_message')
                ->join('history_type', 'history_type.history_type_id = history_message.history_type_id')
                ->join('language', 'language.language_id = history_message.language_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('history_message.history_message_id, history_message.detail, history_type.history_type_id, language.language_id')
                ->from('history_message')
                ->join('history_type', 'history_type.history_type_id = history_message.history_type_id')
                ->join('language', 'language.language_id = history_message.language_id')
                ->where('history_message_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
  
    public function edit($id, $data) {
        $this->db->where('history_message_id', $id);
        $this->db->update('history_message', $data);
    }
    
    public function delete($id) {
        $this->db->where('history_message_id', $id);
        $this->db->delete('history_message');
    }
}

?>