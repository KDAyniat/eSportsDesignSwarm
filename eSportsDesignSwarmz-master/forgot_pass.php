<?php
include_once("php_includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
    header("location: user.php?u=".$_SESSION["username"]);
    exit();
}
?><?php
// AJAX CALLS THIS CODE TO EXECUTE
if(isset($_POST["e"])){
    $e = mysqli_real_escape_string($db_conx, $_POST['e']);
    $sql = "SELECT id, username FROM users WHERE email='$e' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id = $row["id"];
            $u = $row["username"];
        }
        $emailcut = substr($e, 0, 4);
        $randNum = rand(10000,99999);
        $tempPass = "$emailcut$randNum";
        $hashTempPass = password_hash($tempPass,PASSWORD_BCRYPT,array("cost"=> 9));
        $sql = "UPDATE useroptions SET temp_pass='$hashTempPass' WHERE username='$u' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $to = "$e";
        $from = "info@esportsdesignswarm.com";
        $headers ="From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
        $subject ="eSports Design Swarm Password Reset";
        $msg = '<h2>Hello '.$u.'</h2><p>This is an automated message from eSports Design Swarm. If you did not recently initiate the Forgot Password process, please disregard this email.</p><p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p><p>After you click the link below your password to login will be:<br /><b>'.$tempPass.'</b></p><p><a href="http://www.esportsdesignswarm.com/forgot_pass.php?u='.$u.'&p='.$hashTempPass.'">Click here now to apply the temporary password shown below to your account</a></p><p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the temporary password you must click the link above.</p>';
        if(mail($to,$subject,$msg,$headers)) {
            echo "success";
            exit();
        } else {
            echo "email_send_failed";
            exit();
        }
    } else {
        echo "no_exist";
    }
    exit();
}
?><?php
// EMAIL LINK CLICK CALLS THIS CODE TO EXECUTE
if(isset($_GET['u']) && isset($_GET['p'])){
    $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    $temppasshash = preg_replace('#[^a-z0-9]#i', '', $_GET['p']);
    if(strlen($temppasshash) < 10){
        exit();
    }
    $sql = "SELECT id FROM useroptions WHERE username='$u' AND temp_pass='$temppasshash' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows == 0){
        header("location: message.php?msg=There is no match for that username with that temporary password in the system. We cannot proceed.");
        exit();
    } else {
        $row = mysqli_fetch_row($query);
        $id = $row[0];
        $sql = "UPDATE users SET password='$temppasshash' WHERE id='$id' AND username='$u' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE useroptions SET temp_pass='' WHERE username='$u' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        header("location: index.php");
        exit();
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--   <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <title>eSports Design Swarm</title>
        <link rel="icon" type="image/png" href="images/favicon.png">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="main.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,500' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Orbitron:400,500,700,900' rel='stylesheet' type='text/css'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->

        <script src="js/main.js"></script>
        <script src="js/ajax.js"></script>

    <script>
        function forgotpass(){
            var e = _("email").value;
            if(e == ""){
                _("status").innerHTML = "Type in your email address";
            } else {
                _("forgotpassbtn").style.display = "none";
                _("status").innerHTML = 'please wait ...';
                var ajax = ajaxObj("POST", "forgot_pass.php");
                ajax.onreadystatechange = function() {
                    if(ajaxReturn(ajax) == true) {
                        var response = ajax.responseText;
                        if(response == "success"){
                            _("forgotpassform").innerHTML = '<h3>Step 2. Check your email inbox in a few minutes</h3><p>You can close this window or tab if you like.</p>';
                        } else if (response == "no_exist"){
                            _("status").innerHTML = "Sorry that email address is not in our system";
                        } else if(response == "email_send_failed"){
                            _("status").innerHTML = "Mail function failed to execute";
                        } else {
                            _("status").innerHTML = "An unknown error occurred";
                        }
                    }
                }
                ajax.send("e="+e);
            }
        }
    </script>
</head>
<body>

<?php include_once("php_includes/pageTop.php"); ?>
<div class="container" style="margin:auto;">
<div id="pageMiddle" style="height 800px;">
    <h3>Generate a temorary log in password</h3>
    <form id="forgotpassform" onsubmit="return false;">
        <div>Step 1: Enter Your Email Address</div>
        <input id="email" type="text" onfocus="_('status').innerHTML='';" maxlength="88">
        <br /><br />
        <button id="forgotpassbtn" onclick="forgotpass()">Generate Temporary Log In Password</button>
        <p id="status"></p>
    </form>
</div>
</div>

<?php include_once("php_includes/pageBottom.php"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>