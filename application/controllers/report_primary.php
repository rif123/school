<?php

class Report_primary extends CI_Controller {

    public function __contruct() {
        parent::__contruct();
    }

    public function index() {
        if (empty($this->session->userdata('staff'))) {
            redirect(base_url());
        } else {
            $this->load->view("view_report_primary");
        }
    }

    public function resources(){
        $data = array();
        $columnDefs = array(
                array(
                    "title" => "Education",
                    "targets" => 0
                ),
                array(
                    "title" => "NIS",
                    "targets" => 1
                ),
                array(
                    "title" => "Name",
                    "targets" => 2
                ),
                array(
                    "title" => "Class",
                    "targets" => 3
                ),
                array(
                    "title" => "Payment Date",
                    "targets" => 4
                ),
                // array(
                    // "title" => "Student id",
                    // "targets" => 5,
                // )
            );
        $columns = array(
                array(
                    "data" => "education"
                ),
                array(
                    "data" => "nis"
                ),
                array(
                    "data" => "name"
                ),
                array(
                    "data" => "classes"
                ),
                array(
                    "data" => "payment_date"
                )

            );

        try {

            if ($qE = $this->model_education->getOne()) {

                if ($qPT = $this->model_payment_type->getByEducationStatus($qE->education_id, 1)) {

                    $i = 5;
                    foreach ($qPT as $r) {
                        $t = array(
                            "title" => $r->detail,
                            "targets" => $i
                        );
                        array_push($columnDefs, $t);

                        $t2 = array(
                            "data" => strtolower(str_replace(" ","_", $r->detail))
                        );
                        array_push($columns, $t2);
                        $i++;
                    }

                    $t = array(
                        "title" => "Amount",
                        "targets" => $i++
                    );
                    array_push($columnDefs, $t);

                    $t2 = array(
                        "data" => "amount"
                    );
                    array_push($columns, $t2);

                }
            }
            if($q1 = $this->model_payment->getDateGroup())
            {

                foreach ($q1 as $r1)
                {
                    if($q2 = $this->model_student->getAllNewLimit())
                    {
                        foreach ($q2 as $r2)
                        {
                            $t = array();
                            $t["education"] = $r2->education_detail;
                            $t["student_id"] = $r2->student_id;
                            $t["nis"] = $r2->nis;
                            $t["name"] = $r2->name;
                            $t["classes"] = $r2->class_detail;
                            $t["payment_date"] = $r1->payment_date;
                            $amount = 0;
                            if($q3 = $this->model_payment_type->getByStatus(1))
                            {
                                foreach ($q3 as $r3)
                                {
                                    $key = strtolower(str_replace(" ","_", $r3->detail));
                                    if(($r3->education_id==$r2->education_id) && ($r3->period_id==$r2->period_id))
                                    {
                                        if($q4 = $this->model_payment->getReportPayment($r2->student_id, $r3->payment_type_id, $r1->payment_date))
                                        {
                                           if(!is_null($q4->total))
                                           {
                                                $amount += intval($q4->total);
                                                $t[$key] = intval($q4->total);
                                            }
                                            else
                                            {
                                                $amount += 0;
                                                $t[$key] = 0;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $t[$key] = "";
                                    }
                                }
                            }
                            $t["amount"] = $amount;
                            if($amount>0)
                            {
                                array_push($data, $t);
                            }
                        }
                    }
                }
            }
            $data = array(
                'columnDefs' => $columnDefs,
                'data' => $data,
                'columns' =>$columns
            );
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        header("content-type: application/json");
        echo json_encode($data);
        exit;
    }

    public function resources2(){
        $data = array('data' => array());
        try {
            if($q1 = $this->model_payment->getDateGroup())
            {

                $first = array();
                foreach ($q1 as $r1)
                {
                    if($q2 = $this->model_student->getAllNewLimit())
                    {
                        // echo "<pre>";
                        // print_R ($_GET);die;
                        foreach ($q2 as $r2)
                        {
                            $t = array();
                            $t["student_id"] = $r2->student_id;
                            $t["education"] = $r2->education_detail;
                            $t["nis"] = $r2->nis;
                            $t["name"] = $r2->name;
                            $t["classes"] = $r2->class_detail;
                            $t["payment_date"] = $r1->payment_date;
                            $amount = 0;
                            if($q3 = $this->model_payment_type->getByStatus(1))
                            {
                                foreach ($q3 as $r3)
                                {
                                    $key = strtolower(str_replace(" ","_", $r3->detail));
                                    if(($r3->education_id==$r2->education_id) && ($r3->period_id==$r2->period_id))
                                    {
                                        if($q4 = $this->model_payment->getReportPayment($r2->student_id, $r3->payment_type_id, $r1->payment_date))
                                        {
                                            if(!is_null($q4->total))
                                            {
                                                $amount += intval($q4->total);
                                                $t[$key] = intval($q4->total);
                                            }
                                            else
                                            {
                                                $amount += 0;
                                                $t[$key] = 0;
                                            }
                                        }
                                    }else{
                                        $t[$key] = "";
                                    }
                                }
                            }
                            $t["amount"] = $amount;
                            if($amount>0)
                            {
                                array_push($first, $t);
                            }
                        }
                    }
                }
                $data = array(
                    "raw"           => 2,
                    "recordsTotal" => 8528,
                    "recordsFiltered" => 8528,
                    'data' => $first,
                );

            }
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
