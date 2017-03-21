<?php

class model_payment extends CI_Model {
    var $table = 'customers';
    var $column_order = array('education_detail','nis','name','class_detail','payment_date','payment_detail', 'price'); //set column field database for datatable orderable
    var $column_search = array('education_detail','nis','name','class_detail','payment_date','payment_detail', 'price'); //set column field database for datatable searchable
    var $order = array('id' => 'asc'); // default order

    public function insert($data) {
        $this->db->insert('payment', $data);
    }

    public function getById($id) {
        $query = $this->db->query('SELECT * from payment where payment_id="'.$id.'"');
        return $query->row();
    }

    public function getOtherMerge(){
        $where = "";
        if ($_GET['search']['value']) {
            $where = "WHERE ";
            $numItems = count($this->column_search);
            $i = 0;
            foreach ($this->column_search as $item) // loop column
            {
                if(++$i === $numItems) {
                    $where .= $item." LIKE '%".$_GET['search']['value']."%'";
                } else {
                    $where .= $item." LIKE '%".$_GET['search']['value']."%' OR ";
                }
            }
            if (!empty($_GET['education'])) {
                $where .= " and education_detail LIKE '%".$_GET['education']."%'";
            }

            if (!empty($_GET['class'])) {
                $where .= " and class_detail = '".$_GET['class']."'";
            }
            if (!empty($_GET['status'])) {
                $where .= " and status = '".$_GET['status']."'";
            }
            if (!empty($_GET['start_date']) && empty($_GET['end_date']) ) {
                $where .= " and DATE(py.payment_date) = '".$_GET['start_date']."'";
            }
            if (!empty($_GET['end_date'])) {
                if (!empty($_GET['start_date'])) {
                    $where .= " and DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."'";
                } else {
                    $where .= " and DATE(payment_date) = '".$_GET['end_date']."'";
                }
            }
        } else {
            if (!empty($_GET['education'])) {
                if (!empty($where)) {
                    $where .= " and education_detail LIKE '%".$_GET['education']."%'";
                } else {
                    $where = "WHERE ";
                    $where .= "education_detail LIKE '%".$_GET['education']."%'";
                }
            }
            if (!empty($_GET['status'])) {
                if (!empty($where)) {
                    $where .= " and status = '".$_GET['status']."'";
                } else {
                    $where = "WHERE ";
                    $where .= " status = '".$_GET['status']."'";
                }
            }
            if (!empty($_GET['class'])) {
                if (!empty($where)) {
                    $where .= " and class_detail = '".$_GET['class']."'";
                } else {
                    $where = "WHERE ";
                    $where .= " class_detail = '".$_GET['class']."'";
                }
            }
            if (!empty($_GET['start_date']) && empty($_GET['end_date']) ) {

                if (!empty($where)) {
                    $where .= " and DATE(payment_date) = '".$_GET['start_date']."'";
                } else {
                    $where = "WHERE ";
                    $where .= " DATE(payment_date) = '".$_GET['start_date']."'";
                }
            }
            if (!empty($_GET['end_date'])) {
                if (!empty($where)) {
                    if (!empty($_GET['start_date'])) {
                        $where .= " and DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."'";
                    } else {
                        $where .= " and DATE(payment_date) = '".$_GET['end_date']."'";
                    }
                } else {
                    $where = "WHERE ";
                    if (!empty($_GET['start_date'])) {
                        $where .= "  DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."'";
                    } else {
                        $where .= " DATE(payment_date) = '".$_GET['end_date']."'";
                    }
                }
            }
        }
        $order = "";
        if(isset($_GET['order']))
        {
            $order = "ORDER BY ".$this->column_order[$_GET['order']['0']['column']]." ". $_GET['order']['0']['dir'];
        }


        $limit = "";
        if($_GET['length'] != -1){
            $order = "ORDER BY ".$this->column_order[$_GET['order']['0']['column']]." ". $_GET['order']['0']['dir'];
            $limit  = "LIMIT ".$_GET['start'].",".$_GET['length'];
        }
        $q = '
        SELECT * from (
        SELECT nis, name, education_detail, class_detail, payment_date,payment_detail, total_bayar, price, baru_terbayar,  IF(baru_terbayar  >= total_bayar, "Lunas", "Proses") as status

        FROM (
SELECT
   py.total AS price,
   (SELECT Sum(py.total)
    FROM   payment AS py
           JOIN payment_type
             ON py.payment_type_id = payment_type.payment_type_id
                AND payment_type.status = 1
    WHERE  student_id = std_id) AS baru_terbayar,
name, total_bayar, education_detail, nis, class_detail,
py.payment_date,payment_detail
FROM   (SELECT student_id,
           payment_type_id,
           NAME,
           education_id AS eduID,
           std_id,
           prd,
           pty.detail   AS payment_detail,
           pty.total    AS total_bayar,
       nis,
    class_detail,
       education_detail
    FROM   (SELECT std.nis,
                   prd.detail       AS dtl,
                   std.period_id    AS prd,
                   std.student_id,
                   std.education_id AS edc,
                   std.name,
                   gdr.detail       AS "gender_detail",
                   class.detail     AS class_detail,
                   education.detail AS education_detail,
                   prd.detail       AS "period_detail",
                   std.student_id   AS std_id
            FROM   student std
                   LEFT JOIN education
                          ON std.education_id = education.education_id
                   LEFT JOIN class
                          ON std.class_id = class.class_id
                   JOIN gender gdr
                     ON std.gender_id = gdr.gender_id
                   JOIN period prd
                     ON std.period_id = prd.period_id) AS stdy
           JOIN payment_type AS pty
             ON stdy.prd = pty.period_id
                AND pty.status = 1) AS kk
   JOIN payment AS py
     ON kk.student_id = py.student_id
        AND py.payment_type_id = kk.payment_type_id
        ) AS ALLQUERY
) as ALLPAYMENT
    '.$where.'
    '.$order.'
    '.$limit.'
        ';
        $query = $this->db->query($q);
        return $query->result();
    }

    public function getOtherMergeCount(){
        $where = "";
        if ($_GET['search']['value']) {
            $where = "WHERE ";
            $numItems = count($this->column_search);
            $i = 0;
            foreach ($this->column_search as $item) // loop column
            {
                if(++$i === $numItems) {
                    $where .= $item." LIKE '%".$_GET['search']['value']."%'";
                } else {
                    $where .= $item." LIKE '%".$_GET['search']['value']."%' OR ";
                }
            }
            if (!empty($_GET['education'])) {
                $where .= " and education_detail LIKE '%".$_GET['education']."%'";
            }

            if (!empty($_GET['class'])) {
                $where .= " and class_detail = '".$_GET['class']."'";
            }
            if (!empty($_GET['start_date']) && empty($_GET['end_date']) ) {
                $where .= " and DATE(payment_date) = '".$_GET['start_date']."'";
            }
            if (!empty($_GET['end_date'])) {
                if (!empty($_GET['start_date'])) {
                    $where .= " and DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."' ";
                } else {
                    $where .= " and DATE(payment_date) = '".$_GET['end_date']."'";
                }
            }

        } else {
            if (!empty($_GET['education'])) {
                if (!empty($where)) {
                    $where .= " and education_detail LIKE '%".$_GET['education']."%'";
                } else {
                    $where = "WHERE ";
                    $where .= "education_detail LIKE '%".$_GET['education']."%'";
                }
            }

            if (!empty($_GET['class'])) {
                if (!empty($where)) {
                    $where .= " and class_detail = '".$_GET['class']."'";
                } else {
                    $where = "WHERE ";
                    $where .= " class_detail = '".$_GET['class']."'";
                }
            }
            if (!empty($_GET['start_date']) && empty($_GET['end_date'])) {
                if (!empty($where)) {
                    $where .= " and DATE(payment_date) = '".$_GET['start_date']."'";
                } else {
                    $where = "WHERE ";
                    $where .= " DATE(payment_date) = '".$_GET['start_date']."'";
                }
            }
            if (!empty($_GET['end_date'])) {
                if (!empty($where)) {
                    if (!empty($_GET['start_date'])) {
                        $where .= " and DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."'";
                    } else {
                        $where .= " and DATE(payment_date) = '".$_GET['end_date']."'";
                    }
                } else {
                    $where = "WHERE ";
                    if (!empty($_GET['start_date'])) {
                        $where .= " DATE(payment_date)   BETWEEN '".$_GET['start_date']."' AND '".$_GET['end_date']."' ";
                    } else {
                        $where .= " DATE(payment_date) = '".$_GET['end_date']."'";
                    }
                }
            }
        }
        $order = "";
        if(isset($_GET['order'])) // here order processing
        {
            $order = "ORDER BY ".$this->column_order[$_GET['order']['0']['column']]." ". $_GET['order']['0']['dir'];
        }
        $q = '
        SELECT * from (
        SELECT nis, name, education_detail, class_detail, payment_date,payment_detail, total_bayar, price, baru_terbayar,   IF(baru_terbayar  >= total_bayar, "Lunas", "Proses") as status
        FROM (
SELECT
   py.total AS price,
   (SELECT Sum(py.total)
    FROM   payment AS py
           JOIN payment_type
             ON py.payment_type_id = payment_type.payment_type_id
                AND payment_type.status = 1
    WHERE  student_id = std_id) AS baru_terbayar,
name, total_bayar, education_detail, nis, class_detail,
py.payment_date,payment_detail
FROM   (SELECT student_id,
           payment_type_id,
           NAME,
           education_id AS eduID,
           std_id,
           prd,
           pty.detail   AS payment_detail,
           pty.total    AS total_bayar,
       nis,
    class_detail,
       education_detail
    FROM   (SELECT std.nis,
                   prd.detail       AS dtl,
                   std.period_id    AS prd,
                   std.student_id,
                   std.education_id AS edc,
                   std.NAME,
                   gdr.detail       AS "gender_detail",
                   class.detail     AS class_detail,
                   education.detail AS education_detail,
                   prd.detail       AS "period_detail",
                   std.student_id   AS std_id
            FROM   student std
                   LEFT JOIN education
                          ON std.education_id = education.education_id
                   LEFT JOIN class
                          ON std.class_id = class.class_id
                   JOIN gender gdr
                     ON std.gender_id = gdr.gender_id
                   JOIN period prd
                     ON std.period_id = prd.period_id) AS stdy
           JOIN payment_type AS pty
             ON stdy.prd = pty.period_id
                AND pty.status = 1) AS kk
   JOIN payment AS py
     ON kk.student_id = py.student_id
        AND py.payment_type_id = kk.payment_type_id

        ) AS ALLQUERY
) as ALLPAYMENT
    '.$where.'
    '.$order.'
        ';
        $count = $this->db->query($q)->num_rows();
        return $count;
    }


    public function getOther() {
        $q = 'select *, DATE(pmt.payment_date) as "pmt_date",  pmt.total as "payment_total", ptp.detail as "payment_type_detail", edu.detail as "education_detail",case when class_id IS NULL then "-" else (select class.detail from class where class.class_id = std.class_id limit 1) end as "class_detail", case when (ptp.total - pmt.total) = 0 then "Lunas" else "Proses" end as "pmt_status" from payment pmt join payment_type ptp on pmt.payment_type_id = ptp.payment_type_id join student std on std.student_id = pmt.student_id join education edu on edu.education_id = std.education_id where ptp.status = "0" order by pmt.student_id';
        $query = $this->db->query($q);
        //$query = $this->db->query('select *, DATE(pmt.payment_date) as "pmt_date",  pmt.total as "payment_total", ptp.detail as "payment_type_detail", edu.detail as "education_detail",case when class_id IS NULL then "-" else (select class.detail from class where class.class_id = std.class_id limit 1) end as "class_detail", case when (ptp.total - pmt.total) = 0 then "Lunas" else "Proses" end as "pmt_status" from payment pmt join payment_type ptp on pmt.payment_type_id = ptp.payment_type_id join student std on std.student_id = pmt.student_id join education edu on edu.education_id = std.education_id order by pmt.student_id');
       return $query->result();
    }

    public function getReportById($id) {
        $query = $this->db->query('select *, pmt.total as "payment_total", ptp.detail as "payment_type_detail", DATE_FORMAT(payment_date, "%d-%m-%Y") as "payment_date_extracted" from payment pmt join student std on pmt.student_id = std.student_id join payment_type ptp on ptp.payment_type_id = pmt.payment_type_id where pmt.payment_id = "'.$id.'"');
        return $query->row();
    }

    public function getSelectedPayment($id, $payment_type_id){
        $query = $this->db->query('SELECT * from payment where student_id="'.$id.'" and payment_type_id="'.$payment_type_id.'"');
        return $query->result();
    }

    public function edit($id, $data) {
        $this->db->where('payment_id', $id);
        $this->db->update('payment', $data);
    }

    public function delete($id) {
        $this->db->where('payment_id', $id);
        $this->db->delete('payment');
    }

    public function getDateGroup(){
        $query = $this->db->query('select DATE(payment_date) as "payment_date" from payment group by DATE(payment_date)');
        return $query->result();
    }

    public function getReportPayment($id, $payment_type_id, $date){
//        echo 'SELECT sum(total) as "total" from payment where student_id="'.$id.'" and payment_type_id="'.$payment_type_id.'" and Date(payment_date)="'.$date.'"';
        $query = $this->db->query('SELECT sum(total) as "total" from payment where student_id="'.$id.'" and payment_type_id="'.$payment_type_id.'" and Date(payment_date)="'.$date.'"');
        return $query->row();
    }
}

?>
