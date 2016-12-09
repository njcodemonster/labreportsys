<?php  include("functions.php");
$obj = new SiteFunctions();

$status = false;
$error = 0;
$private_key = '';

if(isset($_POST['labName']) && isset($_POST['labPhone']) && !empty($_POST['labPhone'])){
        
    $data['name']           =   $_POST['labName'];
    $data['phone']          =   $_POST['labPhone'];
    $data['contact_person'] =   $_POST['contactPersonName'];
    $data['passcode']       =   $_POST['labSelectedPasscode'];
    $key                    =   md5(microtime().rand());
    $data['keypass']       =   $key;
    
    $check_data = array('phone'=>$_POST['labPhone'], 'name'=>$_POST['labName']);
    $check = $obj->CheckLab($check_data);
    
    if($check < 1){
        
        $MasterKey = $obj->GetMasterKey();
            
        if($MasterKey == $_POST['masterKey']){
        
            $lab_id =  $obj->InsertLab($data);
            
            $status = true;
            $private_key = $key;
            
            $AuthData['ip'] = $_SERVER['REMOTE_ADDR'];
            $AuthData['lab_id'] = $lab_id;
            
            $obj->AuthLab($AuthData);
            
        }else {
                $error = "Master Key did not match.";
            }
            
    }else {
        $error = "Lab Name & Phone already exists.";
    }
    
}else {
    $error = "Lab Name & Phone is empty.";
}
$return = array('status'=> $status, 'private key'=> $private_key, 'error'=> $error );
$log  = "user: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "status: ".$status.PHP_EOL.
        "error: ".$error.PHP_EOL.
        "private_key: ".$private_key.PHP_EOL.
        "action: Create New Lab".PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
print_r(json_encode($return));
?>