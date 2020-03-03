<?php 
include_once('includes/header.php');
include_once('includes/classes/VideoInfoSec.php');
include_once('includes/classes/VideoPlayer.php');
include_once('includes/classes/commentSec.php');

if(!isset($_GET["id"]))
{
 echo "Page Not Found"; 
exit();
}

$video = new Video($con,$_GET["id"],$userLoggedInObj);

echo $video->incrementViews();

?>

<script src="assets/js/VideoPlayActions.js"></script>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);

    $videoPlayer = new VideoInfoSec($con,$video,$userLoggedInObj);
    echo $videoPlayer->create();

    $commentSection = new commentSec($con,$video,$userLoggedInObj);
    echo $commentSection->create();

?>

</div>

<div class="suggestions">
    <?php   
     
     $videoGrid = new videoGrid($con,$userLoggedInObj);
     echo $videoGrid->create(null,null,false);
    
    
    ?>
</div>




<?php include_once('includes/footer.php');?>