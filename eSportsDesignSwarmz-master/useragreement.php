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


    <div class="container">
        <img src="images/UserAgreementimagedark.jpg" style=" width:100%; margin:auto" alt="user agreement">
    </div>





<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>