<?php
include_once("check_login_status.php");
// If the page requestor is not logged in, usher them away
if($user_ok != true || $log_username == ""){
    header("location: http://www.esportsdesignswarm.com");
    exit();
}
$notification_list = "";
$sql = "SELECT * FROM notifications WHERE username LIKE BINARY '$log_username' ORDER BY date_time DESC";
$query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($query);
if($numrows < 1){
    $notification_list = "You do not have any notifications";
} else {
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $noteid = $row["id"];
        $initiator = $row["initiator"];
        $app = $row["app"];
        $note = $row["note"];
        $date_time = $row["date_time"];
        $date_time = strftime("%b %d, %Y", strtotime($date_time));
        $notification_list .= "<p><a href='../user.php?u=$initiator'>$initiator</a> | $app<br />$note</p>";
    }
}
mysqli_query($db_conx, "UPDATE users SET notescheck=now() WHERE username='$log_username' LIMIT 1");
?>