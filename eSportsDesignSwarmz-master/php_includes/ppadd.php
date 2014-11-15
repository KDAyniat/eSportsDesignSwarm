<?php include_once("db_connects.php");


if(isset($_POST["ppadd"])){
    $ppadd = mysqli_real_escape_string($db_conx,$_POST['ppadd']);

    $sql = "UPDATE users SET paypal='.$ppadd' WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);

echo "ppadd_success";
    exit();
}

?>