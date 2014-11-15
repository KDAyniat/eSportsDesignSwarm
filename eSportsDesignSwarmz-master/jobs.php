<?php include_once('php_includes/check_login_status.php');

$tieroptions = '';
$choice = '';
if(isset($_POST['c'])){

    include_once('php_includes/db_connects.php');
$choice = $_POST['c'];



    if($user_ok == true){
        if ($choice == "undefined"){
            echo "choice_failed";

        } else {
            echo "choice_success";





        }
    } else {
        echo "not_reg";
        exit();
    }
    exit();

}





if(isset($_POST['tier'])){
    include_once('php_includes/db_connects.php');
    $e = mysqli_real_escape_string($db_conx, $_SESSION['useremail']);
    $choice = preg_replace('#[^a-z ]#i', '', $_POST['c2']);
    $tier = preg_replace('#[^a-z0-9. ]#i', '', $_POST['tier']);
    $sp = preg_replace('#[^0-9]#i', '', $_POST['sp']);
    $pn = preg_replace('#[^a-z ]#i', '', $_POST['pn']);
    $tn = preg_replace('#[^a-z ]#i', '', $_POST['tn']);
    $pd = preg_replace('#[^a-z0-9 ]#i', '', $_POST['pd']);
    $pc = preg_replace('#[^a-z0-9 ]#i', '', $_POST['pc']);
    $pu = preg_replace('#[^a-z0-9 ]#i', '', $_POST['pu']);
    $pac = preg_replace('#[^a-z ]#i', '',  $_POST['pac']);

    $et = preg_replace('#[^a-z0-9/-/// ]#i', '', $_POST['et']);
    $premium = preg_replace('#[^a-z0-9 ]#i', '', $_POST['premium']);
    $ooc = preg_replace('#[^a-z ]#i', '', $_POST['ooc']);
    $totalcost = preg_replace('#[^0-9]#i', '', $_POST['totalcost']);
    $b =  preg_replace('#[^0-9]#i', '', $_POST['b']);
    $bc = $pc = preg_replace('#[^a-z0-9 ]#i', '', $_POST['bc']);

        // double check these field names and usages

    $sql = "SELECT id FROM jobs WHERE username='$log_username' AND proj_name='$pn' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $job_check = mysqli_num_rows($query);

    // form error check - double check pricing choices here
    if($tier == "" || $sp == "" || $pn == "" || $pd =="" || $pc == ""|| $pu =="" || $et == "" || $premium == "" || $ooc == "" || $pac == "" || $tn == "") {
        echo "form data missing";
    } else if($job_check > 0){
        echo "You already have an open project called '.$pn.'. If this is a new project, please choose another name";
    }  else {




         if ($tier == "t1") {
            if ($sp < 20) {
                echo "Minimum Price is $20";
        exit();
            } else if ($sp > 35) {
                echo "Set price is too high for this pricing tier, please choose a different tier";
                exit();
            }

        } else if ($tier == "t2") {
        if ($sp <36) {
            echo "Minimum Price for this tier is $30";
            exit();
        } else if ($sp > 60) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }
    }else if ($tier == "t3") {
        if ($sp < 61) {
            echo "Minimum Price for this tier is $46";
            exit();
        } else if ($sp > 85) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }
    }else if ($tier == "t4") {
        if ($sp < 86) {
            echo "Minimum Price for this tier is $61";
            exit();
        } else if ($sp > 100) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }
    }else if ($tier == "t5") {
        if ($sp < 101) {
            echo "Minimum Price for this tier is $86";
            exit();
        } else if ($sp > 115) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }
    }else if ($tier == "t6") {
        if ($sp < 116) {
            echo "Minimum Price for this tier is $101";
            exit();
        } else if ($sp > 150) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }
    }else if ($tier == "t7") {
        if ($sp < 151) {
            echo "Minimum Price for this tier is $116";
            exit();
        } else if ($sp > 200) {
            echo "Set price is too high for this pricing tier, please choose a different tier";
            exit();
        }

    } else if ($tier == "t10") {
        if ($sp < 201) {
            echo "Minimum Price for this tier is $201";
            exit();
        }
    }
        //check db table names
      $sql = "INSERT INTO jobs (initiator, tier, setprice, totalprice, job_type, proj_name, team_name, detail, colors, design_usage, comments, premium, ooc, badge, start_date, end_date)
              VALUES ('$log_username', '$tier','$sp','$totalcost', '$choice','$pn','$tn','$pd', '$pc','$pu', '$pac','$premium','$ooc','$b', now(), '$et' )";
        $query = mysqli_query($db_conx, $sql);
        if (!file_exists("user/$u/jobs")) {
            mkdir("user/$u/jobs", 0755);
        }


        $to = "$e";
        $from = "info@esportsdesignswarm.com";
        $subject = 'eSports Design Swarm Job Creation Successful';
        $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eSports Design Swarm Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva,
        sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.esportsdesignswarm.com">
        <img src="http://www.esportsdesignswarm.com/images/logofornavbar.png" width="36" height="30" alt="esportsdesignswarm" style="border:none; float:left;">
        </a>eSports Design Swarm Job Creation Successful</div><div style="padding:24px; font-size:17px;">Hello '.$log_username.',<br />
        <br />You have successfully created a new project: '.$pn.'<br /><br />
        If you did not initiate this process or have any questions, please let us know by replying to this email.
        </div></body></html>';
        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        mail($to, $subject, $message, $headers);

        echo "form_success";
        exit();
    }


exit();

}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--   <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>eSports Design Swarm - Jobs</title>
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
    <!-- logo - social media package - twitch package - banners/advertising - GIFs - intros - video editing - web design -->
</head>
<body style="padding-bottom: 70px; padding-top: 70px; text-align: center">
<?php include_once("php_includes/pageTop.php"); ?>

<div id="pageMiddle">
    <div>
        <img src="images/jobsadverbanner.jpg" alt="jobsheader">
    </div>





    <div class="container" id="jobchoices">
        <div class=leftimages>
            <img src="images/jobbuttons/jobpagelogoicon.png" alt="branding"/>
        </div>
        <div class="rightimages">
            <img style="margin-top:35px;" src="images/jobbuttons/sidetext-logo.png" alt="brandingsidetext"/>
        </div>
        <div class="row">


            <div style="text-align: center; margin:auto;">

                 <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $30" data-trigger="hover" src="images/jobbuttons/logobuttons.png"/>
                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $25" data-trigger="hover" src="images/jobbuttons/illustrationbuttons.png"/>


            </div>
            <div>
                <input type="radio" name="jobchoice" value="l" id="l" style="margin-right:100px;">
                <input type="radio" name="jobchoice" value="i" id="i" style="margin-left:100px;">
            </div>
        </div>
        <div class="rightimages">
            <img src="images/jobbuttons/jobpagesocialicon.png" alt="social"/>
        </div>
        <div class="leftimages">
            <img src="images/jobbuttons/sidetext-twitch.png" alt="socialsidetext"/>
        </div>
        <div class="row">

            <div style="text-align: center; margin:auto;">

                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $20" data-trigger="hover" src="images/jobbuttons/socialnetworkbuttons.png"/>

                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $25" data-trigger="hover" src="images/jobbuttons/twitchpackagebuttons.png"/>

            </div>
            <div>
                <input type="radio" name="jobchoice" value="s" id="s" style="margin-right:90px;">
                <input type="radio" name="jobchoice" value="t" id="t" style="margin-left:90px;">
            </div>
        </div>
        <div class="leftimages">
            <img src="images/jobbuttons/jobpageweariticon.png" alt="wear"/>
        </div>
        <div class="rightimages">
            <img src="images/jobbuttons/sidetext-apparel.png" alt="wearsidetext"/>
        </div>
        <div class="row">

            <div style="text-align: center; margin:auto">

                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $30" data-trigger="hover" src="images/jobbuttons/jerseybuttons.png"/>

                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $25" data-trigger="hover" src="images/jobbuttons/apparelbuttons.png"/>

            </div>
            <div>
                <input type="radio" name="jobchoice" value="j" id="j" style="margin-right:90px;">
                <input type="radio" name="jobchoice" value="a" id="a" style="margin-left:90px;">
            </div>
        </div>

        <div class="leftimages">
            <img src="images/jobbuttons/sidetext-video.png" alt="motionsidetext"/>
        </div>
        <div class="rightimages">
            <img src="images/jobbuttons/jobpagemotionicon.png" alt="motion"/>
        </div>

        <div class="row">


            <div style="text-align: center; margin:auto">
                <img class="jobimages" style="margin:0 0 0 -20px" rel="popover" data-container="body" data-content="Starting At $35" data-trigger="hover" src="images/jobbuttons/GIFsbuttons.png"/>


                <img class="jobimages" style="margin:0" rel="popover" data-container="body" data-content="Starting At $40" data-trigger="hover" src="images/jobbuttons/introsbuttons.png"/>


                <img class="jobimages" style="margin:0 20px 0 0" rel="popover" data-container="body" data-content="Starting At $35" data-trigger="hover" src="images/jobbuttons/editing.png"/>

            </div>
            <div>
                <input type="radio" name="jobchoice" value="g" id="g" style="margin-right:180px;">
                <input type="radio" name="jobchoice" value="in" id="in">
                <input type="radio" name="jobchoice" value="v" id="v" style="margin-left:180px;">
            </div>
        </div>

        <div class="leftimages">
            <img src="images/jobbuttons/jobpagewebicon.png" alt="web"/>
        </div>
        <div class="rightimages">
            <img src="images/jobbuttons/sidetext-web.png" alt="websidetext"/>
        </div>
        <div class="row">

            <div style="text-align: center; margin:auto">
                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $20" data-trigger="hover" src="images/jobbuttons/webbannersbuttons.png"/>


                <img class="jobimages" rel="popover" data-container="body" data-content="Starting At $125" data-trigger="hover" src="images/jobbuttons/WebDesignbuttons.png"/>


            </div>
            <div>
                <input type="radio" name="jobchoice" value="b" id="b" style="margin-right:90px;">
                <input type="radio" name="jobchoice" value="w" id="w" style="margin-left:90px;">
            </div>
        </div>



    </div>
    <div style="margin-top:20px; padding:10px;">
        <a href="#" onclick="jobSelect()" id="firstnextbtn"><img src="images/jobbuttons/jobdetailsbutton.png" alt="next" style=" margin:10px;"/></a>
        <span id="progress"></span>
    </div>
</div>


<div id="pageMiddle2" style="display:none; width:100%">
    <img src="images/jobbuttons/JobDetailsbanner.png" alt="job info" style="margin:10px;"/>
    <div>
<div id="leftside" style="float:left">
<img src="images/jobbuttons/swarmpng.png" alt="swarming" style="width:350px;" />
</div>
    <div id="rightside" style="float: right">

        <img src="images/jobbuttons/swarmpng.png" alt="swarming" style="width:350px;"/>
    </div>
    <div id="jdform" >
    <form id="jobdetails" onsubmit="return false;" role="form">
    <label for="tier">*Prize Tiers:
        <select id="tier">
            <option value=""></option>
            <option value="t1">Tier 1: $20-$35</option>
            <option value="t2">Tier 2: $36-$60</option>
            <option value="t3">Tier 3: $61-$85</option>
            <option value="t4">Tier 4: $86-$100</option>
            <option value="t5">Tier 5: $101-$115</option>
            <option value="t6">Tier 6: $116-$150</option>
            <option value="t7">Tier 7: $151-$200</option>
            <option value="t10">Unlimited: $200+</option>

        </select>

    </label>
        <p id="ourfee">Our Fees Start At Only $3! (Fees Not Included In Your Chosen Prize)</p><br/>

        <label for="projsetprice"> *Set Your Price: $
            <input type="number" id="projsetprice" placeholder="minprice" >
        </label>
    <label for="projname">*Project Name:
        <input type="text" id="projname" placeholder="Enter Project Name" >
    </label>
        <label for="teamname">*Business/Team Name:
            <input type="text" id="teamname" placeholder="Enter Team Name">
        </label>
    <label for="projdetails">*Project Details:
     <textarea id="projdetails" ></textarea>
        </label>
        <label for="projcolors"> *Primary Project Colors:
            <input type="text" id="projcolors" placeholder="Enter Primary Colors" >
        </label>
        <label for="projusage"> *Project Usage/Primary Game
            <textarea id="projusage" ></textarea>
        </label>
        <label for="projcomments">*Additional Comments to Designers:
          <textarea id="projcomments" ></textarea>
        </label>

        <label for="endtime"> *Date Needed By:
            <input type="date" id="endtime" placeholder="mindate" >
        </label><br/>
        <img src="images/extrafeatures.png" alt="extra features" style="margin:30px;"/><br/>
        <img  src="images/Gopremiumbadgesicon.png" alt="premium badge" style="width:150px; margin:10px"/><br/>
        <label for="prem"> *Premium or Non-Premium:
        <select id="prem">

            <option value="p">Premium- add $5</option>
            <option value="n">Non-Premium</option>
        </select>
        </label><br/>
        <img  src="images/openorclosed.png" alt="open or closed" style="margin:10px;"/><br/>
        <label for="ooc">*Open Or Closed Contest:
            <select id="ooc">
                <option value="c">Closed - add $3</option>
                <option value="o">Open</option>

            </select>
        </label><br/>
        <img src="images/textbadgesicon.png" alt="custom badge text" style="margin:10px;"/><br/>
       <a href="#cb" data-toggle="modal"> <img class="cbimg" src="images/custombadgesicon.png" alt="custom badges" style="margin:10px;"/></a><br/>
        <img class="hiddencbimg" src="images/custombadgespopup.png" alt="hidden popup" style="z-index: 10000; display:none;"/>
        <label for="custbadge">*Would you like a custom badge awarded?:
            <select id="custbadge">
                <option value="0">Custom Badge 1 - add $5</option>
                <option value="2">Custom Badge 2 - add $5</option>
                <option value="3">Custom Badge 3 - add $5</option>
                <option value="1">Standard Badge</option>
            </select>
        </label>
       <div id="badgecolor">
        <p>Change The Colors Of The Custom Badge To Match Your Brand</p>
        <label for="badgecolors">*What 2 Colors?:
            <input type="text" id="badgecolors" placeholder="Enter Badge Colors">
        </label>
       </div>
        <p style="font-size: small">*Required Items</p>
        <a href="#" onclick="jobDetails()" id="secondnextbtn"><img src="images/jobbuttons/jobreviewbutton.png" alt="next" style="margin:10px;"/></a><br/>
        <span id="progress"></span>
    </form>
    </div>
</div>
</div>



<?php include_once("php_includes/pageBottom.php"); ?>
<div class="modal fade" id="cb" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">



            </div>
            <div class="modal-body">

                <img src="images/custombadgespopup.png" alt="custom badge"/>


            </div>


    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script>
    var c;
    var totalcost;


    function jobSelect(){


        var progress = _('progress');
        if ( document.getElementById('l').checked){

            c = document.getElementById('l').value;

        } else if (document.getElementById('i').checked){
            c = document.getElementById('i').value;
        }else if (document.getElementById('s').checked){
            c = document.getElementById('s').value;
        }else if (document.getElementById('t').checked){
            c = document.getElementById('t').value;
        }else if (document.getElementById('j').checked){
            c = document.getElementById('j').value;
        }else if (document.getElementById('a').checked){
            c = document.getElementById('a').value;
        }else if (document.getElementById('g').checked){
            c = document.getElementById('g').value;
        }else if (document.getElementById('in').checked){
            c = document.getElementById('in').value;
        }else if (document.getElementById('v').checked){
            c = document.getElementById('v').value;
        }else if (document.getElementById('b').checked){
            c = document.getElementById('b').value;
        }else if (document.getElementById('w').checked){
            c = document.getElementById('w').value;
        } else{
            alert("You must make a choice");
        }


        _("firstnextbtn").style.display = "none";
        progress.innerHTML  = "please wait ...";
        var ajax = ajaxObj("POST", "jobs.php");
        ajax.onreadystatechange = function(){
            if(ajaxReturn(ajax) == true){
                if(ajax.responseText == "not_reg"){
                    var r = confirm("You Must Be Registered To Create A Job");
                    if (r == true){
                    window.location = "signup.php";
                    } else{
                        window.location = "index.php";
                    }

                } else if(ajax.responseText == "choice_success"){

                    _("pageMiddle").style.display = "none";
                    _("pageMiddle2").style.display = "initial";
                    return c;
                } else{
                    window.scrollTo(0,0);
                    _("firstnextbtn").style.display = "initial";
                    progress.innerHTML = "";
                }
            }
        }
        ajax.send("c="+c);

    }



    function jobDetails() {
        var c2=c;
        var tier = _("tier").value;
        var sp = parseInt(_("projsetprice").value);
        var pn = _("projname").value;
        var tn = _("teamname").value;
        var pd = _("projdetails").value;
        var pc = _("projcolors").value;
        var pu = _("projusage").value;
        var progress = _("progress");
        var pac = _("projcomments").value;
        var bc = _("badgecolors").value;
        var fee;
        var bfee;
        var et = _("endtime").value;
        var premium = _("prem").value;
        var ooc = _("ooc").value;
        var b= _("custbadge").value;
        var etparse = Date.parse(et);

        if(b == 0 || b == 2 || b == 3){
            bfee = 0;
        } else{
            bfee = 1;
        }

        if(sp >19 && sp < 36){
            fee = 3;

        } else if(sp > 35 && sp < 61){
            fee = 5;

        } else if(sp > 60 && sp < 86){
            fee = 7;

        } else if (sp > 85 && sp < 101){
            fee = 8;

        } else if (sp > 100 && sp < 116){
            fee = 10;

        } else if (sp > 115 && sp < 151){
            fee = 14;

        }else if (sp > 150 && sp < 201){
         fee = 16;
        }else{
            fee = 18;

        }



        if(tier == "" || sp == "" || pn =="" ||  pd == "" || pc == "" || pu == "" || et == "" || premium == "" || tn =="" || ooc == "" || bc == "" || pac ==""){
            progress.innerHTML = "Please Fill Out All Required Form Data";

        } else if (etparse < (Date.now()+172800000)){
            alert("Date must be at least 3 days in the future!");
        }  else {

            if(premium == "p" && ooc == "o" && bfee == "1"){
                totalcost = sp + fee + 5;
            } else if (ooc == "c" && premium == "n" && bfee == "1"){
                totalcost = sp + fee + 3;
            } else if (ooc == "c" && premium == "p" && bfee == "1"){
                totalcost = sp + +fee + 8;
            } else if (ooc =="c" && premium == "p" && bfee == "0"){
                totalcost = sp + fee + 13;
            } else if (ooc == "o" && premium == "p" && bfee == "0"){
                totalcost = sp + +fee + 10;
            } else if (ooc == "c" && premium == "n" && bfee =="0"){
                totalcost = sp + fee + 8;
            }
            else{
                totalcost = sp + fee;
            }

            _("secondnextbtn").style.display = "none";
            progress.innerHTML = "Please Wait...";
            var ajax = ajaxObj("POST", "jobs.php");
            ajax.onreadystatechange = function(){
                if(ajaxReturn(ajax) == true){
                    if(ajax.responseText != "form_success"){
                        progress.innerHTML = ajax.responseText;
                        _("secondnextbtn").style.display = "initial";

                    } else{
                        window.location= "jobreview.php";

                     //  _("pageMiddle3").innerHTML = tier+ " " + sp + " " + pn + " " + pd + " " + pc + " " + pu + " " + et + " " + premium +  " <div> Payment </div>";
                    }
                }
            };


            ajax.send("tier="+tier+"&sp="+sp+"&pn="+pn+"&tn="+tn+"&pd="+pd+"&pc="+pc+"&pu="+pu+"&pac="+pac+"&et="+et+"&premium="+premium+"&ooc="+ooc+"&c2="+c2+"&totalcost="+totalcost+"&b="+b+"&bc="+bc);

        }
    }





/*
    $(document).ready(function(){
        $('.cbimg').mouseenter(function(){
            $('.cbimg').css("display", "none");
            $('.hiddencbimg').css("display", "initial");
        });
        $('.hiddencbimg').mouseleave(function(){
            $('.hiddencbimg').css("display", "none");
            $('.cbimg').css("display", "initial");
        });

    });

*/
    $(document).ready(function(){
    $('.jobimages').popover({placement:'bottom'});

    });

</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>