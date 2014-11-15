<?php include_once('php_includes/check_login_status.php');


if(isset($_POST['c'])){

    include_once('php_includes/db_connects.php');
$choice = $_POST['c'];



    if($user_ok == true){
        if ($choice == "undefined"){
            echo "choice_failed";

        } else {
            echo "choice_success";
            $_SESSION['choice'] = $choice;
            setcookie("choice", $choice, strtotime( '15 minutes' ), "/", "", "", TRUE);
        }
    } else {
        echo "not_reg";
        exit();
    }
    exit();

}

if(isset($_POST['tier'])){
    include_once('php_includes/db_connects.php');
    $choice = $_SESSION['choice'];
    $tier = preg_replace('#[^a-z0-9. ]#i', '', $_POST['tier']);
    $sp = preg_replace('#[^a-z0-9$. ]#i', '', $_POST['sp']);
    $pn = preg_replace('#[^a-z ]#i', '', $_POST['pn']);
    $tn = preg_replace('#[^a-z ]#i', '', $_POST['tn']);
    $pd = preg_replace('#[^a-z0-9]#i', '', $_POST['pd']);
    $pc = preg_replace('#[^a-z0-9 ]#i', '', $_POST['pc']);
    $pu = preg_replace('#[^a-z0-9 ]#i', '', $_POST['pu']);
    $pac = preg_replace('#[^a-z ]#i', '',  $_POST['pac']);
    $pl = preg_replace('#[^a-z0-9///&$._- ]#i', '',$_POST['pl']);
    $et = preg_replace('#[^a-z0-9/-/// ]#i', '', $_POST['et']);
    $premium = preg_replace('#[^a-z0-9 ]#i', '', $_POST['premium']);
    $ooc = preg_replace('#[^a-z ]#i', '', $_POST['ooc']);

        // double check these field names and usages
    $sql = "SELECT id FROM jobs WHERE username='$log_username' AND proj_name='$pn' AND end_date> now() LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $job_check = mysqli_num_rows($query);
    // form error check - double check pricing choices here
    if($tier == "" || $sp == "" || $pn == "" || $pd =="" || $pc == ""|| $pu =="" || $et == "" || $premium == "") {
        echo "form data missing'.$tier.' '.$sp.' '.$pn.' '.$pd.' '.$pc.' '.$pu.' '.$et.' '.$premium.'";
    } else if($job_check > 0){
        echo "You already have an open project called '.$pn.'. If this is a new project, please choose another name";
    } else {

        //check db table names
      $sql = "INSERT INTO jobs (initiator, tier, setprice, job_type, proj_name, team_name, detail, colors, design_usage, comments, links,premium, ooc, start_date, end_date)
              VALUES ('$log_username', '$tier','$sp', '$choice','$pn','$tn','$pd', '$pc','$pu', '$pac','$pl','$premium','$ooc',now(), '$et' )";
        $query = mysqli_query($db_conx, $sql);
        if (!file_exists("user/$u/jobs")) {
            mkdir("user/$u/jobs", 0755);
        }


        $_SESSION['ooc'] = $ooc;
        $_SESSION['premium'] = $premium;
        $_SESSION['endtime'] = $et;
        $_SESSION['projlinks'] = $pl;
        $_SESSION['addcom'] = $pac;
        $_SESSION['projusage'] = $pu;
        $_SESSION['projcolor'] = $pc;
        $_SESSION['projdetail'] = $pd;
        $_SESSION['teamname'] = $tn;
        $_SESSION['projname'] = $pn;
        $_SESSION['setprice'] = $sp;
        $_SESSION['tier'] = $tier;
        setcookie("ooc", $ooc, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("premium", $premium, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("endtime", $et, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("projlinks", $pl, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("addcom", $pac, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("projusage", $pu, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("projcolor", $pc, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("projdetail", $pd, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("teamname", $tn, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("projname", $pn, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("setprice", $sp, strtotime( '15 minutes' ), "/", "", "", TRUE);
        setcookie("tier", $tier, strtotime( '15 minutes' ), "/", "", "", TRUE);




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


$choice = $_SESSION['choice'];
$ooc =$_SESSION['ooc'] ;
$premium =$_SESSION['premium'] ;
 $et = $_SESSION['endtime'] ;
$pl = $_SESSION['projlinks'] ;
$pac = $_SESSION['addcom'];
$pu = $_SESSION['projusage'];
$pc = $_SESSION['projcolor'];
$pd = $_SESSION['projdetail'];
$tn = $_SESSION['teamname'] ;
$pn = $_SESSION['projname'];
$sp = $_SESSION['setprice'];
$tier = $_SESSION['tier'] ;

$tieroptions = '';
if ($choice == "l"){
    $tieroptions = '  <option value=""></option>
 <option value="t1">Tier 1: $15-$20</option>
<option value="t2">Tier 2: $21-$35</option>
<option value="t3">Tier 3: $36-$50</option>
<option value="t4">Tier 4: $51-$75</option>
<option value="t5">Tier 5: $76-$90</option>
<option value="t6">Tier 6: $91-$110</option>
<option value="t7">Tier 7: $111-$150</option>
<option value="t8">Tier 8: $151-$200</option>
<option value="t10">Unlimited: $200+</option>';
} else if ($choice == "i"){
    $tieroptions = '  <option value=""></option>
 <option value="t1">Tier 1: $15-$20</option>
<option value="t2">Tier 2: $21-$35</option>
<option value="t3">Tier 3: $36-$50</option>
<option value="t4">Tier 4: $51-$75</option>
<option value="t5">Tier 5: $76-$90</option>
<option value="t6">Tier 6: $91-$110</option>
<option value="t7">Tier 7: $111-$150</option>
<option value="t8">Tier 8: $151-$200</option>
<option value="t10">Unlimited: $200+</option>';
} else{
    $tieroptions = '';
}



} else if ($tier == "t2") {
    if ($sp < 21) {
        echo "Minimum Price for this tier is $21";
    } else if ($sp > 35) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t3") {
    if ($sp < 36) {
        echo "Minimum Price for this tier is $36";
    } else if ($sp > 50) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t4") {
    if ($sp < 51) {
        echo "Minimum Price for this tier is $51";
    } else if ($sp > 75) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t5") {
    if ($sp < 76) {
        echo "Minimum Price for this tier is $76";
    } else if ($sp > 90) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t6") {
    if ($sp < 91) {
        echo "Minimum Price for this tier is $91";
    } else if ($sp > 110) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t7") {
    if ($sp < 111) {
        echo "Minimum Price for this tier is $111";
    } else if ($sp > 150) {
        echo "Set price is too high for this pricing tier, please choose a different tier";
    }
}else if ($tier == "t8") {
    if ($sp < 151) {
        echo "Minimum Price for this tier is $151";
    } else if ($sp > 200) {
        echo "Set price is too high for this pricing tier, please use our Unlimited Tier";
    }
}else if ($tier == "t10") {
    if ($sp < 201) {
        echo "Minimum Price for this tier is $201";
    }
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
        <button type="submit" onclick="jobSelect()" id="firstnextbtn">Next</button>
        <span id="progress"></span>
    </div>
</div>


<div id="pageMiddle2" style="display:none">
    <div>
        <h2> Job Details <?php echo $choice;?></h2>
    </div>
    <div id="jdform">
    <form id="jobdetails" onsubmit="return false;" role="form">
    <label for="tier">*Pricing Tier:
        <select id="tier">
            <?php echo $tieroptions;?>

        </select>

    </label>
        <span id="ourfee"></span>
        <p>Price setting explanation details derp a derpa derp</p>
        <label for="projsetprice"> *Set Your Price:
            <input type="number" id="projsetprice" placeholder="minprice">
        </label>
    <label for="projname">*Project Name:
        <input type="text" id="projname" placeholder="Enter Project Name">
    </label>
        <label for="teamname">Team Name:
            <input type="text" id="teamname" placeholder="Enter Team Name">
        </label>
    <label for="projdetails">*Project Details:
        <textarea id="projdetails"></textarea>
    </label>
        <label for="projcolors"> *Primary Project Colors:
            <input type="text" id="projcolors" placeholder="Enter Primary Colors">
        </label>
        <label for="projusage"> *Project Usage/Primary Game
            <textarea id="projusage"></textarea>
        </label>
        <label for="projcomments">Additional Comments to Designers:
            <textarea id="projcomments"></textarea>
        </label>
        <label for="projlinks">Links To Design Ideas:
            <textarea id="projlinks"></textarea>
        </label>
        <label for="endtime"> *Date Needed By:
            <input type="date" id="endtime" placeholder="mindate">
        </label>
        <label for="prem"> *Premium or Non-Premium:
        <select id="prem">
            <option value=""></option>
            <option value="0">Premium- add $X</option>
            <option value="1">Non-Premium</option>
        </select>
        </label>
        <label for="ooc">Open Or Closed Contest:
            <select id="ooc">
                <option value="o">Open</option>
                <option value="c">Closed</option>
            </select>
        </label>
        <button type="submit" onclick="jobDetails()" id="secondnextbtn">Next</button>
        <span id="progress"></span>
    </form>
    </div>
</div>

<div id="pageMiddle3" style="display: none">
    Review your project:
    <div>
        <?php echo $choice_display; ?> <br/>
        <?php echo $tier_choice; ?> <br/>
    <?php echo $sp; ?> <br/>
    <?php echo $pn; ?> <br/>
    <?php echo $tn; ?> <br/>
    <?php echo $pd; ?> <br/>
    <?php echo $pc; ?> <br/>
    <?php echo $pac; ?> <br/>
    <?php echo $pu; ?> <br/>
    <?php echo $pl; ?> <br/>
    <?php echo $et; ?> <br/>
        <?php echo $ooc; ?> <br/>

    </div>
</div>




<?php include_once("php_includes/pageBottom.php"); ?>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script>
    var c;



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

        alert(c);
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

                    _("pageMiddle").innerHTML = c+ " <div> all the things </div>";
                    _("pageMiddle2").style.display = "initial";
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

        var tier = _("tier").value;
        var sp = _("projsetprice").value;
        var pn = _("projname").value;
        var tn = _("teamname").value;
        var pd = _("projdetails").value;
        var pc = _("projcolors").value;
        var pu = _("projusage").value;
        var progress = _("progress");
        var pac = _("projcomments").value;
        var pl = _("projlinks").value;
        var et = _("endtime").value;
        var premium = _("prem").value;
        var ooc = _("ooc").value;
        var etparse = Date.parse(et);
        if(tier == "" || sp == "" || pn =="" ||  pd == "" || pc == "" || pu == "" || et == "" || premium == ""){
            progress.innerHTML = "Please Fill Out All Required Form Data";

        } else if (etparse < (Date.now()+172800000)){
            alert("date must be at least 3 days in the future!");
        } else if (tier == "t1"){
            if(sp < 15){
                alert("Minimum Price is $15");
            } else if (sp > 20){
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        } else if (tier == "t2") {
            if (sp < 21) {
                alert("Minimum Price for this tier is $21");
            } else if (sp > 35) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t3") {
            if (sp < 36) {
                alert("Minimum Price for this tier is $36");
            } else if (sp > 50) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t4") {
            if (sp < 51) {
                alert("Minimum Price for this tier is $51");
            } else if (sp > 75) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t5") {
            if (sp < 76) {
                alert("Minimum Price for this tier is $76");
            } else if (sp > 90) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t6") {
            if (sp < 91) {
                alert("Minimum Price for this tier is $91");
            } else if (sp > 110) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t7") {
            if (sp < 111) {
                alert("Minimum Price for this tier is $111");
            } else if (sp > 150) {
                alert("Set price is too high for this pricing tier, please choose a different tier");
            }
        }else if (tier == "t8") {
            if (sp < 151) {
                alert("Minimum Price for this tier is $151");
            } else if (sp > 200) {
                alert("Set price is too high for this pricing tier, please use our Unlimited Tier");
            }
        }else if (tier == "t10") {
            if (sp < 201) {
                alert("Minimum Price for this tier is $201");
            }
        }
        else {
            _("secondnextbtn").style.display = "none";
            progress.innerHTML = "Please Wait...";
            var ajax = ajaxObj("POST", "jobs.php");
            ajax.onreadystatechange = function(){
                if(ajaxReturn(ajax) == true){
                    if(ajax.responseText != "form_success"){
                        progress.innerHTML = ajax.responseText;

                    } else{
                        _("pageMiddle2").style.display = "none";
                        _("pageMiddle").style.display = "none";
                        _("pageMiddle3").style.display = "initial";
                     //  _("pageMiddle3").innerHTML = tier+ " " + sp + " " + pn + " " + pd + " " + pc + " " + pu + " " + et + " " + premium +  " <div> Payment </div>";
                    }
                }
            }
            ajax.send("tier="+tier+"&sp="+sp+"&pn="+pn+"&tn="+tn+"&pd="+pd+"&pc="+pc+"&pu="+pu+"&pac="+pac+"&pl="+pl+"&et="+et+"&premium="+premium+"&ooc="+ooc);

        }
    }


    if(premium == 0){
        totalcost = sp + 5;
    } else if (ooc == "c"){
        totalcost = sp + 3;
    } else if (ooc == "c" && premium == "0"){
        totalcost = sp + 8;
    } else{
        totalcost = sp;
    }





    $(document).ready(function(){
    $('.jobimages').popover({placement:'bottom'});
    });

</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>