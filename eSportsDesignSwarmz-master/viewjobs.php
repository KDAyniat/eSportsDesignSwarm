<?php

include_once("php_includes/check_login_status.php");




    $table_data = '<tr>
                        <td>'.$sp_display.'</td>
                        <td>'.$pn.'</td>
                        <td>'.$choice_display.'</td>
                        <td>'.$pd.'</td>
                        <td>'.$et_display.'</td>

                    </tr>';


/*
while($row = $jobs_query->fetch_assoc()) {
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

 $job_id = mysql_result($jobs_query, $i, "id");
      $tier = mysql_result($jobs_query, $i, "tier");
      $sp = mysql_result($jobs_query, $i, "setprice");
      $totalprice = mysql_result($jobs_query, $i, "totalprice");
      $choice = mysql_result($jobs_query, $i, "job_type");
      $pn = mysql_result($jobs_query, $i, "proj_name");
      $tn = mysql_result($jobs_query, $i, "team_name");
      $pd = mysql_result($jobs_query, $i, "detail");
      $pc = mysql_result($jobs_query, $i, "colors");
      $pu = mysql_result($jobs_query, $i, "design_usage");
      $pac = mysql_result($jobs_query, $i, "comments");
      $pl = mysql_result($jobs_query, $i, "links");
      $premium = mysql_result($jobs_query, $i, "premium");
      $ooc = mysql_result($jobs_query, $i, "ooc");
      $et = mysql_result($jobs_query, $i, "end_date");
      $badge = mysql_result($jobs_query, $i, "badge");
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
    <?php
    include_once("php_includes/db_connects.php");
    $sql = "SELECT * FROM jobs WHERE paidfor='1' ";
    $jobs_query = mysqli_query($db_conx, $sql);
    // Now make sure that user exists in the table
    $numrows = mysqli_num_rows($jobs_query);
?>
    <div style="width 800px; text-align:center;">
    <table id="jobstable" style="padding:10px; margin:10px auto;">
    <thead>Open Jobs</thead>
    <tr>
        <th>View</th>
        <th>Prize</th>
        <th>Job Name</th>

        <th>Job Type</th>
        <th>Open/Closed</th>
        <th>Job Description</th>
        <th>End Date</th>
    </tr>
      <?php
      $i = 0; while($i < $numrows){
          $row=mysqli_fetch_array($jobs_query,MYSQLI_ASSOC);
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


      $choice_display= '';
      if($choice == "l" && $premium == "p"){
      $choice_display= 'Premium Logo Design';
      } else if ($choice == "i" && $premium == "p"){
      $choice_display = 'Premium Illustration Design';
      }else if ($choice == "i" && $premium == "n"){
      $choice_display = 'Non-Premium Illustration Design';
      }else if ($choice == "l" && $premium == "n"){
      $choice_display = 'Non-Premium Logo Design';
      }  else if ($choice == "s" && $premium == "p"){
          $choice_display = 'Premium Social Network Design';
      }else if ($choice == "s" && $premium == "n"){
          $choice_display = 'Non-Premium Social Network Design';
      }else if ($choice == "t" && $premium == "n"){
          $choice_display = 'Non-Premium Twitter Package Design';
      } else if ($choice == "t" && $premium == "p"){
          $choice_display = 'Premium Twitter Package Design';
      }else if ($choice == "j" && $premium == "n"){
          $choice_display = 'Non-Premium Jersey Design';
      }else if ($choice == "j" && $premium == "p"){
          $choice_display = 'Premium Jersey Design';
      }else if ($choice == "a" && $premium == "n"){
          $choice_display = 'Non-Premium Apparel Design';
      }else if ($choice == "a" && $premium == "p"){
          $choice_display = 'Premium Apparel Design';
      }else if ($choice == "g" && $premium == "n"){
          $choice_display = 'Non-Premium GIF Design';
      }else if ($choice == "g" && $premium == "p"){
          $choice_display = 'Premium GIF Design';
      }else if ($choice == "in" && $premium == "n"){
          $choice_display = 'Non-Premium Intro Design';
      }else if ($choice == "in" && $premium == "p"){
          $choice_display = 'Premium Intro Design';
      }else if ($choice == "v" && $premium == "n"){
          $choice_display = 'Non-Premium Video Editing';
      }else if ($choice == "v" && $premium == "p"){
          $choice_display = 'Premium Video Editing';
      }else if ($choice == "b" && $premium == "n"){
          $choice_display = 'Non-Premium Web Banner Design';
      }else if ($choice == "b" && $premium == "p"){
          $choice_display = 'Premium Web Banner Design';
      }else if ($choice == "w" && $premium == "n"){
          $choice_display = 'Non-Premium Web Design';
      }else if ($choice == "w" && $premium == "p"){
          $choice_display = 'Premium Web Design';
      }


          $ooc_display = '';
      if($ooc == "c"){
      $ooc_display = 'Closed Contest';
      } else{
      $ooc_display = "Open Contest";
      }



      $sp_display = '$'.$sp.'.00';
      $tp_display = '$'.$totalprice.'.00';
      $et_display = strftime("%b %d, %Y", $et);
      $of_display = '$'.$ourfee.'.00';
          $view = '<a href="viewjob.php?id='.$job_id.'"onclick="viewjob()">View</a>'
      ?>


          <tr>
                <td><?php echo $view;?></td>
              <td><?php echo $sp_display;?></td>
              <td><?php echo $pn;?></td>
              <td><?php echo $choice_display;?></td>
              <td><?php echo $ooc_display;?></td>
              <td><?php echo $pd;?></td>
              <td><?php echo $et;?></td>

          </tr>
    <?php
    $i++;}
    ?>

</table>
    </div>
</div>
<?php include_once("php_includes/pageBottom.php"); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>


