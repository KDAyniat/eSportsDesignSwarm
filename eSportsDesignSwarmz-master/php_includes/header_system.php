<?php
include_once("check_login_status.php");
if($user_ok != true || $log_username == "") {
    exit();
}
?><?php
if (isset($_FILES["header"]["name"]) && $_FILES["header"]["tmp_name"] != ""){
    $fileName = $_FILES["header"]["name"];
    $fileTmpLoc = $_FILES["header"]["tmp_name"];
    $fileType = $_FILES["header"]["type"];
    $fileSize = $_FILES["header"]["size"];
    $fileErrorMsg = $_FILES["header"]["error"];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);
    list($width, $height) = getimagesize($fileTmpLoc);
    if($width < 10 || $height < 10){
        header("location: ../message.php?msg=ERROR: That image has no dimensions");
        exit();
    }
    $db_file_name = rand(100000000000,999999999999).".".$fileExt;
    if($fileSize > 3000000) {
        header("location: ../message.php?msg=ERROR: Your image file was larger than 1mb");
        exit();
    } else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
        header("location: ../message.php?msg=ERROR: Your image file was not jpg, gif or png type");
        exit();
    } else if ($fileErrorMsg == 1) {
        header("location: ../message.php?msg=ERROR: An unknown error occurred");
        exit();
    }
    $sql = "SELECT header FROM users WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $header = $row[0];
    if($header != ""){
        $picurl = "../user/$log_username/$header";
        if (file_exists($picurl)) { unlink($picurl); }
    }
    $moveResult = move_uploaded_file($fileTmpLoc, "../user/$log_username/$db_file_name");
    if ($moveResult != true) {
        header("location: ../message.php?msg=ERROR: File upload failed");
        exit();
    }
   // include_once("image_resize.php");
    $target_file = "../user/$log_username/$db_file_name";
    $resized_file = "../user/$log_username/$db_file_name";
    $wmax = 800;
    $hmax = 300;
   // img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
    $sql = "UPDATE users SET header='$db_file_name' WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    mysqli_close($db_conx);
    header("location: ../user.php?u=$log_username");
    exit();
}
?>