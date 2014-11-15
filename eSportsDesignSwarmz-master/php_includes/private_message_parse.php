<?php


$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);

/* if(!isset($_SESSION['wipit']) || !isset($_SESSION['userid'])){
    echo 'Your session has expired please refresh your browser and continue';
    exit();
}
else if ($_SESSION['id'] != $_POST['senderID']){
    echo 'Forged Submission';
}
else if ($sessWipit != $thisWipit){
    echo 'Forged Submission';
    exit();
}
else if ($thisWipit =="" || $sessWipit == ""){
    echo 'Missing Data';
    exit();
}
*/
include_once "db_connects.php";
$checkuserid = $_POST['senderID'];
$prevent_dp = mysql_query($db_conx,"SELECT id FROM private_messages WHERE from_id='$checkuserid' AND time_spent between subtime(now(),'0:0:20') and now()");
$nr = mysql_num_rows($prevent_dp);
if($nr > 0){
    echo 'You must wait 20 seconds between messages';
    exit();
}
$sql = mysql_query($db_conx,"SELECT id FROM private_messages WHERE from_id='$checkuserid' AND DATE(time_sent) = DATE(NOW())LIMIT 40");
$numRows = mysql_num_rows($sql);
if($numRows > 30){
    echo 'you can only send 30 messages per day';
    exit();
}


$page_output="";

if(isset($_POST['message'])){
    $to = ($_POST['rcpntID']);
    $from = ($_POST['senderID']);
    $toName = ($_POST['rcpntName']);
    $fromName = ($_POST['senderName']);
    $sub = htmlspecialchars($_POST['subject']);
    $msg = htmlspecialchars($_POST['message']);


    if(empty($to) || empty($from) || empty($toName) || empty($fromName) || empty($sub) || empty($msg)){
        echo 'Missing data';

        exit();
    } else {
        $sqldeleteTail = mysql_query($db_conx,"SELECT * FROM private_messages WHERE to_id = '$to' ORDER BY time_sent DESC LIMIT 0,100");
        $dci = 1;
        while($row = mysql_fetch_array($sqldeleteTail)){
            $pm_id = $row["id"];
            if($dci > 99){
                $deleteTail = mysql_query("DELETE FROM private_messages WHERE id='$pm_id'");
            }
            $dci++;
        }

        $sql = "INSERT INTO private_messages (to_id, from_id, time_sent, subject, message) VALUES('$to','$from',now(),'$sub','$msg')";
        $query = mysqli_query($db_conx, $sql);
        if(!$query){
            echo 'Could not send message, database input error';
            exit();
        } else {
            echo 'message sent';
            exit();
        }
    }

}

?>