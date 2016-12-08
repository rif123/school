<?php
    
class Payment extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $data = array(
                'student_id' => $this->input->post('student_id')                                 
            );
            $this->load->view("view_payment", $data);
        }      
            
    }   
        
    public function init() {        
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'payment_id' => $this->input->post('payment_id'),            
            // 'payment_date' => date("Y-m-d H:i:s"),
            'payment_date' => !empty($this->input->post('payment_date')) ? $this->input->post('payment_date') : date("Y-m-d H:i:s"),
            'total' => $this->input->post('total'),            
            'payment_group' => $this->input->post('payment_group'),     
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
    
    public function edit() {
        try {            
            $data = $this->init();
            $this->model_payment->edit($data['payment_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function getById() {
        $data = array('data' => array());
        $payment_id = $this->input->POST('payment_id');        
        try {                                        
            if ($query = $this->model_payment->getById($payment_id)) {                                
                $data = array('data' => $query);               
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getSelectedPayment() {
        $data = array('data' => array());
        $student_id = $this->input->GET('student_id');
        $payment_type_id = $this->input->GET('payment_type_id');
            
        try {                                        
            if ($query = $this->model_payment->getSelectedPayment($student_id, $payment_type_id)) {                                
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
}
    
?>