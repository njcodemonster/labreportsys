<?php
include("functions.php");
$obj = new SiteFunctions();

$status = false;
$error = 0;
$success = "";
$warning = "";

if (isset($_POST['PrivateKey']) && isset($_POST['Passcode']) && isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])) {

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
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $status = true;
                $success = "Patient data submitted.";
                
                
            } else if (empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && !empty($_POST['email'])) {

                $p_check = $obj->CheckPatient(null, $_POST['phoneNumber'], $_POST['email']);
                $p_data = array('name' => '', 'phone' => $_POST['phoneNumber'], 'email' => $_POST['email']);

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $patient_id;
                $status = true;
                $success = "Patient data submitted.";
            } else if (empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && empty($_POST['email'])) {

                $p_check = $obj->CheckPatient(null, $_POST['phoneNumber'], null);
                $p_data = array('name' => '', 'phone' => $_POST['phoneNumber'], 'email' => '');

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $patient_id;
                $status = true;
                $success = "Patient data submitted.";
                $warning = "You did not enter the email.";
                
            } else if (!empty($_POST['PatientName']) && !empty($_POST['phoneNumber']) && empty($_POST['email'])) {

                $p_check = $obj->CheckPatient($_POST['PatientName'], $_POST['phoneNumber'], null);
                $p_data = array('name' => $_POST['PatientName'], 'phone' => $_POST['phoneNumber'], 'email' => '');

                if ($p_check['num_rows'] < 1) {
                    $patient_id = $obj->AddPatient($p_data);
                } else {
                    $patient_id = $p_check['rows'][0]->p_id;
                }
                $patient_id;
                $status = true;
                $success = "Patient data submitted.";
                $warning = "You did not enter the email.";
            }


            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {

                // settings
                $thumb_img = $_FILES['file'];
                $max_file_size = 1024 * 3000; // 900kb 3mb
                $valid_exts = array('docx', 'doc', 'pdf');

                // get file extension
                $ext = strtolower(pathinfo($thumb_img['name'], PATHINFO_EXTENSION));

                if (in_array($ext, $valid_exts)) {
                    /* resize image */
                    $uniqId = time() . uniqid(5) . "." . $ext;
                    $fPath = 'reports/' . $uniqId;
                    $filename = $uniqId;
                    $thumb_name = $uniqId;
                    $aa = "reports/" . $uniqId;
                    move_uploaded_file($thumb_img['tmp_name'], $aa);

                    //Insert Report
                    $report_type_id = $obj->AddReportType($patient_id, $filename);

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
                    $warning .= "Unsupported file.";
                    
//              $msg = 'Unsupported file';
                    //$return = array('status' => false, 'error' => "Unsupported file.");
                }
            }else{
                
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
    $error = "PrivateKey or Passcode did not match.";
    //$return = array('status' => false, 'error' => "PrivateKey or Passcode did not match.");
//    print_r(json_encode($return));
}
$return = array('status' => $status, 'error' => $error, 'success' => $success, 'warning' => $warning);
$log  = "user: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "status: ".$status.PHP_EOL.
        "error: ".$error.PHP_EOL.
        "success: ".$success.PHP_EOL.
        "warning: ".$warning.PHP_EOL.
        "action: Adding Report".PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
print_r(json_encode($return));
?>