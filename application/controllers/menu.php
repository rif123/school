<?php
    
class Menu extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_menu");
        }          
       
    }   
        
    public function init() {
        $data = array(
            'menu_id' => $this->input->post('menu_id'),
            'detail' => $this->input->post('detail'),
            'controller' => $this->input->post('controller'),
            'icon' => $this->input->post('icon'),
            'menu_type_id' => $this->input->post('menu_type_id'),
            'permission_id' => $this->input->post('permission_id')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_menu->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_menu->getAll()) {
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
        $id = $this->input->post('menu_id');
        try {                                        
            if ($query = $this->model_menu->getById($id)) {                
                foreach ($query as $r) {                    
                    $data = array('data' => $r);
                }                
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }        
    
    public function getByIdType() {
        $data = array('data' => array());
        $id = $id_user = $this->session->userdata('staff')->staff_id;
        try {                                        
            if ($query = $this->model_menu->getByIdType($id, $this->input->post('detail'))) {                
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
    
    public function edit() {
        try {            
            $data = $this->init();
            $this->model_menu->edit($data['menu_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_menu->delete($this->input->post('menu_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>