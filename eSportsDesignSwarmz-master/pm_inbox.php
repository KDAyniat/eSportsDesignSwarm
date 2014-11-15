
<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$mail = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
    $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: www.esportsdesignswarm.com");
    exit();
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
    echo "That user does not exist or is not yet activated, press back";
    exit();
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){$isOwner = "yes";}

 if($isOwner != "yes"){header("location: www.esportsdesignswarm.com");exit();}


// Get list of parent pm's not deleted
$sql = "SELECT * FROM pm WHERE
(receiver='$u' AND parent='x' AND rdelete='0')
OR
(sender='$u' AND sdelete='0' AND parent='x' AND hasreplies='1')
ORDER BY senttime DESC";
$query = mysqli_query($db_conx, $sql);
$statusnumrows = mysqli_num_rows($query);
// Gather data about parent pm's
if($statusnumrows > 0){
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $pmid = $row["id"];
        //div naming
        $pmid2 = 'pm_'.$pmid;
        $wrap = 'pm_wrap_'.$pmid;
        //button naming
        $btid2 = 'bt_'.$pmid;
        //textarea naming
        $rt = 'replytext_'.$pmid;
        //button naming
        $rb = 'replyBtn_'.$pmid;
        $receiver = $row["receiver"];
        $sender = $row["sender"];
        $subject = $row["subject"];
        $message = $row["message"];
        $time = $row["senttime"];
        $rread = $row["rread"];
        $sread = $row["sread"];

        // Start to build our list of parent pm's
        $mail .= '<div id="'.$wrap.'" class="pm_wrap">';
        $mail .= '<div class="pm_header"> <strong>From '.$sender. ': ' .$subject.'</strong><br /><br /></div>';
        // Add button for mark as read
        $mail .= '<div id="pm_rest"><div class="pm_btns"><button onclick="markRead(\''.$pmid.'\',\''.$sender.'\')">Mark As Read</button>';
        // Add Delete button
        $mail .= '<button id="'.$btid2.'" onclick="deletePm(\''.$pmid.'\',\''.$wrap.'\',\''.$sender.'\')">Delete</button></div>';
        $mail .= '<div id="'.$pmid2.'">';//start expanding area
        $mail .= '<div class="pm_post"><br />'.$message.'</div>';

        // Gather up any replies to the parent pm's
        $pm_replies = "";
        $query_replies = mysqli_query($db_conx, "SELECT sender, message, senttime FROM pm WHERE parent='$pmid' ORDER BY senttime ASC");
        $replynumrows = mysqli_num_rows($query_replies);
        if($replynumrows > 0){
            while ($row2 = mysqli_fetch_array($query_replies, MYSQLI_ASSOC)) {
                $rsender = $row2["sender"];
                $reply = $row2["message"];
                $time2 = $row2["senttime"];
                $mail .= '<div class ="pm_post">Reply From: '.$rsender.' on '.$time2.'....<br />'.$reply.'<br /></div>';
            }
        }
        // Each parent and child is now listed
        $mail .= '</div>';
        // Add reply textbox
        $mail .= '<textarea id="'.$rt.'" placeholder="Reply..."></textarea><br />';
        // Add reply button
        $mail .= '<button id="'.$rb.'" onclick="replyToPm('.$pmid.',\''.$u.'\',\''.$rt.'\',\''.$rb.'\',\''.$sender.'\')">Reply</button>';
        $mail .= '</div></div>';
    }
}

$badge_check = "SELECT wins, entries, first_place, second_place, third_place FROM badges WHERE username='$log_username' LIMIT 1";
$badge_query = mysqli_query($db_conx,$badge_check);

$badgerow = mysqli_fetch_row($badge_query);
$wins =  $badgerow[0];
$entries = $badgerow[1];
$first_place = $badgerow[2];
$second_place = $badgerow[3];
$third_place = $badgerow[4];

$badgemsg = '';
$winsbadge = '';
$entriesbadge = '';
$fpbadge = '<img src="images/badges/1stplace.png">';
$spbadge = '<img src="images/badges/2ndplace.png">';
$tpbadge = '<img src="images/badges/3rdplace.png">';



$badgecount = '0' ;






if($wins > 0 ){
    $winsbadge = '<img src="images/badges/1contestwin.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 4 ){
    $winsbadge = '<img src="images/badges/5winbadge.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 9){
    $winsbadge = '<img src="images/badges/10winbadge.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 19){
    $winsbadge = '<img src="images/badges/20winbadge.png" style="width:100px">';
    $badgecount++;
}

if($entries > 0 && $entries < 5){
    $entriesbadge = '<img src="images/badges/1stentrybadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 4 && $entries < 10){
    $entriesbadge = '<img src="images/badges/5entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 9 && $entries < 25){
    $entriesbadge = '<img src="images/badges/10entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 24 && $entries < 50){
    $entriesbadge = '<img src="images/badges/25entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 49 && $entries < 100){
    $entriesbadge = '<img src="images/badges/50entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 99 && $entries < 250){
    $entriesbadge = '<img src="images/badges/100entriesbadge.png" style="width:100px">';
    $badgecount++;
}else if ($entries > 249){
    $entriesbadge = '<img src="images/badges/250entriesbadge.png" style="width:100px">';
    $badgecount++;



}
if($badgecount == 1){
    $badgemsg = 'You Have 1 Badge!';
} else {
$badgemsg = 'You Have '.$badgecount.' Badges!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>eSports Design Swarm - <?php echo $u; ?></title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="profile.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Orbitron:400,500,700,900' rel='stylesheet' type='text/css'>
    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/login.js"></script>
    <script src="js/expand_retract.js"></script>
    <script src="js/pm.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>
<body style="padding-bottom: 70px; padding-top: 70px">

<?php include_once("php_includes/userPageTop.php"); ?>
<div style="text-align: center; margin:auto;">
<?php echo $msgs;?>

</div>
<?php echo $mail; ?>

<?php include_once("php_includes/pageBottom.php"); ?>
<div class="modal fade" id="badges" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class= "modal-header">
                <h3 style="text-align: center;"><strong><?php echo $badgemsg;?></strong> </h3>

            </div>
            <div class="modal-body" id="badges">

                <?php echo $winsbadge;?>
                <?php echo $entriesbadge;?>


            </div>

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>


</body>
</html>