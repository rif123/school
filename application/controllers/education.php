<?php
    
class Education extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_education");
        }                        
    }   
        
    public function init() {
        $data = array(
            'education_id' => $this->input->post('education_id'),
            'detail' => $this->input->post('detail')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_education->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_education->getAll()) {
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
    public function getAllNew() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_education->getAllNew()) {
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
        $id = $this->input->post('education_id');
        try {                                        
            if ($query = $this->model_education->getById($id)) {                
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
            $this->model_education->edit($data['education_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_education->delete($this->input->post('education_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>