<?php
    
class Staff extends CI_Controller {
    
    public function __contruct() {
        parent::__contruct();
    }
        
    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_staff");
        }                                      
    }   
        
    public function init() {
        date_default_timezone_set("Asia/Jakarta");
        $data = array(
            'staff_id' => $this->input->post('staff_id'),            
            'nip' => $this->input->post('nip'),
            'name' => $this->input->post('name'),
            'photo' => 'assets/dist/img/default.png',
            'born_date' => $this->input->post('born_date'),
            'address' => $this->input->post('address'),
            'created' => date("Y-m-d H:i:s"),
            'username' => $this->input->post('nip'),
//            'password' => md5($this->input->post('password')),
            'password' => $this->input->post('password'),
            'last_login' => NULL,
            'status' => 1,            
            'gender_id' => $this->input->post('gender_id'),
            'language_id' => $this->input->post('language_id'),
            'permission_id' => $this->input->post('permission_id')                                    
        );
        return $data;
    }
        
    public function insert() {
        try {            
            $data = $this->init();
            $this->model_staff->insert($data);            
            if ($_FILES['photo']['error'] == 0){
                $this->fileUpload($data['staff_id']);
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
            $this->model_staff->updatePhotoProfil($file_name, $src);
        }
    }
        
        
    public function getAll() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_staff->getAll()) {
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
    
    public function getAllUser() {
        $data = array('data' => array());
        try {                                        
            if ($query = $this->model_staff->getAllUser()) {
                $first_sub = array();
                foreach ($query as $r) {      
//                    $r->password_decrypted = md5($r->password);                    
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
        $id = $this->input->post('staff_id');
        try {                                        
            if ($query = $this->model_staff->getById($id)) {                
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
        
    public function getBySession() {
        $data = array('data' => array());
        $id = $this->session->userdata('staff')->staff_id;
        try {                                           
            if ($query = $this->model_staff->getById($id)) {   
                $data = array('data' => $query);                
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
        
    public function getByNip() {
        $data = array('valid' => true);
        $id = $this->input->post('nip');
        try {                                        
            if ($query = $this->model_staff->getByNip($id)) {                
                foreach ($query as $r) {                    
                    $data = array('valid' => false);
                }                
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
    
    public function getCurrentPassword() {
        $data = array('valid' => false);
        $old_password = $this->input->post('old_password');
        $currentPassword = $this->session->userdata('staff')->password;
        try {                                        
            if ($old_password == $currentPassword) {                
                $data = array('valid' => true);
            }                
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }            
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }
    
    public function getAvailableUsername() {
        $data = array('valid' => true);
        $username = $this->input->post('username');        
        try {                        
            if ($query = $this->model_staff->getAvailableUsername($username)) {                
                foreach ($query as $r) {                    
                    $data = array('valid' => false);
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
            $this->model_staff->edit($data['staff_id'], $data);
            if ($_FILES['photo']['error'] == 0){
                $this->fileUpload($data['staff_id']);
            }                
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
        
    public function settingProfil() {
        try {            
            $data = array(
                'staff_id' => $this->input->post('staff_id'),            
                'nip' => $this->input->post('nip'),
                'name' => $this->input->post('name'),
                'born_date' => $this->input->post('born_date'),
                'address' => $this->input->post('address'),
                'gender_id' => $this->input->post('gender_id')                
            );
            $this->model_staff->edit($data['staff_id'], $data);                
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function settingUsername() {
        try {            
            $data = array(
                'staff_id' => $this->session->userdata('staff')->staff_id,            
                'username' => $this->input->post('username')                
            );
            $this->model_staff->edit($data['staff_id'], $data);                
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function settingPassword() {
        try {            
            $data = array(
                'staff_id' => $this->session->userdata('staff')->staff_id,            
                'password' => $this->input->post('new_password')                
            );
            // print_R ($data);die;
            $this->model_staff->edit($data['staff_id'], $data);                
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
    
    public function settingPhoto() {
        try {            
            if ($_FILES['photo']['error'] == 0){
                $id = $this->session->userdata('staff')->staff_id;
                $this->fileUpload($id);
            }             
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
        
    public function delete() {
        try {                        
            $this->model_staff->delete($this->input->post('staff_id'));            
            echo "Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    } 
}
    
?>