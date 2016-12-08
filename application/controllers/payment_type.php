<?php
    
class Payment_type extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_payment_type");
        }                 
    }   
        
    public function init() {
        $data = array(
            'payment_type_id' => $this->input->post('payment_type_id'),
            'detail' => $this->input->post('detail'),
            'month' => $this->input->post('month'),            
            'total' => $this->input->post('total'),
            'status' => $this->input->post('status'),
            'finish_date' => $this->input->post('finish_date'),
            'period_id' => $this->input->post('period_id'),
            'education_id' => $this->input->post('education_id')
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_payment_type->insert($data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_payment_type->getAll()) {
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
    
    public function getAllGrouped() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_payment_type->getAllGrouped()) {
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
        $id = $this->input->post('payment_type_id');        
        try {                                                                
            if ($r = $this->model_payment_type->getById($id)) {                
                $data = array('data' => $r);
            } 
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getByStatus() {
        $data = array('data' => array());
        $status = $this->input->post('status');        
        try {                                                                
            if ($r = $this->model_payment_type->getByStatus($status)) {                
                $data = array('data' => $r);
            } 
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getByStatusEducationPeriod(){
        $data = array('data' => array());
        $status = $this->input->post('status');        
        $education_id = $this->input->post('education_id');        
        $period_id = $this->input->post('period_id');        
//        echo $status."<br/>";
//        echo $education_id."<br/>";
//        echo $period_id."<br/>";
        try {                                                                
            if ($r = $this->model_payment_type->getByStatusEducationPeriod($status, $education_id, $period_id)) {                
                $data = array('data' => $r);
            } 
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }    
        
    public function getMinMaxValidate() {
        $valid   = true;
        $message = '';
        $total_payment = $this->input->get('total_payment');
        try {                                                                
            if ($query = $this->model_payment_type->getByStatus(1)) {                
                $total = 0;
                foreach ($query as $r) {                    
                    $total += $r->total;
                } 
                    
                if(($total_payment > $total) || ($total_payment < 0)){
                    $valid   = false;
                    $message = 'Input out of the range (0 to '.$total.')';
                }                    
            } 
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }             
        header("content-type: application/json");
        echo json_encode(
                $valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $message)
        );
        exit;
    }
        
    public function getMinMaxValidate2() {
        $valid   = true;
        $message = '';
        $total_payment = $this->input->post('total_payment');
        $status = $this->input->post('status');        
        $education_id = $this->input->post('education_id');        
        $period_id = $this->input->post('period_id');           
        try {   
            $total = 0;
            if ($query = $this->model_payment_type->getByStatusEducationPeriod($status, $education_id, $period_id)) {                
                
                foreach ($query as $r) {                    
                    $total += $r->total;
                } 
                    
            }
            if(($total_payment > $total) || ($total_payment < 0)){
                $valid   = false;
                $message = 'Input out of the range (0 to '.$total.')';
            }                    
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }             
        header("content-type: application/json");
        echo json_encode(
                $valid ? array('valid' => $valid) : array('valid' => $valid, 'message' => $message)
        );
        exit;
    }
        
    public function edit() {
        try {            
            $data = $this->init();
            $this->model_payment_type->edit($data['payment_type_id'], $data);            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
        
    public function delete() {
        try {                        
            $this->model_payment_type->delete($this->input->post('payment_type_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>