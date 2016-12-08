<?php
    
class Student extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_student");
        }         
    }     
        
     public function init() {        
        $data = array(
            'student_id' => $this->input->post('student_id'),            
            'nis' => $this->input->post('nis'),
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'), 
            'born_date' => $this->input->post('born_date'),
            'photo' => 'assets/dist/img/default.png',                                         
            'class_id' => $this->input->post('class_id'),                                         
            'gender_id' => $this->input->post('gender_id'),   
            'education_id' => $this->input->post('education_id'),
            'period_id' => $this->input->post('period_id')                                 
        );
        return $data;
    }
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_student->getAll()) {
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
        $id = $this->input->post('student_id');
        try {                                        
            if ($query = $this->model_student->getById($id)) {                
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
        
    public function getEducation(){
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_student->getEducationGroup()) {
                $data = $query;
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
    }    
        
    public function getPayment() {
        $data = array('data' => array());
        $id = $this->input->get('student_id');
        $status = $this->input->get('payment_status');
        try {      
            if($q1 = $this->model_student->getById2($id)){
                $education_id = $q1->education_id;
                $period_id = $q1->period_id;
                if($q2 = $this->model_student->getPayment($id, $education_id, $period_id, $status)){
                    
                    $first_sub = array();
                    foreach ($q2 as $r) {                    
                        array_push($first_sub, $r);
                    }
                    $data = array('data' => $first_sub);               
                }
            }
//            if ($query = $this->model_student->getPayment($id)) {                
//                $first_sub = array();
//                foreach ($query as $r) {                    
//                    array_push($first_sub, $r);
//                }
//                $data = array('data' => $first_sub);               
//            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }             
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getSelectedPayment() {
        $data = array('data' => array());
        $student_id = $this->input->POST('student_id');
        $payment_type_id = $this->input->POST('payment_type_id');
        try {                               
            if ($query = $this->model_student->getSelectedPayment($student_id, $payment_type_id)) {                                
                $data = array('data' => $query);               
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getSelectedPrimaryPayment() {
        $data = array('data' => array());
        $id = $this->input->POST('student_id');
        $status = $this->input->POST('payment_status');
        try {                
            if($q1 = $this->model_student->getById2($id)){
                $education_id = $q1->education_id;
                $period_id = $q1->period_id;
                if ($q2 = $this->model_student->getSelectedPrimaryPayment($id, $education_id, $period_id, $status)) {                                
                    $data = array('data' => $q2);               
                }    
            }                                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
    
    public function getSelectedPrimaryPayment2() {
        $data = array('data' => array());
        $id = $this->input->POST('student_id');  
        $status = $this->input->POST('payment_status');
        try {                
            if($q1 = $this->model_student->getById2($id)){
                $education_id   = $q1->education_id;
                $period_id      = $q1->period_id;
                if ($q2 = $this->model_student->getSelectedPrimaryPayment2($id, $education_id, $period_id, $status)) {                                
                    $data = array('data' => $q2);               
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
            $this->model_student->edit($data['student_id'], $data);            
            if ($_FILES['photo']['error'] == 0){
                $this->fileUpload($data['student_id']);
            }   
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
        
    public function fileUpload($file_name) {        
        $config['upload_path'] = 'assets/dist/img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|xml|zip|rar';
//        $config['file_name'] = $user->id_user . '.jpg';
        $config['file_name'] = $file_name;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->set_allowed_types('*');
        $src = null;
        if ($this->upload->do_upload('photo')) {
            $file_data = $this->upload->data();
            $file_type = explode('.', $file_data['file_name']);
            $src = 'assets/dist/img/' . $file_name . '.' . $file_type[1];
            $resize['image_library'] = 'gd2';
            $resize['source_image'] = $src;
            $resize['create_thumb'] = FALSE;
            $resize['maintain_ratio'] = FALSE;
            $resize['width'] = 160;
            $resize['height'] = 160;
            $resize['overwrite'] = TRUE;
            $this->load->library('image_lib', $resize);
            $this->image_lib->initialize($resize);
            $this->image_lib->resize();
            $this->model_student->updatePhotoProfil($file_name, $src);
        }
    }
}
    
?>