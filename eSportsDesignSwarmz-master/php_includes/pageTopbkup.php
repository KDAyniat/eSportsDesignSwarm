<?php
// It is important for any file that includes this file, to have
// check_login_status.php included at its very top.
$updates = '';
$loginLink = ' <li> <a href="../signup.php">Register</a></li>
                <li href="#signin" data-toggle="modal"><a href="#">Sign In</a></li>';
$msgs = 'You have no new messages';
if($user_ok == true) {
    $sql = "SELECT notescheck FROM users WHERE username='$log_username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $notescheck = $row[0];
    $sql = "SELECT id FROM notifications WHERE username='$log_username' AND date_time > '$notescheck' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if ($numrows == 0) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="Your notifications"><img src="../images/NotificationIcons/messagesicon0.png" style="width:35px;"></a></li>';
    } else if($numrows == 1) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 1 new notification"><img src="../images/NotificationIcons/messagesicon1.png"  style="width:35px;"></a></li>';
        $msgs = 'You have 1 new message';
    }
    else if($numrows == 2) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 2 new notifications"><img src="../images/NotificationIcons/messagesicon2.png"  style="width:35px;"></a></li>';
        $msgs = 'You have 2 new messages';
    }
    else if($numrows == 3) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 3 new notifications"><img src="../images/NotificationIcons/messagesicon3.png"  style="width:35px;"></a></li>';
        $msgs = 'You have 3 new messages';
    }
    else if($numrows == 4) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 4 new notifications"><img src="../images/NotificationIcons/messagesicon4.png"  style="width:35px;"></a></li>';
        $msgs = 'You have 4 new messages';
    }
    else if($numrows == 5) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 5 new notifications"><img src="../images/NotificationIcons/messagesicon5.png"  style="width:35px;"></a></li>';
    }
    else if($numrows == 6) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 6 new notifications"><img src="../images/NotificationIcons/messagesicon6.png"  style="width:35px;"></a></li>';
    }else if($numrows == 7) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 7 new notifications"><img src="../images/NotificationIcons/messagesicon7.png" style="width:35px;"></a></li>';
    }else if($numrows == 8) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 8 new notifications"><img src="../images/NotificationIcons/messagesicon8.png" style="width:35px;"></a></li>';
    }else if($numrows == 9) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 9 new notifications"><img src="../images/NotificationIcons/messagesicon9.png" style="width:35px;"></a></li>';
    }else if($numrows == 10) {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 10 new notifications"><img src="../images/NotificationIcons/messagesicon310.png" style="width:35px;"></a></li>';
    }
    else {
        $updates = '<li href="#updates" data-toggle="modal"><a href="#" title="You have 10+ new notifications"><img src="../images/NotificationIcons/messagesicon10.png" style="width:35px;"></a></li> ';
    }
    $loginLink = '<li><a href="user.php?u='.$log_username.'">'.$log_username.'</a></li> <li><a href="logout.php">Log Out</a></li>';
}
?>

<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.php"><img class="navlogo" src="../images/esports%20design%20swarm%20small.png";"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="../howitworks.php">How it works</a></li>
               <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jobs <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Categories</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Logo</a></li>
                        <li><a href="#">Social Media Package</a></li>
                        <li><a href="#">Twitch TV Package</a></li>
                        <li><a href="#">Banners/Advertising</a></li>
                        <li><a href="#">GIFs</a></li>
                        <li><a href="#">Intros</a></li>
                        <li><a href="#">Video Editing</a></li>
                        <li><a href="#">Small Website Design</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li> -->
               <!-- <li><a href="#">Start Contest</a></li>
                <li><a href="#">Forums</a></li> -->
                <li href="#contact" data-toggle="modal"><a href="#">Contact Us</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php echo $updates; ?> <?php echo $loginLink; ?>
                </ul>
                <!-- <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign In <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                         <li><form class="navbar-form navbar-left" role="search">
                             <div class="form-group" >
                                 <input type="text" class="form-control" placeholder="Username">
                             </div>

                         </form></li>
                         <li><form class="navbar-form navbar-left" role="search">
                             <div class="form-group" >
                                 <input type="text" class="form-control" placeholder="Password">
                             </div>

                         </form></li>
                         <li><a href="#">Another action</a></li>
                         <li><a href="#">Something else here</a></li>
                         <li class="divider"></li>
                         <li><a href="#">Separated link</a></li>
                     </ul>
                 </li>
             </ul> -->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div class="modal fade" id="contact" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class= "modal-header">
                <h3><strong>Contact eSports Design Swarm</strong></h3>

            </div>
            <div class="modal-body">
                <form id="contact-form">
                    <div class="success">Contact form submitted!<br>
                        <strong>We will be in touch soon.</strong>
                    </div>

                    <label class="name clearfix">
                        <input type="text" value="Your Name:">
                        <span class="error">*This is not a valid name.</span><span class="empty">*This field is required.</span>
                    </label>

                    <label class="email clearfix">
                        <input type="text" value="E-mail:">
                        <span class="error">*This is not a valid email address.</span> <span class="empty">*This field is required.</span>
                    </label>
                    <label class="message clearfix">
                        <textarea>Message:</textarea>
                        <span class="error">*The message is too short.</span> <span class="empty">*This field is required.</span>
                    </label><br>
                    <div class="modal-footer">
                        <a href="#" data-type="submit" class="btn btn-success pull-left" >Submit</a>  &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" data-type="reset" class="btn btn-success pull-left" >Reset</a>
                        <a href="#" class="btn btn-success pull-right" data-dismiss = "modal"> Close</a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
<?php include_once("login_include.php"); ?>

<script src="../js/login.js"></script>
<div class="modal fade" id="signin" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class= "modal-header">
                <h3><strong>Sign In:</strong></h3>

            </div>
            <div class="modal-body">

                <!-- LOGIN FORM -->
                <form id="loginform" onsubmit="return false;">
                  <div>Email Address:</div>
                  <input type="text" id="loginemail" onfocus="emptyElement('status')" maxlength="88">
                  <div>Password:</div>
                  <input type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
                  <br /><br />
                  <button id="loginbtn" onclick="login()">Log In</button></br>
                  <span id="loginstatus"></span>
                  <a href="../forgot_pass.php">Forgot Your Password?</a>
                </form>



            </div>

        </div>
    </div>
</div>


<!-- notifications modal -->
<?php include_once('notifications.php');?>
<div class="modal fade" id="updates" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class= "modal-header">
                <h3><strong><?php echo $msgs;?></strong> </h3>

            </div>
            <div class="modal-body" style="height:200px;">




            </div>

        </div>
    </div>
</div>