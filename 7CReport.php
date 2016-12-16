<?php

include("functions.php");
$obj = new SiteFunctions();

$status = false;
$error = 0;
$success = "";
$warning = "";

if (!empty($_POST['PrivateKey']) && !empty($_POST['Passcode']) && !empty($_POST['phoneNumber'])) {

    $report_name = $_POST['reportName'];

    //check Private key & Passcode

    $ip = $_SERVER['REMOTE_ADDR'];
    $auth_data = array('privateKey' => $_POST['PrivateKey'], 'passcode' => $_POST['Passcode']);

    $lab_id = $obj->CheckLabPassKey($auth_data);
    if ($lab_id) {
        $ret = $obj->CheckLabAuth($lab_id, $ip);
        if ($ret == true) {

            if (!empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && !empty($_POST['email'])) {

                $p_check = $obj->CheckPatient($_POST['PatientName'], $_POST['phoneNumber'], $_POST['email']);
                $p_data = array('name' => $_POST['PatientName'], 'phone' => $_POST['phoneNumber'], 'email' => $_POST['email']);

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                    $success = "Patient data submitted.";
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                    $warning = "Patient data already exist.";
                }
                $status = true;
            } else if (empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && !empty($_POST['email'])) {

                $p_check = $obj->CheckPatient(null, $_POST['phoneNumber'], $_POST['email']);
                $p_data = array('name' => '', 'phone' => $_POST['phoneNumber'], 'email' => $_POST['email']);

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                    $success = "Patient data submitted.";
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                    $warning = "Patient data already exist.";
                }
                $patient_id;
                $status = true;
            } else if (empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && empty($_POST['email'])) {

                $p_check = $obj->CheckPatient(null, $_POST['phoneNumber'], null);
                $p_data = array('name' => '', 'phone' => $_POST['phoneNumber'], 'email' => '');

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                    $success = "Patient data submitted.";
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $patient_id;
                $status = true;
                $warning = "You did not enter the email.";
            } else if (!empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && empty($_POST['email'])) {

                $p_check = $obj->CheckPatient($_POST['PatientName'], $_POST['phoneNumber'], null);
                $p_data = array('name' => $_POST['PatientName'], 'phone' => $_POST['phoneNumber'], 'email' => '');

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                    $success = "Patient data submitted.";
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $patient_id;
                $status = true;
                $warning = "You did not enter the email.";
            }


            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {

                // settings
                $report_file = $_FILES['file'];
                $max_file_size = 1024 * 3000; // 900kb 3mb
                $valid_exts = array('docx', 'doc', 'pdf');

                // get file extension
                $ext = strtolower(pathinfo($report_file['name'], PATHINFO_EXTENSION));

                if (in_array($ext, $valid_exts)) {
                    /* resize image */
                    $file_hash = md5_file($report_file['tmp_name']);

                    $is_report_exist = $obj->CheckReportByPatientId($patient_id, $file_hash);
                    if ($is_report_exist === true) {
                        $output = $obj->folder_exist('reports/'.$lab_id);
                        if($output === false){
                            mkdir('reports/'.$lab_id);
                            $folder_dist = 'reports/'.$lab_id. '/';
                        }else{
                            $folder_dist = 'reports/'.$lab_id. '/';
                        }
//                        echo "output : ".$output;
                        
                        $uniqId = $patient_id . "_" .time() . "." . $ext;
                        $fPath = $folder_dist . $uniqId;
                        $filename = $uniqId;
                        $thumb_name = $uniqId;
                        $aa = $folder_dist . $uniqId;
                        move_uploaded_file($report_file['tmp_name'], $aa);

                        //Insert Report
                        $report_type_id = $obj->AddReportType($patient_id, $filename, $file_hash);

                        //$lab_id.$patient_id.$report_type_id
                        $obj->AddReportName($report_name, $report_type_id, $lab_id);
                        if (!empty($_POST['email'])) {
                            $status = true;
                            $success .= "Document uploaded.";
                            //$return = array('status' => true, 'error' => 0, 'msg' => "Document uploaded.");
                        } else {
                            $status = true;
                            $warning .= "Document uploaded with no Email";
                            //$return = array('status' => true, 'error' => 0, 'warning' => "Document uploaded with no Email", 'msg' => "Document uploaded.");
                        }
                    } else {
                        $error = "The same report of this patient already exist.";
                    }
                } else {
                    $warning .= "Unsupported file.";

//              $msg = 'Unsupported file';
                    //$return = array('status' => false, 'error' => "Unsupported file.");
                }
            } else {

                $status = true;
                $warning .= "You did not upload the file.";
            }
        } else {
            // Authantication failed
            $error = "Authantication failed.";
            //$return = array('status' => false, 'error' => "Authantication failed.");
//            print_r(json_encode($return));
        }
    } else {
        // Passcode & Private key dosen't match
        $error = "PrivateKey or Passcode did not match.";
        //$return = array('status' => false, 'error' => "PrivateKey or Passcode did not match.");
//        print_r(json_encode($return));
    }
} else {
    $error = "PrivateKey or Passcode or Phone number is empty.";
    //$return = array('status' => false, 'error' => "PrivateKey or Passcode did not match.");
//    print_r(json_encode($return));
}
$return = array('status' => $status, 'error' => $error, 'success' => $success, 'warning' => $warning);
$log = "user: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
        "status: " . $status . PHP_EOL .
        "error: " . $error . PHP_EOL .
        "success: " . $success . PHP_EOL .
        "warning: " . $warning . PHP_EOL .
        "action: Adding Report" . PHP_EOL .
        "-------------------------" . PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('log_' . date("j.n.Y") . '.txt', $log, FILE_APPEND);
print_r(json_encode($return));
?>