<?php

class Registration extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_registration");
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
            'gender_id' => $this->input->post('gender_id'),
            'education_id' => $this->input->post('education_id'),
            'period_id' => $this->input->post('period_id')
        );
        return $data;
    }
    
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_student->insert($data);            
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