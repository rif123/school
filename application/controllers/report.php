<?php
    
class Report extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_report");
        }      
    } 
        
    public function resources(){
//        $data = array(
//            'columnDefs' => 
//            'data' => array()
//        );
        $data = array();
        $columnDefs = array(
                array(
                    "title" => "No", 
                    "targets" => 0 
                ),
                array(
                    "title" => "Education", 
                    "targets" => 1 
                ),
                array(
                    "title" => "NIS", 
                    "targets" => 2
                ),
                array(
                    "title" => "Nama", 
                    "targets" => 3
                )
            );
                
        try {    
            if ($qE = $this->model_education->getOne()) {                  
                if ($qPT = $this->model_payment_type->getByEducationStatus($qE->education_id, 1)) {                
                    $i = 4;
                    foreach ($qPT as $r) {                                  
                        $t = array(
                            "title" => $r->detail, 
                            "targets" => $i
                        );
                        array_push($columnDefs, $t);
                        $i++;
                    }
                    $t = array(
                        "title" => "Total", 
                        "targets" => $i++
                    );
                    array_push($columnDefs, $t);
                        
                }                                                
            }  
            $data = array(
                'columnDefs' => $columnDefs,
                'data' => array()
            );
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }   
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getOther(){
        $data = array();
        try {    
         
            if ($q = $this->model_payment->getOther()) {  
                $first = array();
                foreach ($q as $r) {                                                         
                    array_push($first, $r);                                                            
                }
                $data = array(
                    'data' => $first
                );
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