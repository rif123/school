<?php
    
class Payment_print extends CI_Controller {
    
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
            $this->load->view("view_payment_print", $data);
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
        
    public function print_report() {        
        $data = array('data' => array());
        $payment_id = $this->input->POST('payment_id');        
        try {                                        
            if ($query = $this->model_payment->getReportById($payment_id)) {                                
                $data = array(
                    'payment_id' => $query->payment_id,                                 
                    'name' => $query->name,
                    'payment_total' => $query->payment_total,
                    'payment_type_detail' => $query->payment_type_detail,
                    'payment_date_extracted' => 'Bandung, '.$query->payment_date_extracted
                );             
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }                                    
        $this->load->view("view_payment_print_report", $data); 
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