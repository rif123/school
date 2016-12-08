<?php

class Home extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_home");
        }       
    }   
}

?>