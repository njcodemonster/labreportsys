<?php

include_once("config/config.php");
include_once("config/database.php");

class SiteFunctions extends Database {

    public $lab_table = "labs";
    public $auth_ips_table = "auth_ips";
    public $patients_table = "patients";
    public $reports_table = "reports";
    public $reports_name_table = "reports_names";

    public function GetMasterKey() {

        $myfile = fopen("config/masterkey.txt", "r");
        $return = trim(fgets($myfile));
        fclose($myfile);

        return $return;
    }

    public function InsertLab($data) {

        $res = $this->getManager()->insert($this->lab_table, $data, true);
        $res = $res['last_id'];
        return $res;
    }

    public function AuthLab($data) {

        $res = $this->getManager()->insert($this->auth_ips_table, $data, true);
        $res = $res['last_id'];
        return $res;
    }

    public function AddReportType($patient_id, $document) {

        $data = array('p_id' => $patient_id, 'document_url' => $document);
        $res = $this->getManager()->insert($this->reports_table, $data, true);
        $res = $res['last_id'];
        return $res;
    }

    public function AddReportName($report_name, $report_type_id, $lab_id) {

        $data = array('report_name' => $report_name, 'type_id' => $report_type_id, 'lab_id' => $lab_id);
        $res = $this->getManager()->insert($this->reports_name_table, $data, true);
        $res = $res['last_id'];
        return $res;
    }

    public function CheckLabAuth($lab_id, $ip) {

        $where = array('lab_id' => $lab_id, 'ip' => $ip);
        $res = $this->getManager()->select($this->auth_ips_table, '*', $where);
        if ($res['num_rows'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function CheckLabPassKey($data) {

        $where = array('keypass' => $data['privateKey'], 'passcode' => $data['passcode']);
        $res = $this->getManager()->select($this->lab_table, '*', $where);
        //$this->arr_print($res);
        if ($res['num_rows'] > 0) {
            return $res['rows'][0]->lab_id;
        } else {
            return false;
        }
    }

    public function CheckLab($data) {

        $where = array('phone' => $data['phone'], 'name' => $data['name']);
        $res = $this->getManager()->select($this->lab_table, '*', $where);
        //$this->arr_print($res);
        return $res['num_rows'];
    }

    public function CheckPatient($p_name = '', $phone = '', $email = '') {

        if (!empty($p_name) && !empty($phone) && !empty($email)) {
            $where = array('phone' => $phone, 'name' => $p_name, 'email' => $email);
            $res = $this->getManager()->select($this->patients_table, '*', $where);
        } else if (empty($p_name) && !empty($phone) && !empty($email)) {
            $qry = "select * from $this->patients_table where name IS NULL and phone ='" . $phone . "' and email = '" . $email . "'";
            $res = $this->getManager()->custom_query($qry);
        } else if (empty($p_name) && !empty($phone) && empty($email)) {
            $qry = "select * from $this->patients_table where name IS NULL and phone ='" . $phone . "' and email IS NULL";
            $res = $this->getManager()->custom_query($qry);
        } else if (!empty($p_name) && !empty($phone) && empty($email)) {
            $qry = "select * from $this->patients_table where name ='".$p_name."' and phone ='" . $phone . "' and email IS NULL";
            $res = $this->getManager()->custom_query($qry);
        }

        //$this->arr_print($res);
        return $res;
    }

    public function AddPatient($data) {

        $res = $this->getManager()->insert($this->patients_table, $data, true);
        $res = $res['last_id'];
        return $res;
    }

    public function selectPage($slug = '') {
        $where = 'false';
        if (!empty($slug)) {
            $where = array('slug' => $slug);
            $res = $this->getManager()->select($this->content_pages_table, '*', $where, array('id' => 'desc'));
            return $res['rows'][0];
        }
    }

    function arr_print($arr) {
        echo '<pre style="padding:20px">';
        print_r($arr);
        echo '</pre>';
    }

    public function getRows($data) {
        $where = array();
        foreach ($data as $key => $value) {
            $where[$key] = $value;
        }
//                print_r($where);
//                $where = array('phone' => $data['phone'], 'name' => $data['name'], 'email' => $data['email'] );
        if (sizeof($where) > 0) {
            $res = $this->getManager()->select($this->patients_table, '*', $where);
            //return $res;
            if ($res['num_rows'] > 0) {
                return $res['rows'][0]->p_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getReportById($p_id) {

        $where = array('p_id' => $p_id);
        $res = $this->getManager()->select($this->reports_table, '*', $where);
//                $this->arr_print($res);
        return $res;
//                if($res['num_rows']>0){
//                    return  $res['rows'][0]->p_id;
//                }else{
//                    return  false;
//                }
    }
    
    public function getAllPatients() {

        $where = array();
        $res = $this->getManager()->select($this->patients_table, '*', $where);
//                $this->arr_print($res);
        return $res;
//                if($res['num_rows']>0){
//                    return  $res['rows'][0]->p_id;
//                }else{
//                    return  false;
//                }
    }

}
