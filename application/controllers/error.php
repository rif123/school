<?php

class Error extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
       $this->load->view("view_error");
    }   
        
}

?>