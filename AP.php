<?php
include("functions.php");

$obj = new SiteFunctions();

$status = false;
$error = 0;
$success = "";
$warning = "";

if (isset($_POST['PrivateKey']) && isset($_POST['Passcode'])) {

    //check Private key & Passcode

    $ip = $_SERVER['REMOTE_ADDR'];
    $auth_data = array('privateKey' => $_POST['PrivateKey'], 'passcode' => $_POST['Passcode']);
    
    $lab_id = $obj->CheckLabPassKey($auth_data);
    if ($lab_id) {
        $flag = $obj->CheckLabAuth($lab_id, $ip);
        if ($flag === true) {

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
                    $patient_id = $_POST['patient_id'];
                    $report_name = $_POST['report_name'];
                    //Insert Report
                    $report_type_id = $obj->AddReportType($patient_id, $filename);

                    //$lab_id.$patient_id.$report_type_id
                    $obj->AddReportName($report_name, $report_type_id, $lab_id);
                    if (!empty($report_name)) {
                        $status = true;
                        $success .= "Document uploaded.";
                    } else {
                        $status = true;
                        $warning .= "Document uploaded with empty name.";
                    }
                } else {
                    $error = "Unsupported file.";
                }
            }else{
                
                $status = true;
                $warning .= "You did not upload the file.";
            }
        } else {
            // Authantication failed
            $error = "Authantication failed.";
        }
    } else {
        // Passcode & Private key dosen't match
        $error = "PrivateKey or Passcode did not match.";
    }
} else {
    $error = "PrivateKey or Passcode did not match.";
}
$return = array('status' => $status, 'error' => $error, 'success' => $success, 'warning' => $warning);
print_r(json_encode($return));
?>