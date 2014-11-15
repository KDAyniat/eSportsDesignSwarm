<?php include_once('php_includes/check_login_status.php');

include_once("php_includes/db_connects.php");




$sql = "SELECT * FROM jobs WHERE initiator='$log_username'ORDER BY start_date DESC  LIMIT 1";
$jobs_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($jobs_query);



while ($row = mysqli_fetch_array($jobs_query, MYSQLI_ASSOC)) {
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


$ooc_display = '';
if($ooc == "c"){
    $ooc_display = 'Closed Contest';
} else{
    $ooc_display = "Open Contest";
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

</head>
<body style="padding-bottom: 70px; padding-top: 70px; text-align: center">
<?php include_once("php_includes/pageTop.php"); ?>

<div id="pageMiddle">
    <h2> Job Review </h2>
    <div style="width:600px;background-color:#262626; color:grey; text-align: center; margin:auto;">

    <div id="jobreview" style="width:575px;">
       <p> <?php echo $choice_display; ?></p>
       <p><?php echo $ooc_display; ?></p>
     <p> Contest Prize: <span style="color:#5a8700;"> <?php echo $sp_display; ?></span></p>
        <p><a href="#ourfees" data-toggle="modal" style="color:#5a8700"> Our Fees: </a><span > <?php echo $of_display; ?></span></p>

       <p>Project Name:<span style="color:#5a8700;"> <?php echo $pn; ?> </span></p>
       <p>Team Name:<span style="color:#5a8700;"><?php echo $tn; ?> </span></p>
        <p> Project Details:<span style="color:#5a8700;"><?php echo $pd; ?> </span></p>
        <p> Primary Colors:<span style="color:#5a8700;"><?php echo $pc; ?> </span></p>
       <p>Additional Design Comments: <span style="color:#5a8700;"><?php echo $pac; ?> </span></p>
        <p>Project Usage/Primary Game: <span style="color:#5a8700;"><?php echo $pu; ?></span></p>
       <p> Provided Links:<span style="color:#5a8700;" ><?php echo $pl; ?></span> </p>
        <p> Contest End Date:<span style="color:#5a8700;"><?php echo $et; ?></span> </p>
        <p>Custom Badge?: <span style="color:#5a8700;"><?php echo $badge_display?></span></p>
        <p style="color:#5a8700">Total Cost To You: <?php echo $tp_display;?> </p>
        <p>At this time you must manually enter the total cost for the project.</p>
        <p>The contest will not displayed until payment is verified.</p>
        <p>We appreciate your patience with us through our beta phase</p>

    </div>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="9VYWZQXN6P4DY">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>
</div>


<?php include_once("php_includes/pageBottom.php"); ?>

<div class="modal fade" id="ourfees" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">



        </div>
        <div class="modal-body">

            <img src="images/ourfees.jpg" alt="our fees"/>


        </div>


    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>