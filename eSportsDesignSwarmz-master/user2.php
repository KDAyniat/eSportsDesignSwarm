<?php
include_once("php_includes/check_login_status.php");
// Initialize any variables that the page might echo
$u = "";
$dorcdisplay = "Designer";
$userlevel = "";
$country = "";
$joindate = "";
$lastsession = "";
$profile_pic = "";
$profile_pic_btn = "";
$avatar_form = "";
$profile_header = "";
$profile_header_btn = "";
$header_form = "";

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
    $profile_pic_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'avatar_form\')">Upload Profile Pic</a>';
    $avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="php_includes/photo_system.php">';
    $avatar_form .=   '<h4>Change your avatar</h4>';
    $avatar_form .=   '<input type="file" name="avatar" required>';
    $avatar_form .=   '<p><input type="submit" value="Upload"></p>';
    $avatar_form .= '</form>';
    $profile_header_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'header_form\')">Upload Header</a>';
    $header_form  = '<form id="header_form" enctype="multipart/form-data" method="post" action="php_includes/header_system.php">';
    $header_form .=   '<h4>Change your header</h4>';
    $header_form .=   '<input type="file" name="header" required>';
    $header_form .=   '<p><input type="submit" value="Upload"></p>';
    $header_form .= '</form>';
    $usermsgs = '<li><a href="pm_inbox.php?u='.$log_username.'">Messages</a></li>';
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
    $profile_id = $row["id"];
    $dorc = $row["dorc"];
    $country = $row["country"];
    $userlevel = $row["userlevel"];
    $avatar = $row["avatar"];
    $header = $row["header"];
    $signup = $row["signup"];
    $lastlogin = $row["lastlogin"];
    $joindate = strftime("%b %d, %Y", strtotime($signup));
    $lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
}



// designer or client links on user page
$premium = '<li><a href="#">Premium</a></li>';
$portfolio = '<li><a href="#">Portfolio</a></li>';
$newjob = '';
if($dorc == "c"){
    $dorcdisplay = "Client";
    $portfolio = '';
    $newjob = '<li><a href="#">New Job</a></li>';
    $premium = '';
}



$profile_pic = '<img src="user/'.$u.'/'.$avatar.'" alt="'.$u.'" style="width:196px; height:196px;">';
if($avatar == NULL){
    $profile_pic = '<img src="images/Profiledefault.jpg" alt="'.$user1.'">';
}

$header_pic = '<img src="user/'.$u.'/'.$header.'" alt="'.$u.'" >';
if($header == NULL){
    $header_pic = '<img src="images/Profileheaderdefault.jpg" alt="'.$user1.'" style="width:100% ; margin:auto;">';
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
$message_button = '';
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
    <title>eSports Design Swarm - <?php echo $u; ?></title>
    <link rel="icon" type="image/png" href="images/favicon.png">

    <link href="profile.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Orbitron:400,500,700,900' rel='stylesheet' type='text/css'>
    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/login.js"></script>
    <script src="js/expand_retract.js"></script>
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
    <style type="text/css">
        div#profile_pic_box{float:right; border:green 2px solid; width:200px; height:200px; }
        div#profile_pic_box > img{z-index:2000; width:200px;}
        div#profile_pic_box > a {
            display: none;
            position:absolute;
            margin:140px 0px 0px 120px;
            z-index:4000;
            background:#D8F08E;
            border:#81A332 1px solid;
            border-radius:3px;
            padding:5px;
            font-size:12px;
            text-decoration:none;
            color:#60750B;
        }
        div#profile_pic_box > form{
            display:none;
            position:absolute;
            z-index:3000;
            padding:10px;
            opacity:.8;
            background:#F0FEC2;
            width:180px;
            height:180px;
        }
        div#profile_pic_box:hover a {
            display: block;
        }

        div#header_pic_box{float:right; 2px solid; width:800px; height:250px; }
        div#header_pic_box > img{z-index:2000; width:800px;}
        div#header_pic_box > a {
            display: none;
            position:absolute;
            margin:140px 0px 0px 120px;
            z-index:4000;
            background:#D8F08E;
            border:#81A332 1px solid;
            border-radius:3px;
            padding:5px;
            font-size:12px;
            text-decoration:none;
            color:#60750B;
        }
        div#header_pic_box > form{
            display:none;
            position:absolute;
            z-index:3000;
            padding:10px;
            opacity:.8;
            background:#F0FEC2;
            width:180px;
            height:180px;
        }
        div#header_pic_box:hover a {
            display: block;
        }
        body {
            background-color: #f5f5f5;
            font-family: 'orbitron', sans-serif;
            margin-bottom:70px;
            margin-top:70px;

        }

    </style>
</head>
<body style="padding-bottom: 70px; padding-top: 70px">
<?php include_once("php_includes/user2PageTop.php"); ?>




<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
<script src="js/pm.js"></script>
</body>
</html>

