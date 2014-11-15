<?php include_once('php_includes/check_login_status.php');?>
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

function emptyElement(x){
    _(x).innerHTML = "";
    }
function login(){
    var e = _("email").value;
    var p = _("password").value;
    if(e == "" || p == ""){
    _("status").innerHTML = "Fill out all of the form data";
    } else {
    _("loginbtn").style.display = "none";
    _("status").innerHTML = 'please wait ...';
    var ajax = ajaxObj("POST", "php_includes/login_include.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    if(ajax.responseText == "login_failed"){
    _("status").innerHTML = "Login unsuccessful, please try again.";
    _("loginbtn").style.display = "block";
    } else {
    window.location = "user.php?u="+ajax.responseText;
    }
    }
    }
    ajax.send("e="+e+"&p="+p);
    }
    }




        </script>
</head>
<body style="padding-bottom: 70px; padding-top: 70px">
<?php include_once("php_includes/pageTop.php"); ?>
<div style="margin:auto; padding:10px; text-align: center;">

    <a href="jobs.php"><img src="images/homepagetopstartcontestbutton.png" alt="start contest" style="margin: 10px auto;"></a>
    <img src="images/homepageadverbanner.jpg" alt="hpad">

</div>
<div class="container">
<div class="jumbotron" style=" background-image: url('images/homejumbopng2.png');
    background-repeat: no-repeat; background-color: #ffffff">

 <h2 class="jthead"><img src="images/esportsdesignswarmcleanhomepage.png" alt="biglogo" style="margin-top: -35px;"></h2>
    <p class="jthead"><strong>Amazing eSports Designs You'll Love! Every Time!</strong></p>
    <p class="jthead">The best place around for all your eSports graphics needs</p>
 <!--   <p class="jthead"><a href="howitworks.html"><img src="images/HowItWorksbuttonnobrsmall.png"></a></p> -->

    <div class="row" style="inline-block; margin auto; text-align: center" id="socialbtns">
     <!--  <a href="signup.php"><img src="images/registerbutton.jpg" alt="registration" style="margin:90px 50px 0 10px;"/></a> -->
        <a href="jobs.php"><img src="images/StartContestbutton.jpg" alt="start contest" style="margin:90px 10px 0 40px;" /></a>
        <a href="howitworks.php"><img src="images/howitworksbutton.jpg" alt="how it works"  style="margin:90px 40px 0 10px;"></a>
    </div>
</div>
</div>

<div class="container" style="margin:auto; text-align: center;">
<a href="signup.php"><img src="images/homepagetopdesignersignupbutton.png" alt="designer signup"/></a>
</div>


<div class="container" id="adbanner" >
    <div class="row">
        <div style="margin: auto; width:960px;">
           <a href="#contact" data-toggle="modal"> <img src="images/ads/adverbannerthin.jpg" alt="thinban"> </a>
        </div>
    </div>


<div class="row" id="ads">

    <div style="margin:auto; text-align: center;">
       <a href="http://www.stickygripz.com" target="_blank" ><img src="images/ads/StickyGrips.jpg" alt="ad"></a>
        <a href="https://www.kickstarter.com/projects/2127012713/wall-mounts-for-gaming-consoles-ps4-xbox-one-etc" target="_blank"><img src="images/ads/ConsoleArmor.jpg" alt="ad"></a>
        <a href="http://www.aporiacustoms.com" target="_blank"> <img src="images/ads/aporiacustoms.jpg" alt="ad"></a>
        <a href="http://www.esportcareer.org" target="_blank"> <img src="images/ads/esportsjobs.jpg" alt="ad"></a>
    </div>

</div>

<!--<div class="container">
    <div style="margin-left: 150px;">
        <img src="images/ads/adverbanner.jpg" alt="adbanner">
    </div>
</div>-->
</div>
<!-- <div style="text-align: center; margin:auto;padding:10px;">
    Share This Page:
    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.esportsdesignswarm.com/index.php" data-via="eDesignSwarm" data-size="large" data-hashtags="eDesignSwarm">Tweet</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div> -->
<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>