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
$premiumtoggle = "";

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
if (!file_exists("user/$u/jobs")) {
    mkdir("user/$u/jobs", 0755);
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";
    $profile_pic_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'avatar_form\')">Upload Profile Pic</a>';
    $avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="php_includes/photo_system.php">';
    $avatar_form .=   '<h4>Change your avatar</h4>';
    $avatar_form .=   '<p><input type="file" name="avatar" required></p>';
    $avatar_form .=   '<p><input type="submit" value="Upload"></p>';
    $avatar_form .= '</form>';
    $profile_header_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'header_form\')">Upload Header</a>';
    $header_form  = '<form id="header_form" enctype="multipart/form-data" method="post" action="php_includes/header_system.php">';
    $header_form .=   '<h4>Change your header</h4>';
    $header_form .=   '<p><input type="file" name="header" required></p>';
    $header_form .=   '<p><input type="submit" value="Upload"></p>';
    $header_form .= '</form>';
    $usermsgs = '<li><a href="pm_inbox.php?u='.$log_username.'">Messages</a></li>';
    $myjobsbb = '<a href="myjobs.php?u='.$u.'" ><img  src="images/profilebuttonmyjobsbig.png" alt="badges"></a><br/>';
    $ppadd = '<div id="ppadd">
    <h4>Add Your PayPal Email Here</h4>
    <form onsubmit="return false" role="form">
        <label for="ppadd">
        <input type="email" id="ppadd" value="" placeholder="Enter PayPal Email">
        </label>
        <button id="ppaddbtn" type="submit" onclick="emailupdate()">Add Paypal Email!</button>
        <span id="updatestatus"></span>
    </form>
</div>';
} else {
    $myjobsbb = '';
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
    $premiumtoggle = $row["premium"];
    $joindate = strftime("%b %d, %Y", strtotime($signup));
    $lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
}



  // designer or client links on user page
    $gotfiles = '';
    $premium = '<li><a href="#">Premium</a></li>';
    $portfolio = '<li><a href="portfolio.php?u='.$u.'">Portfolio</a></li>';
    $portfoliobb = '<a href="portfolio.php?u='.$u.'" ><img  src="images/profilebuttonportfoliobig.png" alt="badges"></a><br/>';
    $newjob = '';
    $rulesbb = '<a href="rules.php"><img  src="images/profilebuttonrules.png" alt="badges"></a><br/>';
    $jobbb = '<a href="viewjobs.php" ><img src="images/profilebuttonjobs.png" alt="badges"></a><br/>';
    $messagesbb = '<a href="pm_inbox.php?u='.$u.'"><img  src="images/profilebuttonmessages.png" alt="badges"></a><br/>';

    $violation = '<a href="#"><img src="images/reportviolationbutton.png" alt="violation"></a><br/>';
	if($dorc == "c"){
		$dorcdisplay = "Client";
        $portfolio = '';
        $newjob = '<li><a href="jobs.php">New Job</a></li>';
        $premium = '';
        $portfoliobb = '';
        $rulesbb = '<a href="clientrules.php"><img  src="images/profilebuttonrules.png" alt="badges"></a><br/>';
        $jobbb = '<a href="jobs.php" ><img src="images/profilebuttonstartjob.png" alt="badges"></a><br/>';
        $examples = '<a href="examples.php?u='.$u.'"><img src="images/MyExamplesbutton.png" alt="examples button"/></a>';
        $gotfiles = '<a href="#" ><img src="#" alt="#"></a><br/>';
    }

if($dorc == "d"){

}


$profile_pic = '<img src="user/'.$u.'/'.$avatar.'" alt="'.$u.'" style="width:196px; height:196px;">';
if($avatar == NULL){
    $profile_pic = '<img src="images/Profiledefaultnew.jpg" alt="'.$user1.'" style="width:196px;">';
}

$header_pic = '<img src="user/'.$u.'/'.$header.'" alt="'.$u.'" >';
if($header == NULL){
    $header_pic = '<img src="images/Profileheaderdefault3.jpg" alt="'.$user1.'" style="width:100% ; margin:auto;">';
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

$sidead = '<a href="http://www.stickygripz.com" target="_blank"><img src="images/stickygripssidebar.png" alt="sgad" style="width:230px;"/></a>';
$randnum = rand(0,3);
if($randnum == 0){
    $sidead = '<a href="https://www.kickstarter.com/projects/2127012713/wall-mounts-for-gaming-consoles-ps4-xbox-one-etc" target="_blank"><img src="images/ads/consolearmorsidebanner.png" alt="sgad" style="width:230px;"/></a>';
} else if ($randnum== 1){
    $sidead = '<a href="http://www.aporiacustoms.com" target="_blank"><img src="images/Aporiasidebar.png" alt="apad" style="width:230px;"/></a>';
} else if ($randnum == 2){
    $sidead = '<a href="http://www.esportcareer.org" target="_blank"><img src="images/esportsjobssidebar.png" alt="recommend banner" style="width:230px;"/></a>';
}

$leftsidead = '<a href="#"><img src="images/25contestsbanner.png" alt="25 contests free prem" style="width:210px;"/></a>';
$randnum = rand(0,2);
if($randnum == 0){
    $leftsidead = '<a href="#"><img src="images/Gopremiumbanner.png" alt="go premium" style="width:210px;"/></a>';
} else if ($randnum== 1){
    $leftsidead = '<a href="#"><img src="images/recommendbanner.png" alt="recommend banner" style="width:210px;"/></a>';
}






$userconnect = '<p> Connect with '.$u.' :</p>';
$socialsql = "SELECT * FROM social WHERE username= '$u'" ;
$social_query = mysqli_query($db_conx,$socialsql);

while ($row = mysqli_fetch_array($social_query, MYSQLI_ASSOC)){
    $twitter =  $row['twitter'];
    $facebook = $row['facebook'];
    $youtube = $row['youtube'];
    $twitch = $row['twitch'];
    $behance =$row['behance'];
}
$twitecho = '';
if($twitter != null){
    $twitecho = '<a href="'.$twitter.'"><img src="images/social/socialnetworkbiotwitter.png" alt ="twit"></a>';
}

$fbecho = '';
if($facebook != null){
    $fbecho = '<a href="'.$facebook.'"><img src="images/social/socialnetworkbiofacebook.png" alt ="twit"></a>';
}

$ytecho = '';
if($youtube != null){
    $ytecho = '<a href="'.$youtube.'"><img src="images/social/socialnetworkbioYouTube.png" alt ="twit"></a>';
}

$twecho = '';
if($twitch != null){
    $twecho = '<a href="'.$twitch.'"><img src="images/social/socialnetworkbiotwitch.png" alt ="twit"></a>';
}
$bhecho = '';
if($behance != null){
    $bhecho = '<a href="'.$behance.'"><img src="images/social/socialnetworkbiobehance.png" alt ="twit"></a>';
}







$badge_check = "SELECT wins, entries, first_place, second_place, third_place FROM badges WHERE username='$u' LIMIT 1";
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
    $prembadge = '';
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

if ($premiumtoggle == 1){
    $prembadge = '<img src="images/premiumbadge.png" style = "width:100px">';
    $badgecount++;
}
if($user_ok == true &&  $u ==$log_username){
    if($badgecount == 1){
        $badgemsg = 'You Have 1 Badge!';
    } else {
        $badgemsg = 'You Have '.$badgecount.' Badges!';
    }
} else {
    if($badgecount == 1){
        $badgemsg = ''.$u.' Has 1 Badge!';
    } else {
        $badgemsg = ''.$u.' Has '.$badgecount.' Badges!';
    }

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
    <style type="text/css">
        div#profile_pic_box{float:right; width:200px; height:200px; overflow-y:hidden;}
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
            background:#7cac11;
            width:196px;
            height:196px;
        }
        div#profile_pic_box:hover a {
            display: block;
        }

        div#header_pic_box{float:right;  width:800px; height:200px; overflow-y:hidden;}
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
            background:#7cac11;
            width:800px;
            height:180px;
        }
        div#header_pic_box:hover a {
            display: block;
        }

    </style>
</head>
<body style=" margin-bottom:70px; margin-top:70px;text-align: center">



<?php include_once("php_includes/userPageTop.php"); ?>



<div class="container" style="width:100%; margin:auto">
        <div id="pageTopHeader" style="display: inline-block;min-width: 1000px;">
            <div id= "header_pic_box"><?php echo $profile_header_btn;?><?php echo $header_form;?><?php echo $header_pic;?></div>
            <div id="profile_pic_box"><?php echo $profile_pic_btn; ?><?php echo $avatar_form; ?><?php echo $profile_pic; ?></div>
        </div>
<!--<div>
  <?php echo $userconnect;?> <div style="display: inline">
<?php echo $twitecho; echo $ytecho; echo $twecho; echo $bhecho; echo $fbecho;?>
  </div>
</div> -->





<!-- <div style="position:relative; left:0; top:0;width:190px"><img src="images/profilepicdesigner.png" style="position:relative;top:0;left:0;z-index: 2999;"> -->



    <div class="row" style="display: inline-block; overflow: nowrap; min-width: 1100px;  margin:auto; text-align: center" >
        <div style="float:left; margin:10px 10px 8px 50px; ">
            <?php echo $leftsidead;?>
        </div>
       <!-- <div class="" style="width:210px; height:455px; background-image: url('images/sidebarrightbg.png');  float:left " >
            <div style="width:160px; padding-left:20px;padding-right: 20px;padding-top:30px; margin-left:20px;margin-right:20px;">
            <p>3rd party non-premium</p></br></br></br></br>
            <p>premium accounts</p>
            <p>latest premium jobs feed</p>
               </div>
        </div> -->

        <div id="probtns" style=" width:550px; background-color: #86bf16; margin:10px auto 8px 15px; float:left ">
            <div style="display: inline-block" class="pb">
                <?php echo $myjobsbb;?>
                <?php echo $portfoliobb; ?>
             <!--   <?php echo $gotfiles;?>  -->
                <?php echo $examples;?>



            </div> <br/>
                <div style="display: inline-block" class="pb">
                <a href="#badges" data-toggle="modal"><img  src="images/profilebuttonbadges.png" alt="badges"></a><br/>
                <?php echo $jobbb;?>
                </div>
            <div style="display: inline-block" class="pb">
                <?php echo $messagesbb; ?>
                <?php echo $rulesbb;?>

                </div>







              <!--  <h3><?php echo $u; ?></h3>
                <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
                <p>Designer or Client: <?php echo $dorcdisplay; ?></p>
                <p>Country: <?php echo $country; ?></p>
                <p>User Level: <?php echo $userlevel; ?></p>
                <p>Join Date: <?php echo $joindate; ?></p>
                <p>Last Session: <?php echo $lastsession; ?></p> -->



        </div>

        <div style="float:left; margin:-20px auto 8px auto; ">
            <?php echo $sidead;?>
        </div>
        <!--<div  style="width:200px; height:455px; background-image:url('images/sidebarleftbr.png'); margin:0 auto 8px auto; float:left">
           <div style="width:160px; padding-left:20px;padding-right: 20px;padding-top:30px; margin-left:20px;margin-right:20px;">
            </br>
            <p>latest jobs</p></br></br></br></br>
            <p> our social links and contacts</p>
           </div>
           </div> -->
    </div>

</div>

<div style="">
<div class="container">
<!-- <?php echo $ppadd;?> -->
<p> <span id="blockBtn"><?php echo $block_button; ?></span></p><br/>

<div style="width:400px;margin:0px auto 20px auto;padding:10px;background-color:#262626">
    <p> <?php echo $message_status;?> </p>
<div style="margin: 0px auto 20px auto"> <?php include_once("template_pm.php")?></div>
</div>
</div>
</div>


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
            <?php echo $prembadge;?>

            </div>

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script>
    function emailupdate() {
        var ppadd = _("ppadd").value;
        var updatestatus = _("updatestatus");

            _("ppaddbtn").style.display = "none";
            updatestatus.innerHTML = 'please wait ...';
            var ajax = ajaxObj("POST", "php_includes/ppadd.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {

                    if(ajax.responseText != "ppadd_success"){
                        updatestatus.innerHTML = ajax.responseText;
                        _("ppaddbtn").style.display = "block";
                    } else {
                       updatestatus.innerHTML = "PayPal Added Successfully"

                    }
                }

            ajax.send("ppadd="+ppadd);
    }
</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
<script src="js/pm.js"></script>
<script src="js/login.js"></script>
</body>
</html>

