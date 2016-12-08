<?php
    
class Permission extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_permission");
        }                        
    }   
        
    public function init() {
        $data = array(
            'permission_id' => $this->input->post('permission_id'),
            'detail' => $this->input->post('detail'),
            'status' => $this->input->post('status')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_permission->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_permission->getAll()) {
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
    
    public function getAllUser() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_permission->getAllUser()) {
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
        $id = $this->input->post('permission_id');
        try {                                        
            if ($query = $this->model_permission->getById($id)) {                
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
    
    public function edit() {
        try {            
            $data = $this->init();
            $this->model_permission->edit($data['permission_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_permission->delete($this->input->post('permission_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>