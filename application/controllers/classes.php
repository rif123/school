<?php

class Classes extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_class");
        }         
    }   
    
    public function init() {
        $data = array(
            'class_id' => $this->input->post('class_id'),
            'detail' => $this->input->post('detail'),
            'capacity' => $this->input->post('capacity'),
            'education_id' => $this->input->post('education_id')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_classes->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
            
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_classes->getAll()) {
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
        $id = $this->input->post('class_id');
        try {                                        
            if ($query = $this->model_classes->getById($id)) {                
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
            $this->model_classes->edit($data['class_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_classes->delete($this->input->post('class_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}

?>