<?php
include_once("check_login_status.php");
?><?php


if (isset($_FILES["photo"]["name"]) && isset($_POST["jobid"])){
    $job_id = preg_replace('#[^a-z 0-9,]#i', '',$_POST['jobid']);
    $sql = "SELECT COUNT(id) FROM submission WHERE submitted_by='$log_username' AND job_id='$job_id'";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    if($row[0] > 14){
        header("location: ../message.php?msg=This beta system allows only 15 pictures total");
        exit();
    }


    $fileName = $_FILES["photo"]["name"];
    $fileTmpLoc = $_FILES["photo"]["tmp_name"];
    $fileType = $_FILES["photo"]["type"];
    $fileSize = $_FILES["photo"]["size"];
    $fileErrorMsg = $_FILES["photo"]["error"];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);
    $db_file_name = date("DMjGisY")."".rand(1000,9999).".".$fileExt; // WedFeb272120452013RAND.jpg
    list($width, $height) = getimagesize($fileTmpLoc);
    if($width < 10 || $height < 10){
        header("location: ../message.php?msg=ERROR: That image has no dimensions");
        exit();
    }
    if($fileSize > 300000000000) {
        header("location: ../message.php?msg=ERROR: Your image file was larger than 300mb");
        exit();
    } else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
        header("location: ../message.php?msg=ERROR: Your image file was not jpg, gif or png type");
        exit();
    } else if ($fileErrorMsg == 1) {
        header("location: ../message.php?msg=ERROR: An unknown error occurred");
        exit();
    }

    $moveResult = move_uploaded_file($fileTmpLoc, "../user/$log_username/jobs/$job_id/$db_file_name");
    if ($moveResult != true) {
        header("location: ../message.php?msg=ERROR: File upload failed");
        exit();
    }
    // include_once("image_resize.php");
    $wmax = 1200;
    $hmax = 1200;
    if($width > $wmax || $height > $hmax){
        $target_file = "../user/$log_username/jobs/$db_file_name";
        $resized_file = "../user/$log_username/jobs/$db_file_name";
        // img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
    }
    $sql = "INSERT INTO submission(submitted_by, job_id, filename, uploaddate) VALUES ('$log_username','$job_id','$db_file_name',now())";
    $query = mysqli_query($db_conx, $sql);
    mysqli_close($db_conx);
    header("location: ../viewjob.php?id=$job_id");
    exit();
}
?><?php
if (isset($_POST["delete"]) && $_POST["id"] != ""){
    $id = preg_replace('#[^0-9]#', '', $_POST["id"]);
    $query = mysqli_query($db_conx, "SELECT submitted_by, filename FROM submission WHERE id='$id' LIMIT 1");
    $row = mysqli_fetch_row($query);
    $user = $row[0];
    $filename = $row[1];
    if($user == $log_username){
        $picurl = "../user/$log_username/jobs/$job_id/$filename";
        if (file_exists($picurl)) {
            unlink($picurl);
            $sql = "DELETE FROM submission WHERE id='$id' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
        }
    }
    mysqli_close($db_conx);
    echo "deleted_ok";
    exit();
}
?>