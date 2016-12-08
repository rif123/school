<?php

class Menu_type extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_menu_type");
        }                 
    }   
    
    public function init() {
        $data = array(
            'menu_type_id' => $this->input->post('menu_type_id'),
            'detail' => $this->input->post('detail')            
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_menu_type->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
            
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_menu_type->getAll()) {
                $first_sub = array();
                foreach ($query as $r) {   
                    array_push($first_sub, $r);
                }
                $data = array('data' => $first_sub);
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }  
    
    public function getById() {
        $data = array('data' => array());
        $id = $this->input->post('menu_type_id');        
        try {                                                                
            if ($r = $this->model_menu_type->getById($id)) {                
                $data = array('data' => $r);
            } 
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
    
    public function edit() {
        try {            
            $data = $this->init();
            $this->model_menu_type->edit($data['menu_type_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_menu_type->delete($this->input->post('menu_type_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}

?>