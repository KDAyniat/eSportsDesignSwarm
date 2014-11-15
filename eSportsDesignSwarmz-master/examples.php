
<?php
include_once("php_includes/check_login_status.php");
// Make sure the _GET "u" is set, and sanitize it
$u = "";
if(isset($_GET["u"])){
    $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
    header("location: http://www.esportsdesignswarm.com");
    exit();
}




$photo_form = "";
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
    $isOwner = "yes";
    $photo_form  = '<form id="photo_form" enctype="multipart/form-data" method="post" action="php_includes/photo_system.php">';
    $photo_form .=   '<h3>Hi '.$u.', add design examples for your project</h3>';
    $photo_form .=   '<b>Choose Gallery:</b> ';
    $photo_form .=   '<select name="gallery" required>';
    $photo_form .=     '<option value=""></option>';
    $photo_form .=     '<option value="Gamer Logos">Gamer Logos</option>';
    $photo_form .=     '<option value="Headers">Headers</option>';
    $photo_form .=     '<option value="GIFs">GIFs</option>';
    $photo_form .=     '<option value="Banners">Banners</option>';
    $photo_form .=     '<option value="Random Designs">Random Designs</option>';
    $photo_form .=     '<option value="Graphic Overlays">Graphic Overlays</option>';
    $photo_form .=     '<option value="Twitch">Twitch</option>';
    $photo_form .=     '<option value="Youtube Headers">Youtube Headers</option>';
    $photo_form .=     '<option value="Youtube Headers">Illustrations</option>';
    $photo_form .=   '</select>';
    $photo_form .=   ' &nbsp; &nbsp; &nbsp; <b>Choose graphic:</b> ';
    $photo_form .=   '<input type="file" name="photo" accept="image/*" required>';
    $photo_form .=   '<p><input type="submit" value="Upload Image Now(3mb max)"></p>';
    $photo_form .= '</form>';
}
// Select the user galleries
$gallery_list = "";
$sql = "SELECT DISTINCT gallery FROM photos WHERE user='$u'";
$query = mysqli_query($db_conx, $sql);
if(mysqli_num_rows($query) < 1){
    $gallery_list = "This user has not uploaded any photos yet.";
} else {
    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        $gallery = $row["gallery"];
        $countquery = mysqli_query($db_conx, "SELECT COUNT(id) FROM photos WHERE user='$u' AND gallery='$gallery'");
        $countrow = mysqli_fetch_row($countquery);
        $count = $countrow[0];
        $filequery = mysqli_query($db_conx, "SELECT filename FROM photos WHERE user='$u' AND gallery='$gallery' ORDER BY RAND() LIMIT 1");
        $filerow = mysqli_fetch_row($filequery);
        $file = $filerow[0];
        $gallery_list .= '<div>';
        $gallery_list .=   '<div onclick="showGallery(\''.$gallery.'\',\''.$u.'\')">';
        $gallery_list .=     '<img src="user/'.$u.'/'.$file.'" alt="cover photo">';
        $gallery_list .=   '</div>';
        $gallery_list .=   '<b>'.$gallery.'</b> ('.$count.')';
        $gallery_list .= '</div>';
    }
}

$badge_check = "SELECT wins, entries, first_place, second_place, third_place FROM badges WHERE username='$log_username' LIMIT 1";
$badge_query = mysqli_query($db_conx,$badge_check);

$badgerow = mysqli_fetch_row($badge_query);
$wins =  $badgerow[0];
$entries = $badgerow[1];
$first_place = $badgerow[2];
$second_place = $badgerow[3];
$third_place = $badgerow[4];

$badgemsg = '';
$winsbadge = '';
$entriesbadge = '';
$fpbadge = '<img src="images/badges/1stplace.png">';
$spbadge = '<img src="images/badges/2ndplace.png">';
$tpbadge = '<img src="images/badges/3rdplace.png">';



$badgecount = 0;





if($wins > 0 ){
    $winsbadge = '<img src="images/badges/1contestwin.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 4 ){
    $winsbadge = '<img src="images/badges/5winbadge.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 9){
    $winsbadge = '<img src="images/badges/10winbadge.png" style="width:100px">';
    $badgecount++;
} else if ($wins > 19){
    $winsbadge = '<img src="images/badges/20winbadge.png" style="width:100px">';
    $badgecount++;
}

if($entries > 0 && $entries < 5){
    $entriesbadge = '<img src="images/badges/1stentrybadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 4 && $entries < 10){
    $entriesbadge = '<img src="images/badges/5entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 9 && $entries < 25){
    $entriesbadge = '<img src="images/badges/10entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 24 && $entries < 50){
    $entriesbadge = '<img src="images/badges/25entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 49 && $entries < 100){
    $entriesbadge = '<img src="images/badges/50entriesbadge.png" style="width:100px">';
    $badgecount++;
} else if ($entries > 99 && $entries < 250){
    $entriesbadge = '<img src="images/badges/100entriesbadge.png" style="width:100px">';
    $badgecount++;
}else if ($entries > 249){
    $entriesbadge = '<img src="images/badges/250entriesbadge.png" style="width:100px">';
    $badgecount++;



}

if($badgecount == 1){
    $badgemsg = 'You Have 1 Badge!';
} else {
    $badgemsg = 'You Have '.$badgecount.' Badges!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title><?php echo $u; ?> Portfolio</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="profile.css" rel="stylesheet">
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
        function showGallery(gallery,user){
            _("galleries").style.display = "none";
            _("section_title").innerHTML = user+'&#39;s '+gallery+' Portfolio &nbsp; <button onclick="backToGalleries()" style="color:#222">Go back to all Folders</button>';
            _("photos").style.display = "block";
            _("photos").innerHTML = 'loading photos ...';
            var ajax = ajaxObj("POST", "php_includes/photo_system.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    _("photos").innerHTML = '';
                    var pics = ajax.responseText.split("|||");
                    for (var i = 0; i < pics.length; i++){
                        var pic = pics[i].split("|");
                        _("photos").innerHTML += '<div><img onclick="photoShowcase(\''+pics[i]+'\')" src="user/'+user+'/'+pic[1]+'" alt="pic"><div>';
                    }
                    _("photos").innerHTML += '<p style="clear:left;"></p>';
                }
            }
            ajax.send("show=galpics&gallery="+gallery+"&user="+user);
        }
        function backToGalleries(){
            _("photos").style.display = "none";
            _("section_title").innerHTML = "<?php echo $u; ?>&#39;s Examples";
            _("galleries").style.display = "block";
        }
        function photoShowcase(picdata){
            var data = picdata.split("|");
            _("section_title").style.display = "none";
            _("photos").style.display = "none";
            _("picbox").style.display = "block";
            _("picbox").innerHTML = '<button onclick="closePhoto()">x</button>';
            _("picbox").innerHTML += '<img src="user/<?php echo $u; ?>/'+data[1]+'" alt="photo">';
            if("<?php echo $isOwner ?>" == "yes"){
                _("picbox").innerHTML += '<p id="deletelink"><a href="#" onclick="return false;" onmousedown="deletePhoto(\''+data[0]+'\')">Delete this Photo <?php echo $u; ?></a></p>';
            }
        }
        function closePhoto(){
            _("picbox").innerHTML = '';
            _("picbox").style.display = "none";
            _("photos").style.display = "block";
            _("section_title").style.display = "block";
        }
        function deletePhoto(id){
            var conf = confirm("Press OK to confirm the delete action on this photo.");
            if(conf != true){
                return false;
            }
            _("deletelink").style.visibility = "hidden";
            var ajax = ajaxObj("POST", "php_includes/photo_system.php");
            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == "deleted_ok"){
                        alert("This picture has been deleted successfully. We will now refresh the page for you.");
                        window.location = "portfolio.php?u=<?php echo $u; ?>";
                    }
                }
            }
            ajax.send("delete=photo&id="+id);
        }
    </script>
    <style type="text/css">
        form#photo_form{background:#F3FDD0; border:#AFD80E 1px solid; padding:20px;}
        div#galleries{}
        div#galleries > div{float:left; margin:20px; text-align:center; cursor:pointer;}
        div#galleries > div > div {height:100px; overflow:hidden;}
        div#galleries > div > div > img{width:150px; cursor:pointer;}
        div#photos{display:none; border:#666 1px solid; padding:20px;}
        div#photos > div{float:left; width:125px; height:80px; overflow:hidden; margin:20px;}
        div#photos > div > img{width:125px; cursor:pointer;}
        div#picbox{display:none; padding-top:36px;}
        div#picbox > img{max-width:800px; display:block; margin:0px auto;}
        div#picbox > button{ display:block; float:right; font-size:36px; padding:3px 16px;}
    </style>
</head>
<body style="padding-bottom: 70px; padding-top: 70px">
<?php include_once("php_includes/userPageTop.php"); ?>



    <div id="pageMiddle" style="width:100%; background-color: #7ead21; padding:25px; color:#ffffff">
        <div id="photo_form" style="color:#222;"><?php echo $photo_form; ?></div>
        <h2 id="section_title"><?php echo $u; ?>&#39;s Design Examples</h2>
        <div id="galleries"><?php echo $gallery_list; ?></div>
        <div id="photos"></div>
        <div id="picbox"></div>
        <p style="clear:left;">These photos belong to <a href="user.php?u=<?php echo $u; ?>"><?php echo $u; ?></a></p>
    </div>




<?php include_once("php_includes/pageBottom.php"); ?>
<div class="modal fade" id="badges" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class= "modal-header">
                <h3 style="text-align: center;"><strong><?php echo $badgemsg;?></strong> </h3>

            </div>
            <div class="modal-body" id="badges">

                <?php echo $winsbadge;?>
                <?php echo $entriesbadge;?>


            </div>

        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/forms.js"></script>
</body>
</html>

