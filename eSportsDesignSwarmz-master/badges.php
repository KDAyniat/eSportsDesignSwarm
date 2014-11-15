<?php include_once('php_includes/check_login_status.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>eSports Design Swarm - How it works</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet">
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
<div>
    <h2 style="text-align: center;">Badges</h2>
    <p style="text-align:center;">Badges are milestones that you can earn just by using our site. Badges will affect your overall rating and certain badges will earn you prizes.</p><p style="text-align: center;"> We will be posting more badges as our site grows, so keep checking back for new challenges and incentives.</p>
</div>

<div class= "container" id="badgestext">
    <div class="row" style="text-align: center; margin:auto">
        <h3>PREMIUM DESIGNERS</h3>
        <img src="images/premiumbadge.png" alt="premium badge">
    </div>
    <div class="row" style="text-align: center; margin:auto">
        <h3>Client Badges:</h3>
        <div class="col-lg-3">
            <img src="images/badges/1stcontest.png">
            <p>Post a contest, get a badge</p>
        </div>
        <div class= "col-lg-3">
            <img src="images/badges/1stpremiumjob.png">
            <p>Post a Premium Contest</p>
        </div>
        <div class= "col-lg-3">
            <img src="images/badges/closedcontest.png">
            <p>Post A Closed Contest</p>
        </div>
        <div class= "col-lg-3">
            <img src="images/badges/awardedcustombadge.png">
            <p>Post A Job With A Custom Badge Reward</p>
        </div>
    </div>
    <div class="row">
        <div><h3>Contest Entry Badges:</h3></div>
    <div class="col-lg-3">
    <img src="images/badges/1stentrybadge.png">
    <p>Enter a contest, get a badge</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/5entriesbadge.png">
    <p>Enter 5 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/10entriesbadge.png">
    <p>Enter 10 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/25entriesbadge.png">
    <p>Enter 25 contests</p>
</div>
    </div>
    <div class="row">
<div class= "col-lg-3">
    <img src="images/badges/50entriesbadge.png">
    <p>Enter 50 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/100entriesbadge.png" >
    <p>Enter 100 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/250entriesbadge.png" >
    <p>Enter 250 contests</p>
</div>
    </div>
<br/>
    <div><h3>Contest Win Badges:</h3></div>
    <div class="row">
<div class= "col-lg-3">
    <img src="images/badges/1contestwin.png" >
    <p>Win a contest</p>
</div>

<div class= "col-lg-3">
    <img src="images/badges/5winbadge.png" >
    <p>Win 5 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/10winbadge.png" >
    <p>Win 10 contests</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/20winbadge.png" >
    <p>Win 20 contests</p>
</div>
    </div>
    <br/>
    <div><h3>Place Badges:</h3></div>
    <div class="row">
<div class= "col-lg-3">
    <img src="images/badges/1stplace.png" >
    <p>First Place Badge</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/2ndplace.png">
    <p>2nd Place Badge</p>
</div>
<div class= "col-lg-3">
    <img src="images/badges/3rdplace.png" >
    <p>3rd Place Badge</p>
</div>
</div>
</div>

<?php include_once("php_includes/pageBottom.php"); ?>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>