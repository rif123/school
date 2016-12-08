<?php
    
class Logout extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        $this->session->unset_userdata('staff');
        $this->session->sess_destroy();        
        redirect(base_url());
    }       
}
    
?>