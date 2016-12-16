<?php
if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
    // settings
    $thumb_img = $_FILES['file'];
    $max_file_size = 1024 * 3000; // 900kb 3mb
    $valid_exts = array('docx', 'doc', 'pdf');

    // get file extension
    $ext = strtolower(pathinfo($thumb_img['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $valid_exts)) {
        echo "<pre>";
        print_r($_FILES);
//        $fh = file_get_contents($_FILES['file']['tmp_name']);
        $myhash = md5_file($_FILES['file']['tmp_name']);
        echo $myhash;
        
        /* resize image */
//        $uniqId = time() . uniqid(5) . "." . $ext;
//        $fPath = 'reports/' . $uniqId;
//        $filename = $uniqId;
//        $thumb_name = $uniqId;
//        $aa = "reports/" . $uniqId;
//        move_uploaded_file($thumb_img['tmp_name'], $aa);
    } else {
        echo "Unsupported file.";
    }
}
?>

<html>
    <body>
        <form action="file_upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </body>