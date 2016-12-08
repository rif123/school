<?php

class User extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
       $this->load->view("view_login");
    }

    public function signUp() {
        try {
            $data = $this->createDataGrup();
            $this->model_grup->insert($data);
            $id_grup = $this->input->post('id_grup');
            $this->fileUpload($id_grup);
            echo "Input Data Success";
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function fileUpload($file_name) {
        $config['upload_path'] = 'assets/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|xml|zip|rar';
//        $config['file_name'] = $user->id_user . '.jpg';
        $config['file_name'] = $file_name;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->set_allowed_types('*');
        $src = null;
        if ($this->upload->do_upload('src_image')) {
            $file_data = $this->upload->data();
            $file_type = explode('.', $file_data['file_name']);
            $src = 'assets/images/' . $file_name . '.' . $file_type[1];
            $resize['image_library'] = 'gd2';
            $resize['source_image'] = $src;
            $resize['create_thumb'] = FALSE;
            $resize['maintain_ratio'] = FALSE;
            $resize['width'] = 1250;
            $resize['height'] = 835;
            $resize['overwrite'] = TRUE;
            $this->load->library('image_lib', $resize);
            $this->image_lib->initialize($resize);
            $this->image_lib->resize();
            $this->model_grup->updatePhotoProfil($file_name, $src);
        }
    }

    public function createDataGrup() {
        $data = array(
            'id_grup' => $this->input->post('id_grup'),
            'nama_grup' => $this->input->post('nama_grup'),
            'tanggal_buat' => $this->input->post('tanggal'),
            'status' => 1
        );
        return $data;
    }

    public function delete() {
        $id_grup = $this->input->post('id_grup');
        $this->model_grup->delete($id_grup);
        echo "Delete Data Success";
    }

    public function update() {
        $id_grup = $this->input->post('id_grup');
        $data = $this->createDataGrup();
        $this->model_grup->update($id_grup, $data);
        $this->fileUpload($id_grup);
        echo "Update Data Success";
    }

    public function getJSON() {
        $data = array('data' => array());
        if ($query = $this->model_grup->queryView()) {
            $sub_data = array();
            foreach ($query as $r) {
                $second_sub_data = array();
                if ($sub_query = $this->model_anggota->viewByIdGrup($r->id_grup)) {
                    foreach ($sub_query as $sub_r) {
                        array_push($second_sub_data, $sub_r);
                    }
                }
                $r->anggota = $second_sub_data;
                array_push($sub_data, $r);
            }
            $data = array('data' => $sub_data);
        }
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }

    public function getDosenGrup() {
        $user = $this->session->userdata('user');
        $data = array('data' => array());
        if ($this->model_grup->viewByIdUser($user->id_user)) {
            $query = $this->model_grup->viewByIdUser($user->id_user);
            $first_sub_data = array();
            foreach ($query as $r) {
                $second_sub_data = array();
                if ($sub_query = $this->model_anggota->viewByIdGrup($r->id_grup)) {
                    foreach ($sub_query as $sub_r) {
                        array_push($second_sub_data, $sub_r);
                    }
                }
                $r->anggota = $second_sub_data;
                array_push($first_sub_data, $r);
            }
            $data = array(
                'data' => $first_sub_data,
                'alert' => $this->model_anggota->viewByCount($user->id_user)
            );
        }
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }

    public function getDosenGrupSpecial() {
        $user = $this->session->userdata('user');
        $id_user = $user->id_user;
        $data = array();
        if ($this->model_grup->viewByIdUser($id_user)) {
            $query = $this->model_grup->viewByIdUser($id_user);
//            $first_sub_data = array();
            foreach ($query as $r) {
                $row = array(
                    'id' => $r->id_grup,
                    'nama' => $r->nama_grup,
                    'url' => '/grup/index?id_grup=' . $r->id_grup,
                    'status' => 'Grup'
                );
                array_push($data, $row);
            }
        }

        if ($query = $this->model_anggota->viewByIdUser($id_user)) {
            $first_sub = array();
            foreach ($query as $r) {
                if ($sub_query = $this->model_anggota->viewMemberByIdGrupNotUser($r->id_grup)) {
                    foreach ($sub_query as $sub_r) {
                        if ($sub_r->id_user != $id_user) {
                            if (sizeof($first_sub) == 0) {
                                array_push($first_sub, $sub_r);
                            } else {
                                $test = false;
                                foreach ($first_sub as $c) {
                                    if ($c->id_user == $sub_r->id_user) {
                                        $test = true;
                                        break;
                                    }
                                }
                                if ($test == false) {
                                    $row = array(
                                        'id' => $sub_r->id_user,
                                        'nama' => $sub_r->nama,
                                        'url' => '/search/user?id_user=' . $sub_r->id_user,
                                        'status' => 'Pengguna'
                                    );
                                    array_push($data, $row);

//                                    array_push($first_sub, $sub_r);
                                }
                            }
                        }
                    }
                }
            }
//            $data = array('data' => $first_sub);
        }
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }

    public function getGroup() {
        $id_grup = $this->input->get('id_grup');
        if ($query = $this->model_grup->viewById($id_grup)) {
            $second_sub_data = array();
            if ($sub_query = $this->model_anggota->viewByIdGrup($query[0]->id_grup)) {
                foreach ($sub_query as $sub_r) {
                    array_push($second_sub_data, $sub_r);
                }
            }
            $query[0]->anggota = $second_sub_data;

            header("content-type: application/json");
            echo json_encode($query[0]);
            exit;
        }
    }

}

?>