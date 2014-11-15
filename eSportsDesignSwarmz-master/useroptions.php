
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




?><?php
        if(isset($_POST["cp"])){
    // CONNECT TO THE DATABASE
    include_once("php_includes/db_connects.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $cp = $_POST['cp'];
    $np1 = $_POST['np1'];
    $ppe = mysqli_real_escape_string($db_conx, $_POST['ppe']);
    $yt = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['yt']);
    $twit = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['twit']);
    $tw = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['tw']);
    $bh = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['bh']);
    $fb = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['fb']);
    $uw = preg_replace('#[^a-z0-9?&!/.-]#i', '', $_POST['uw']);


    // END FORM DATA ERROR HANDLING
    // Begin Insertion of data into the database
    // Hash the password and apply your own mysterious unique salt

    $p_hash = password_hash($np1, PASSWORD_BCRYPT, array("cost" => 9));
    //$cryptpass = crypt($p);
    //include_once ("php_includes/randStrGen.php");
    //$p_hash = randStrGen(20)."$cryptpass".randStrGen(20);


    // Add user info into the database table for the main site table
if($np1 == '' || $cp == ''){
    $sql = "UPDATE users SET paypal='$ppe', website='$uw'  WHERE username='$log_username' LIMIT 1 ";
} else {
    $sql = "UPDATE users SET password='$p_hash' paypal='$ppe', website='$uw'  WHERE username='$log_username' LIMIT 1 ";
}

    $query = mysqli_query($db_conx, $sql);

    // Establish their row in the useroptions table
    $sql = "INSERT INTO social (username, youtube, twitch,twitter,facebook,behance) VALUES ('$u','$yt','$tw','$twit','$fb','$bh')";
    $query = mysqli_query($db_conx, $sql);

    // Email the user their activation link


    echo "update_success";
exit();
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body style="padding-bottom: 70px; padding-top: 70px">

<?php include_once("php_includes/userPageTop.php"); ?>

<div style="margin:auto; text-align: center">
    <div style="background-color: green; width:800px;margin:auto; padding:20px;">
    <h3> Change your password</h3>
   <form onsubmit="return false">

       <label for="pass">Current Password*:  </label>
       <input type="password" id="pass" ><br/>

       <label for="newpass1">New Password:    </label>
       <input type="password" id="newpass1" ><br/>

       <label for="newpass2">Confirm New Password: </label>
       <input type="password" id="newpass2" ><br/>
        <button type="submit" id="updatebtn" onclick="update()">Update</button>
       </form>

    <h3> Add/Update Your Paypal Email</h3>

    <form onsubmit="return false">

        <label for="paypalemail">Add/Update a Paypal Email:  </label>&nbsp;&nbsp;
        <input type="email" id="paypalemail" value=""><br/>
        <button type="submit" id="updatebtn" onclick="update()">Update</button>
    </form>


    <h3> Add/Update Your Social Links</h3>
    <form onsubmit="return false">
        <label for="userwebsite">Your Website:</label>
        <input type="text" id="userwebsite" value=""><br/>
        <label for="useryoutube">Youtube:</label>
        <input type="text" id="useryoutube" value=""><br/>
        <label for="usertwitch">Twitch:</label>
        <input type="text" id="usertwitch" value=""><br/>
        <label for="usertwitter">Twitter:</label>
        <input type="text" id="usertwitter" value=""><br/>
        <label for="userfacebook">Facebook:</label>
        <input type="text" id="userfacebook" value=""><br/>
        <label for="userbehance">BeHance:</label>
        <input type="text" id="userbehance" value=""><br/>
        <button type="submit" id="updatebtn" onclick="update()">Update</button>
    </form>
        <span id="thisstatus"></span>
        <p>*Current Password Must Be Entered For Any Updates</p>
</div>
</div>

<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script>
    function update(){
        var cp = _("pass").value;
        var np1 = _("newpass1").value;
        var np2 = _("newpass2").value;
        var ppe = _("paypalemail").value;
        var yt = _("useryoutube").value;
        var twit = _("usertwitter");
        var tw = _("usertwitch").value;
        var bh = _("userbehance").value;
        var uw = _("userwebsite").value;
        var fb = _("userfacebook").value;
        var thisstatus = _("thisstatus");


        if(np1 != np2){
            status.innerHTML = "Your password fields do not match";
        }  else {
            _("updatebtn").style.display = "none";
            status.innerHTML = 'please wait ...';
            var ajax = ajaxObj("POST", "useroptions.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {

                    if(ajax.responseText != "update_success"){
                        thisstatus.innerHTML = ajax.responseText;
                        _("updatebtn").style.display = "block";
                    } else {
                        thisstatus.innerHTML = 'Info Successfully Updated';
                    }
                }
            }

            ajax.send("cp="+cp+"&np1="+np1+"&ppe="+ppe+"&yt="+yt+"&twit="+twit+"&tw="+tw+"&bh="+bh+"&uw"+uw+"&fb="+fb);
        }
    }
</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>

<script src="js/expand_retract.js"></script>
</body>
</html>