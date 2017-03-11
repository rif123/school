<?php

class model_student extends CI_Model {

    public function insert($data) {
        $this->db->insert('student', $data);
    }

    public function getAll() {
        if (empty($_GET['findName'])){
            $q = '
            Select std.*, gdr.detail as "gender_detail",
            case
            when class_id IS NULL then "-"
            else (select class.detail from class
                where class.class_id = std.class_id limit 1) end as "class_detail",
            case when education_id IS NULL then "-"
            else (select education.detail from education where education.education_id = std.education_id limit 1)
            end as "education_detail", prd.detail as "period_detail"
            from student std
            join gender gdr on std.gender_id = gdr.gender_id
            join period prd on std.period_id = prd.period_id
            ';
            $query = $this->db->query($q);
            // $query = $this->db->query('Select std.*, gdr.detail as "gender_detail", case when class_id IS NULL then "-" else (select class.detail from class where class.class_id = std.class_id limit 1) end as "class_detail", case when education_id IS NULL then "-" else (select education.detail from education where education.education_id = std.education_id limit 1) end as "education_detail", prd.detail as "period_detail" from student std join gender gdr on std.gender_id = gdr.gender_id join period prd on std.period_id = prd.period_id

            //     ');
        }else{
            $query = $this->db->query(' select * from (
                         Select std.*, gdr.detail as "gender_detail",
                            case
                                when class_id IS NULL then "-"
                                else (select class.detail from class where class.class_id = std.class_id limit 1)
                            end as
                            "class_detail",
                            case
                            when education_id
                            IS NULL
                                then "-" else (select education.detail from education where education.education_id = std.education_id limit 1)
                                end as "education_detail", prd.detail as "period_detail"
                            from student std
                            join gender gdr on std.gender_id = gdr.gender_id
                            join period prd on std.period_id = prd.period_id

                        ) as xx
                        where SUBSTR(education_detail, LOCATE(" ", education_detail)+1, LENGTH(education_detail )) = "'.$_GET['findName'].'"');
        }
        return $query->result();
    }
    public function getAllNewLimit() {
        if (empty($_GET['findName'])){
            $q = '
            Select std.*, gdr.detail as "gender_detail",
            case
            when class_id IS NULL then "-"
            else (select class.detail from class
                where class.class_id = std.class_id limit 1) end as "class_detail",
            case when education_id IS NULL then "-"
            else (select education.detail from education where education.education_id = std.education_id limit 1)
            end as "education_detail", prd.detail as "period_detail"
            from student std
            join gender gdr on std.gender_id = gdr.gender_id
            join period prd on std.period_id = prd.period_id
            limit 0, 100
            ';
            $query = $this->db->query($q);
            // $query = $this->db->query('Select std.*, gdr.detail as "gender_detail", case when class_id IS NULL then "-" else (select class.detail from class where class.class_id = std.class_id limit 1) end as "class_detail", case when education_id IS NULL then "-" else (select education.detail from education where education.education_id = std.education_id limit 1) end as "education_detail", prd.detail as "period_detail" from student std join gender gdr on std.gender_id = gdr.gender_id join period prd on std.period_id = prd.period_id

            //     ');
        }else{
            $query = $this->db->query(' select * from (
                         Select std.*, gdr.detail as "gender_detail",
                            case
                                when class_id IS NULL then "-"
                                else (select class.detail from class where class.class_id = std.class_id limit 1)
                            end as
                            "class_detail",
                            case
                            when education_id
                            IS NULL
                                then "-" else (select education.detail from education where education.education_id = std.education_id limit 1)
                                end as "education_detail", prd.detail as "period_detail"
                            from student std
                            join gender gdr on std.gender_id = gdr.gender_id
                            join period prd on std.period_id = prd.period_id

                        ) as xx
                        where SUBSTR(education_detail, LOCATE(" ", education_detail)+1, LENGTH(education_detail )) = "'.$_GET['findName'].'"');
        }
        return $query->result();
    }

    public function getById($id) {
        $query = $this->db->query('Select std.* from student std join gender gdr on std.gender_id = gdr.gender_id where std.student_id = "'.$id.'"');
        return $query->result();
    }

    public function getById2($id) {
        $query = $this->db->query('Select std.* from student std where std.student_id = "'.$id.'"');
        return $query->row();
    }

    public function getByNis($id) {
        $this->db->select('student.student_id, student.nis, student.name, student.photo, student.born_date, gender.gender_id, student.address   ')
                ->from('student')
                ->join('gender', 'gender.gender_id = student.gender_id')
                ->where('student.nip', $id)
                ->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPayment($id, $education_id, $period_id, $status="1"){
        $query = $this->db->query('SELECT PAYMENT_TYPE.payment_type_id, PAYMENT_TYPE.detail, PAYMENT_TYPE.total, case when status = "1" then "Primary" else "Other" end as "payment_status", CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) END AS "total_payment", CASE WHEN (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) IS NULL THEN "-" ELSE (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) END AS "payment_date", (PAYMENT_TYPE.TOTAL - (CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) END)) AS "remain" FROM PAYMENT_TYPE WHERE PAYMENT_TYPE.education_id = "'.$education_id.'" and PAYMENT_TYPE.period_id = "'.$period_id.'" AND payment_type.`status` = "'.$status.'"   ORDER BY  payment_type_id ASC');
        return $query->result();
    }

    public function getSelectedPayment($id, $payment_type_id){
        $query = $this->db->query('SELECT '.$id.' as "student_id", (SELECT student.name from student where student.student_id = "'.$id.'" limit 1) as "student_detail", PAYMENT_TYPE.payment_type_id, PAYMENT_TYPE.detail, PAYMENT_TYPE.total as "invoice", case when status = "1" then "Primary" else "Other" end as "payment_status", CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) END AS "total_payment", CASE WHEN (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) IS NULL THEN "-" ELSE (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) END AS "payment_date" FROM PAYMENT_TYPE where PAYMENT_TYPE.payment_type_id="'.$payment_type_id.'"');
        return $query->row();
    }

    public function getSelectedPrimaryPayment($id, $education_id, $period_id, $status='1'){
        $query = $this->db->query('SELECT payment_type_id, (select student_id from student where student_id = "'.$id.'") as "student_id", (select nis from student where student_id = "'.$id.'") as "nis", (select name from student where student_id = "'.$id.'") as "student_detail", sum(PAYMENT_TYPE.total) as "invoice", case when status = "1" then "Primary" else "Other" end as "detail", sum(CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) END) AS "total_payment", CASE WHEN (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) IS NULL THEN "-" ELSE (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) END AS "payment_date", sum((PAYMENT_TYPE.TOTAL - (CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) END)) )AS "remain" FROM PAYMENT_TYPE WHERE PAYMENT_TYPE.status= "'.$status.'" and PAYMENT_TYPE.education_id = "'.$education_id.'" and PAYMENT_TYPE.period_id = "'.$period_id.'" order by remain desc, payment_date asc');
        return $query->row();
    }

    public function getSelectedPrimaryPayment2($id, $education_id, $period_id, $status='1'){
        $q ='SELECT payment_type.payment_type_id, (select student_id from student where student_id = "'.$id.'") as "student_id", (select nis from student where student_id = "'.$id.'") as "nis", (select name from student where student_id = "'.$id.'") as "student_detail", sum(PAYMENT_TYPE.total) as "invoice", case when status = "1" then "Primary" else "Other" end as "payment_status", sum(CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" LIMIT 1) END) AS "total_payment", CASE WHEN (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) IS NULL THEN "-" ELSE (SELECT PAYMENT.PAYMENT_DATE FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'" order by PAYMENT.PAYMENT_DATE desc LIMIT 1) END AS "payment_date", sum((PAYMENT_TYPE.TOTAL - (CASE WHEN (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) IS NULL THEN 0 ELSE (SELECT sum(PAYMENT.TOTAL) FROM PAYMENT WHERE PAYMENT.PAYMENT_TYPE_ID = PAYMENT_TYPE.PAYMENT_TYPE_ID AND STUDENT_ID="'.$id.'"  LIMIT 1) END)) ) AS "remain" FROM PAYMENT_TYPE WHERE PAYMENT_TYPE.status= "'.$status.'" and PAYMENT_TYPE.education_id = "'.$education_id.'" and PAYMENT_TYPE.period_id = "'.$period_id.'" group by payment_type.payment_type_id ORDER BY payment_type_id ASC' ;
        $query = $this->db->query($q);
        return $query->result();
    }

    public function updatePhotoProfil($id, $src) {
        $this->db->set("photo", $src);
        $this->db->where('student_id', $id);
        $this->db->update('student');
    }

    public function edit($id, $data) {
        $this->db->where('student_id', $id);
        $this->db->update('student', $data);
    }

    public function delete($id) {
        $this->db->where('student_id', $id);
        $this->db->delete('student');
    }


    public function getEducationGroup(){
         $query = $this->db->query('SELECT SUBSTR(detail, LOCATE(" ", detail)+1, LENGTH(detail )) AS nameEdu
                FROM education
                GROUP BY nameEdu
            ');
        return $query->result_array();
    }
}

?>
