<?php
include_once("php_includes/db_connects.php");
$sql = "INSERT INTO badges (username, wins, entries, first_place, second_place, third_place, last_badge)
VALUES('kdoughty',1, 20, 1, 2, 3,now())";
$query = mysqli_query($db_conx, $sql);

?>