<?php

class model_payment extends CI_Model {

    public function insert($data) {
        $this->db->insert('payment', $data);
    }

    public function getById($id) {
        $query = $this->db->query('SELECT * from payment where payment_id="'.$id.'"');
        return $query->row();     
    } 
    
    public function getOther() {
        $query = $this->db->query('select *, DATE(pmt.payment_date) as "pmt_date",  pmt.total as "payment_total", ptp.detail as "payment_type_detail", edu.detail as "education_detail",case when class_id IS NULL then "-" else (select class.detail from class where class.class_id = std.class_id limit 1) end as "class_detail", case when (ptp.total - pmt.total) = 0 then "Lunas" else "Proses" end as "pmt_status" from payment pmt join payment_type ptp on pmt.payment_type_id = ptp.payment_type_id join student std on std.student_id = pmt.student_id join education edu on edu.education_id = std.education_id where ptp.status = "0" order by pmt.student_id');
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