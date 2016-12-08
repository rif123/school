<?php

class model_staff extends CI_Model {

    public function insert($data) {
        $this->db->insert('staff', $data);
    }

    public function getAll() {
        $this->db->select('staff.staff_id, staff.nip, staff.name, gender.detail as "gender_detail", language.detail as "language_detail", permission.detail as "permission_detail"')
                ->from('staff')
                ->join('gender', 'gender.gender_id = staff.gender_id')
                ->join('language', 'language.language_id = staff.language_id')
                ->join('permission', 'permission.permission_id = staff.permission_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getAllUser() {
        $this->db->select('staff.staff_id, staff.nip, staff.password, staff.name, gender.detail as "gender_detail", language.detail as "language_detail", permission.detail as "permission_detail"')
                ->from('staff')
                ->join('gender', 'gender.gender_id = staff.gender_id')
                ->join('language', 'language.language_id = staff.language_id')
                ->join('permission', 'permission.permission_id = staff.permission_id')
                ->where('permission.status', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getAvailableUsername($username) {
        $this->db->select('*')
                ->from('staff')
                ->where('username', $username);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getById($id) {       
        $this->db->select('staff.staff_id, staff.nip, staff.name, staff.photo, staff.born_date, gender.gender_id, language.language_id, permission.permission_id, staff.address, staff.photo, staff.username')
                ->from('staff')
                ->join('gender', 'gender.gender_id = staff.gender_id')
                ->join('language', 'language.language_id = staff.language_id')
                ->join('permission', 'permission.permission_id = staff.permission_id')
                ->where('staff.staff_id', $id);
//                ->limit(1);
        $query = $this->db->get();
        return $query->row();
    } 
    
    public function getByNip($id) {       
        $this->db->select('staff.staff_id, staff.nip, staff.name, staff.photo, staff.born_date, gender.gender_id, language.language_id, permission.permission_id, staff.address')
                ->from('staff')
                ->join('gender', 'gender.gender_id = staff.gender_id')
                ->join('language', 'language.language_id = staff.language_id')
                ->join('permission', 'permission.permission_id = staff.permission_id')
                ->where('staff.nip', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getLogin($username, $password) {       
        $this->db->select('staff.staff_id, staff.nip, staff.name, staff.photo, staff.born_date, gender.gender_id, language.language_id, permission.permission_id, staff.address, staff.password')
                ->from('staff')
                ->join('gender', 'gender.gender_id = staff.gender_id')
                ->join('language', 'language.language_id = staff.language_id')
                ->join('permission', 'permission.permission_id = staff.permission_id')
                ->where('staff.username', $username)
                ->where('staff.password', $password)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updatePhotoProfil($id, $src) {
        $this->db->set("photo", $src);
        $this->db->where('staff_id', $id);
        $this->db->update('staff');
    }
  
    public function edit($id, $data) {
        $this->db->where('staff_id', $id);
        $this->db->update('staff', $data);
    }
    
    public function delete($id) {
        $this->db->where('staff_id', $id);
        $this->db->delete('staff');
    }
}

?>