<?php
include("functions.php");
$obj = new SiteFunctions();
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";

$status = false;
$error = 0;
$private_key = '';
$data = array();

if(!empty($phone) && !empty($name) && !empty($email)){
    $get_data = array('phone' => $phone,'name' => $name, 'email' => $email);    // phone && name && email
}else if(!empty($phone) && empty($name) && !empty($email)){
    $get_data = array('phone' => $phone, 'email' => $email);                    // phone && email
}else if(!empty($phone) && !empty($name) && empty($email)){
    $get_data = array('phone' => $phone,'name' => $name);                       // phone && name
}else if(empty($phone) && !empty($name) && !empty($email)){
    $get_data = array('name' => $name, 'email' => $email);                      // name && email
}else if(empty($phone) && empty($name) && !empty($email)){
    $get_data = array('email' => $email);                                       // only email
}else if(!empty($phone) && empty($name) && empty($email)){
    $get_data = array('phone' => $phone);                                       // only phone
}else{
    $get_data = array();                                                        // empty
}
if(sizeof($get_data) > 0){
$result = $obj->getRows($get_data);
    if (is_numeric($result)) {
        $MasterKey = $obj->GetMasterKey();
        if ($MasterKey == $_POST['masterKey']) {
            $rec = $obj->getReportById($result);
            $key =   md5(microtime().rand());
            
            $status = true;
            $data = $rec;
            $private_key = $key;
        } else {
            $error = "Master Key did not match.";
        }
    } else {
        $error = "Name, Email & Phone does not exists.";
    }
}else{
    $error = "You Should fill Phone or Email with Name.";
}
$return = array('status' => $status, 'private key' => $private_key, 'error' => $error, 'data' => $data);
$log  = "user: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "status: ".$status.PHP_EOL.
        "error: ".$error.PHP_EOL.
        "private_key: ".$private_key.PHP_EOL.
        "action: View Records".PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
print_r(json_encode($return));

?>