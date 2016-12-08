<?php
    
class Label_message extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_label_message");
        }                      
    }   
        
    public function init() {
        $data = array(
            'label_message_id' => $this->input->post('label_message_id'),
            'detail' => $this->input->post('detail'),
            'language_id' => $this->input->post('language_id'),
            'label_id' => $this->input->post('label_id')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_label_message->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_label_message->getAll()) {
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
        $id = $this->input->post('label_message_id');
        try {                                        
            if ($query = $this->model_label_message->getById($id)) {                
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
            $this->model_label_message->edit($data['label_message_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function delete() {
        try {                        
            $this->model_label_message->delete($this->input->post('label_message_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>