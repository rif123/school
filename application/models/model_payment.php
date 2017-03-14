<?php

class model_payment extends CI_Model {
    var $table = 'customers';
    var $column_order = array('education_detail','nis','name','class_detail','payment_date','price', 'price'); //set column field database for datatable orderable
    var $column_search = array('education_detail','nis','name','class_detail','payment_date','py.total', 'py.total'); //set column field database for datatable searchable
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
        select  education_detail,
                nis,
                name,
                class_detail,
                py.payment_date,
                sum(py.total) as price
                from (
                        select *  from (
                            Select
                                std.nis,
                                prd.detail as dtl,
                                std.period_id as prd,
                                std.student_id,
                                std.education_id as edc,
                                std.name, gdr.detail as "gender_detail",
                                class.detail as class_detail,
                                education.detail as education_detail,
                                prd.detail as "period_detail"
                                        from student std
                                        LEFT JOIN education on std.education_id =  education.education_id
                                        LEFT JOIN class on std.class_id = class.class_id
                                        join gender gdr on std.gender_id = gdr.gender_id
                                        join period prd on std.period_id = prd.period_id

                        ) as stdy
                        JOIN payment_type as pty on stdy.prd = pty.period_id and pty.status = 1
                )  as kk
                JOIN payment  as py on kk.student_id = py.student_id and py.payment_type_id = kk.payment_type_id
                '.$where.'
                group by DATE(py.payment_date)
                '.$order.'
                '.$limit.'
        ';
        // print_R($q)
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
        }

        $order = "";
        if(isset($_GET['order'])) // here order processing
        {
            $order = "ORDER BY ".$this->column_order[$_GET['order']['0']['column']]." ". $_GET['order']['0']['dir'];
        }
        $q = '
        select count(*) as  count from (
            	select
                        education_detail,
                        nis,
                        name,
                        class_detail,
                        py.payment_date,
                        sum(py.total)as price
            	from (
            		select *  from (
            			Select
            				std.nis,
            				prd.detail as dtl,std.period_id as prd,
            				std.student_id,
            				std.education_id as edc,
            				std.name, gdr.detail as "gender_detail",
            				class.detail as class_detail,
            				education.detail as education_detail,
            				prd.detail as "period_detail"
            						from student std
            						LEFT JOIN education on std.education_id =  education.education_id
            						LEFT JOIN class on std.class_id = class.class_id
            						join gender gdr on std.gender_id = gdr.gender_id
            						join period prd on std.period_id = prd.period_id
            		) as stdy
            		JOIN payment_type as pty on stdy.prd = pty.period_id and pty.status = 1
            	)  as kk
            	JOIN payment  as py on kk.student_id = py.student_id and py.payment_type_id = kk.payment_type_id
                '.$where.'
            	group by DATE(py.payment_date)
                '.$order.'
            ) as cnt
        ';
        $query = $this->db->query($q)->row();
        return $query->count;
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
