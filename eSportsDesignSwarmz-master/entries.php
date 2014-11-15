
<?php

include_once("php_includes/check_login_status.php");

if(isset($_GET["id"])){
    $job_id = preg_replace('#[^a-z0-9]#i', '', $_GET['id']);
    $ooc =  preg_replace('#[^a-z0-9]#i', '', $_POST['ooc']);

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
$backtojob = '<a href="viewjob.php?id='.$job_id.'">Back to Job Details Page</a>';

$isOwner = "no";
if($init == $log_username && $user_ok == true) {
    $isOwner = "yes";
        $ownermsg = '<p>Clients Please Contact Each Designer Individually To Request Any Changes In Any Of Their Submissions
 </p><p>You can do this by clicking on their username and messaging them using our private messaging system on the bottom of each profile page. </p>';

}


if($isOwner == "no" && $ooc == "c"){
    header("location: www.esportsdesignswarm.com");
}

if(isset($_POST["rating"])){
$rating = $_POST["rating"];
    $designer = $_POST["designer"];
    include_once("php_includes/db_connects.php");
    $sql = "UPDATE submission SET rating='.$rating.' WHERE submitted_by='.$designer.' VALUE  ";
    $query = mysqli_query($db_conx,$sql);

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

<?php

include_once("php_includes/db_connects.php");
$sql = "SELECT * FROM submission WHERE job_id='$job_id'";
$sub_query = mysqli_query($db_conx, $sql);
$sub_row = mysqli_num_rows($sub_query);

?>
    <div id="header"><h2>Project Entries</h2></div>
        <?php echo $backtojob;?><br/>
        <?php echo $ownermsg;?>

    <div id="entries" style="width:1000px; height:1000px; background-color: #262626; margin:20px auto; text-align: center">
<?php
$i = 0;
while($i < $sub_row){
    $row=mysqli_fetch_array($sub_query,MYSQLI_ASSOC);

    $u = $row['submitted_by'];


    $file = $row['filename'];


    $sub_img = '<a href="user/'.$u.'/jobs/'.$job_id.'/'.$file.'" target="blank"> <img class="i" style="width:200px;" src="user/'.$u.'/jobs/'.$job_id.'/'.$file.'" alt="submission"></a>';


    $u_link= '<a href="user.php?u='.$u.'" style="color:white;">&nbsp;  '.$u.'    </a>';

    $setrating = '';
    if($isOwner == "yes"){
        $setrating = '<form onsubmit="return false" id="ratings">
                    <label for="stars"></label> <input type="hidden" id="designer" value="'.$u.'"> <input type="submit" id="stars" onclick="setRating()" value="1">
                    <label for="stars"></label> <input type="hidden" id="designer" value="'.$u.'"><input type="submit" id="stars" onclick="setRating()"  value="2">
                    <label for="stars"></label><input type="hidden" id="designer" value="'.$u.'"> <input type="submit" id="stars" onclick="setRating()"  value="3">
                    <label for="stars"></label> <input type="hidden" id="designer" value="'.$u.'"><input type="submit" id="stars" onclick="setRating()"  value="4">
                    <label for="stars"></label> <input type="hidden" id="designer" value="'.$u.'"><input type="submit" id="stars" onclick="setRating()"  value="5">
            </form>  ';
    }

    ?>

    <div style="float:left; margin:20px;display: inline-block; ">
        <?php echo $sub_img;?><br/>

        <p style="color:white;">Submitted By:<?php echo $u_link;?></p>
        <p style="color:white;">Rating:<span id="ratingspan"></span> <?php echo $setrating;?></p>
    </div>

    <?php  $i++;} ?>


      <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(this).find('.i').mouseenter(function(){
                    $('.i').css("display", "none");
                    $('.il').css("display", "initial");
                });
                $(this).find('.il').mouseleave(function(){
                    $('.il').css("display", "none");
                    $('.i').css("display", "initial");
                });

            });
        </script> -->

</div>


<?php include_once("php_includes/pageBottom.php"); ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
        function setRating(){
            var rating = _("stars").value;
            var designer = _("designer").value;
            var rs = _("ratingspan");
            var ajax = ajaxObj("POST", "entries.php");
            ajax.onreadystatechange = function() {
                rs.innerHTML = rating;
            }
        }

        ajax.send("rating="+rating+"&designer="+designer);


        }





</script>

<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>
