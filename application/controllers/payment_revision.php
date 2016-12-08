<?php
    
class Payment_revision extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $data = array(
                'student_id' => $this->input->post('student_id'),                                 
                'payment_type_id' => $this->input->post('payment_type_id')                                 
            );            
            $this->load->view("view_payment_revision", $data);
        }      
            
    }   
    
    public function init() {        
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'payment_id' => $this->input->post('payment_id'),            
            'payment_date' => date("Y-m-d H:i:s"),
            'total' => $this->input->post('total'),            
            'payment_type_id' => $this->input->post('payment_type_id'),                                                   
            'student_id' => $this->input->post('student_id')                                 
        );
        return $data;
    }
    
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_payment->insert($data);                        
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }  
}
    
?>