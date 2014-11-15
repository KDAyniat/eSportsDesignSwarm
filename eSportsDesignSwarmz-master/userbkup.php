<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$dorcdisplay = "Designer";
$userlevel = "";
$country = "";
$joindate = "";
$lastsession = "";
$thisRandNum = rand(0,1000);
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: http://www.esportsdesignswarm.com");
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
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
	$dorc = $row["dorc"];
	$country = $row["country"];
	$userlevel = $row["userlevel"];
	$signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
	if($dorc == "c"){
		$dorcdisplay = "Client";
	}
}
?>
<?php
$ownerBlockViewer = false;
$viewerBlockOwner = false;
if($u != $log_username && $user_ok == true){
    $block_check1 = "SELECT id FROM blockedusers WHERE blocker='$u' AND blockee='$log_username' LIMIT 1";
    if(mysqli_num_rows(mysqli_query($db_conx, $block_check1)) > 0){
        $ownerBlockViewer = true;
    }
    $block_check2 = "SELECT id FROM blockedusers WHERE blocker='$log_username' AND blockee='$u' LIMIT 1";
    if(mysqli_num_rows(mysqli_query($db_conx, $block_check2)) > 0){
        $viewerBlockOwner = true;
    }
}
?>

<?php
$block_button = '<button disabled>Block User</button>';
// LOGIC FOR BLOCK BUTTON
if($viewerBlockOwner == true){
    $block_button = '<button onclick="blockToggle(\'unblock\',\''.$u.'\',\'blockBtn\')">Unblock User</button>';
} else if($user_ok == true && $u != $log_username){
    $block_button = '<button onclick="blockToggle(\'block\',\''.$u.'\',\'blockBtn\')">Block User</button>';
} else if ($isOwner == "yes"){
    $block_button = '';
}
?>
<?php
$message_status = '';
$message_button = '<button> Send Message</button>';
if ($viewerBlockOwner == true){
    $message_status = 'You must unblock this user before you can send them a message';
    $message_button = '';
    } else if ($ownerBlockViewer == true){
    $message_status = 'You have been blocked by this user';
    $message_button = '';
} else if ($isOwner == "yes"){
    $message_button = '';
    $message_status = '';
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
    <link href="main.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Orbitron:400,500,700,900' rel='stylesheet' type='text/css'>
       <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/login.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        function blockToggle(type,blockee,elem){
            var conf = confirm("Press OK to confirm the '"+type+"' action on user <?php echo $u; ?>.");
            if(conf != true){
                return false;
            }
            var elem = document.getElementById(elem);
            elem.innerHTML = 'please wait ...';
            var ajax = ajaxObj("POST", "php_includes/block_system.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == "blocked_ok"){
                        elem.innerHTML = '<button onclick="blockToggle(\'unblock\',\'<?php echo $u; ?>\',\'blockBtn\')">Unblock User</button>';
                    } else if(ajax.responseText == "unblocked_ok"){
                        elem.innerHTML = '<button onclick="blockToggle(\'block\',\'<?php echo $u; ?>\',\'blockBtn\')">Block User</button>';
                    } else {
                        alert(ajax.responseText);
                        elem.innerHTML = 'Try again later';
                    }
                }
            }
            ajax.send("type="+type+"&blockee="+blockee);
        }


    </script>
</head>
<body style="padding-bottom: 70px; padding-top: 70px">

<?php include_once("php_includes/userPageTop.php"); ?>
       <div class="container">
         <h3><?php echo $u; ?></h3>
         <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
         <p>Designer or Client: <?php echo $dorcdisplay; ?></p>
         <p>Country: <?php echo $country; ?></p>
         <p>User Level: <?php echo $userlevel; ?></p>
         <p>Join Date: <?php echo $joindate; ?></p>
         <p>Last Session: <?php echo $lastsession; ?></p>
           <hr />
           <p> <span id="blockBtn"><?php echo $block_button; ?></span></p><br/>

           <div id="interactionResults"> <?php echo $_SESSION['userid'];?> || <?php echo $_SESSION['username'];?> || <?php echo $profile_id;?> || <?php echo $u;?> || <?php echo $thisRandNum;?></div>
           <form action="javascript:sendPM()" name="pmForm" id="pmForm" method="post">
               Sending Private Message to <strong><em><?php echo "$u";?></em></strong><br/>
               Subject:
               <input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%" />
               Message:
               <textarea name="pmTextArea" id="pmTextArea" rows="8" style="width:98%" ></textarea>
               <input name="pm_sender_id" id="pm_sender_id" type="hidden" value="<?php echo $_SESSION['userid'];?>"/>
               <input name="pm_sender_name" id="pm_sender_name" type="hidden" value="<?php echo $_SESSION['username'];?>"/>
               <input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $profile_id;?>"/>
               <input name="pm_rec_name" id="pm_rec_name" type="hidden" value="<?php echo $u;?>"/>
               <input name="pmWipit" id="pmWipit" type="hidden" value="<?php echo $thisRandNum;?>"/>
               <span id="PMStatus" style="color #F00"></span><br/>
               <input name="pmSubmit" type="submit" value="Submit"/> or <a href="#" onclick="return false" data-dismiss="modal">Close</a>

           </form>

           <p> <?php echo $message_status;?><span id="msgBtn"><?php echo $message_button;?></span></p>
       </div>

<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>

