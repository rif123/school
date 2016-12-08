<?php

class model_menu extends CI_Model {

    public function insert($data) {
        $this->db->insert('menu', $data);
    }

    public function getAll() {
        $this->db->select('menu.menu_id, menu.detail, menu.controller, menu.icon, menu_type.detail as "menu_type_detail", permission.detail as "permission_detail"')
                ->join('permission', 'permission.permission_id = menu.permission_id')
                ->join('menu_type', 'menu_type.menu_type_id = menu.menu_type_id')
                ->from('menu');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getById($id) {
        $this->db->select('menu.menu_id, menu.detail, menu.controller, menu.icon, menu_type.menu_type_id, permission.permission_id')
                ->join('permission', 'permission.permission_id = menu.permission_id')
                ->join('menu_type', 'menu_type.menu_type_id = menu.menu_type_id')
                ->from('menu')
                ->where('menu_id', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    } 
    
    public function getByIdType($id, $type) {
        $query = $this->db->query('SELECT MENU.* FROM MENU JOIN PERMISSION ON MENU.PERMISSION_ID = PERMISSION.PERMISSION_ID JOIN STAFF ON STAFF.PERMISSION_ID = PERMISSION.PERMISSION_ID JOIN MENU_TYPE ON MENU.MENU_TYPE_ID = MENU_TYPE.MENU_TYPE_ID  WHERE STAFF.STAFF_ID="'.$id.'" AND MENU_TYPE.DETAIL="'.$type.'"');
        return $query->result();
    } 
        
    public function edit($id, $data) {
        $this->db->where('menu_id', $id);
        $this->db->update('menu', $data);
    }
    
    public function delete($id) {
        $this->db->where('menu_id', $id);
        $this->db->delete('menu');
    }
}

?>