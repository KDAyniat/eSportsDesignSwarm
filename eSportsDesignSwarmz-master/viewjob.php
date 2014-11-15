<?php

include_once("php_includes/check_login_status.php");


if($user_ok == true){




if(isset($_GET["id"])){
    $job_id = preg_replace('#[^a-z0-9]#i', '', $_GET['id']);
} else {
    header("location: http://www.esportsdesignswarm.com");
    exit();
}

$sql = "SELECT * FROM jobs WHERE id='$job_id' LIMIT 1";
$job_query = mysqli_query($db_conx, $sql);

while ($row = mysqli_fetch_array($job_query, MYSQLI_ASSOC)) {
    $job_id = $row["id"];
    $tier = $row["tier"];
    $sp = $row["setprice"];
    $totalprice = $row["totalprice"];
    $choice = $row["job_type"];
    $pn = $row["proj_name"];
    $tn = $row["team_name"];
    $pd = $row["detail"];
    $pc = $row["colors"];
    $pu = $row['design_usage'];
    $pac = $row["comments"];
    $pl = $row["links"];
    $premium = $row["premium"];
    $ooc = $row["ooc"];
    $et = $row['end_date'];
    $badge = $row['badge'];
    $init = $row['initiator'];
}
$bonusprize = '';
if($job_id == 79){
    $bonusprize = '<img src="images/esportcareerextraprizesbanner.jpg" alt="bonus prizes"/> ';
}
if($job_id == 80){
    $bonusprize = '<img src="images/stickygripsbanner.jpg" alt="bonus prize" />';
}


$badge_value = '';

if ($badge == "0" || $badge == "2" || $badge == "3"){
    $badge_value = 0;
}

$choice_display= '';
if($choice == "l" && $premium == "p"){
    $choice_display= 'Premium Logo Design';
} else if ($choice == "i" && $premium == "p"){
    $choice_display = 'Premium Illustration Design';
}else if ($choice == "i" && $premium == "n"){
    $choice_display = 'Non-Premium Illustration Design';
}else if ($choice == "l" && $premium == "n"){
    $choice_display = 'Non-Premium Illustration Design';
}

$entries = '<form onsubmit="return false"><input type="hidden" id="ooc" value="o"/>
           <input type="hidden" id="jobid" value="'.$job_id.'" ><a href="#" type="submit" id="e" onclick="entries()"><img style="float:left;margin:0 10px 0 240px;" src="images/contestentries.png" alt="btn">  </a></form>';
$ooc_display = '';
if($ooc == "c"){
    $ooc_display = 'Closed Contest';
    $entries = '<form onsubmit="return false" style="float:left;"><input type="hidden" id="ooc" value="c"/>
           <input type="hidden"  id="jobid" value="<?php echo $job_id;?>" ><a href="#" type="submit" id="e" onclick="entries()"><img style="float:left;margin:0 10px 0 240px;" src="images/contestentries.png" alt="btn">  </a></form>';
$entries_body = ' <div id="entries" style="display:none; width:1000px;background-color: #262626; margin:20px auto; text-align: center">
           <div style="padding:50px "> <img src="images/defaultprofileclosedcontest.png" alt="closed contest" /> </div>

        </div>';






} else {
    $ooc_display = "Open Contest";

    $entries_body=   '<div id="entries" style="display:none; width:1000px;background-color: #262626; margin:20px auto; text-align: center">
<input type="hidden" id="ooc" value="o"/>
<input type="hidden" name="jobid" value="'.$job_id.'" >
</div>';


}

$ourfee = $totalprice - $sp;

$sp_display = '$'.$sp.'.00';
$tp_display = '$'.$totalprice.'.00';
$et_display = strftime("%b %d, %Y", $et);
$of_display = '$'.$ourfee.'.00';

$badge_display = '';
if ($badge_value == 0){
    $badge_display = 'Yes';
} else{
    $badge_display = 'No';
}

$examples = '<a href="examples.php?u='.$init.'" style="color:white;"> See Design Examples</a>';

if($user_ok == true){
    $entercontest = '';
} else {
    $entercontest = '<div id="enter" style="display:none; width:1000px; height:600px;background-color: #262626; margin:20px auto; text-align: center; color:white;">
<h2>You Must Be Logged In To Enter Jobs <a href="#signin" data-toggle="modal" style="color:white;">Click Here To Log In </a></h2>

</div>';
}

$photo_form  = '<form id="photo_form" enctype="multipart/form-data" method="post" action="php_includes/submission_system.php">';
$photo_form .=   ' &nbsp; &nbsp; &nbsp; <b>Upload Submission</b> ';
$photo_form .=   '<input  type="file" name="photo" accept="image/*" required>';
$photo_form .=   '<p><input style="color:black;" type="submit" onclick="submission()" value="Upload Submission Now"></p>';
$photo_form .= '</form>';


/*<?php

include_once("php_includes/db_connects.php");
$sql = "SELECT * FROM submission WHERE job_id='$job_id'";
$sub_query = mysqli_query($db_conx, $sub_query);
$sub_row = mysqli_num_rows($sub_query);


$i = -1;
while($i < $sub_row){
    $row=mysqli_fetch_array($sub_query,MYSQLI_ASSOC);
    $filename = $row['filename'];
    $u= $row['submitted_by'];
    $sub_img = '<div style="float:left; margin:20px;display: inline-block; "><img style="width:200px;" src="user/'.$u.'/'.$filename.'" alt="submission"></div>';


    ?>
    <div id="entries" style=" display: none; width:1000px; height:600px;background-color: #262626; margin:20px auto; text-align: center">
        <?php echo $sub_img;?>

    </div>


    <?php  $i++;} ?>

*/

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
        <img src="images/jobbuttons/swarmpng.png" alt="swarming" style="position:absolute; top:160px;right:-100px;z-index: -1; margin-right: 20px;">
 <img src="images/job%20viewpage.jpg" alt="designer info"/>
<div style="width:1000px;height:125px; background-color: #262626;margin:auto;text-align: center;">
    <h2 style="color:white;"><?php echo $pn;?></h2>

        <?php echo $entries;?>
        <a href="#" type="submit" id="d" onclick="details()"><img style="float:left;margin:0 10px;" src="images/detailsbuttton.png" alt="btn">  </a>
        <a href="#" type="submit" id="en" onclick="enterContest()"><img style="float:left;margin:0 10px;" src="images/entercontest.png" alt="btn">  </a>

</div>




<?php echo $entries_body;?>

<div id="details" style=" width:1000px;  background-color: #262626; margin:20px auto; text-align: center; color:white; padding:10px;">

        <p> <?php echo $choice_display; ?></p>
    <p><?php echo $ooc_display; ?></p>
    <div style="text-align: center"><?php echo $bonusprize;?></div>
    <div style="width:600px;text-align: justify ;margin:20px 0 20px 200px;">

        <p> Contest Prize:<br/> <div style="border:3px solid #5a8700;"><span>&nbsp;  <?php echo $sp_display; ?></span></div></p>

        <p>Project Name:<br/>  <div style="border:3px solid #5a8700;"><span>&nbsp; <?php echo $pn; ?> </span></div></p>
        <p>Business/Team Name:<br/>  <div style="border:3px solid #5a8700;"><span>&nbsp;<?php echo $tn; ?> </span></div></p>
        <p> Project Details:<br/>  <div style="border:3px solid #5a8700;"><span>&nbsp;<?php echo $pd; ?> </span></div></p>
        <p> Primary Colors:<br/> <div style="border:3px solid #5a8700;"> <span>&nbsp;<?php echo $pc; ?> </span></div></p>
        <p>Additional Design Comments:<br/>  <div style="border:3px solid #5a8700;"> <span>&nbsp;<?php echo $pac; ?> </span></div></p>
        <p>Project Usage/Primary Game:<br/>  <div style="border:3px solid #5a8700;"> <span>&nbsp;<?php echo $pu; ?></span></div></p>

        <p> Contest End Date:<br/> <div style="border:3px solid #5a8700;"> <span>&nbsp;<?php echo $et; ?></span> </div></p>
        <p>Custom Badge?:<br/>  <div style="border:3px solid #5a8700;"> <span>&nbsp;<?php echo $badge_display?></span></div></p>
        <p><?php echo $examples;?></p>
        <!--   <a href="#" onclick="working()" style="text-align: center"><img src="images/workingonit.png" alt="working"/></a> -->
       </div>
</div>
        <div id="enter" style="display:none; width:1000px; height:600px;background-color: #262626; margin:20px auto; text-align: center; color:white;">
        <h2>Enter This Contest!</h2>




            <form id="photo_form" enctype="multipart/form-data" method="post" action="php_includes/submission_system.php">
                &nbsp; &nbsp; &nbsp; <b>Upload Submission</b>
                <input type="hidden" name="jobid" value="<?php echo $job_id;?>" >
                <input style="margin-left:400px;" type="file" name="photo" accept="image/*" required>
                <label for="agree">I Have Read, Understand And Agree To The Rules And Terms Of Use For This Contest
                    <input id="agree" type="checkbox" required>
                <p><input style="color:black; margin:20px;" type="submit" value="Upload Submission Now"></p>
<?php  if (!file_exists("user/$log_username/jobs/$job_id")) {
    mkdir("user/$log_username/jobs/$job_id", 0755);
}?>
                </label><br/>
                </form>






        </div>

    </div>

<?php include_once("php_includes/pageBottom.php"); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    function entries(){
        var jobid= _("jobid").value;
        var ooc = _("ooc").value;
        var ent = _("entries");
        var det = _("details");
        var en = _("enter");

        if(ooc == "c"){
        ent.style.display = "block";
        det.style.display = "none";
        en.style.display = "none";
        } else{



            var ajax = ajaxObj("POST", "entries.php");
            ajax.onreadystatechange = function() {
                window.location = "entries.php?id="+jobid;
            }
            }

            ajax.send("ooc="+ooc+"&jobid="+jobid);

        }




    function details(){
        var ent = _("entries");
        var det = _("details");
        var en = _("enter");

        ent.style.display = "none";
        det.style.display = "block";
        en.style.display = "none";


    }
    function enterContest(){
        var ent = _("entries");
        var det = _("details");
        var en = _("enter");

        ent.style.display = "none";
        det.style.display = "none";
        en.style.display = "block";


    }

    function working(){
        var w = 1;

        var ajax = ajaxObj("POST", "entries.php");
        ajax.onreadystatechange = function() {

        }


    ajax.send("w="+w);

    }

</script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
    </body>
</html>
<?php }else{ echo "you must be logged in to view contests";}?>