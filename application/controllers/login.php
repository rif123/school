<?php

class Login extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            $this->load->view("view_login");
        } else {
            redirect("../home");            
        }
//       $this->load->view("view_login");
    }   
    
    public function validate() {
        $msg = '0';
        $username = $this->input->post('username');
//        $password = md5($this->input->post('password'));
        $password = $this->input->post('password');
        try {                                        
            if ($query = $this->model_staff->getLogin($username, $password)) {                
                foreach ($query as $r) {                    
                    $this->session->set_userdata('staff', $r);
                    redirect("../home");                    
                }                                
            }else{                
                redirect("../error");
            }                
        } catch (Exception $e) {
            redirect("../error");
        }            
    }
}

?>