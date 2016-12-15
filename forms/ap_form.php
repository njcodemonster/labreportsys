<?php
include("../functions.php");
$obj = new SiteFunctions();
$res = $obj->getAllPatients();
?>
<form action="../ap.php" method="POST" enctype= "multipart/form-data">
    PrivateKey : <input type="text" name="PrivateKey" value="6dde1e8317ab07d722c02b3bdba8d5a4" >
    <br><br>
    Passcode : <input type="text" name="Passcode" value="1234" >
    <br><br>
    <?php
    if ($res['num_rows'] > 0) {
        ?>
        Patient :<select name="patient_id" id="patient_id">    
            <?php foreach ($res['rows'] as $key => $value) { ?>
                <option value="<?php echo $value->p_id; ?>"><?php echo $value->name; ?></option>
            <?php }
            ?>
        </select>
        <?php
    }
    ?>
    <br><br>
    Report Name : <input type="text" name="report_name" id="report_name" >
    <br><br>
    <input type="file" name="file">
    <br><br>
    <br><input type="submit" value="Submit">
</form>
