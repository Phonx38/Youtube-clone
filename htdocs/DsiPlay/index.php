<?php include_once('includes/header.php');?>



<div class="videoSection">

    <?php


    $subsProvider = new SubProvider($con,$userLoggedInObj);
    $subVideos = $subsProvider->getVideos();

    $videoGrid = new VideoGrid($con,$userLoggedInObj->getUn());

    if(User::isLoggedIn() && sizeof($subVideos) >0){
        echo $videoGrid->create($subVideos,"FOLLOWING",false);
    }

    echo $videoGrid->create(null,"RECOMMENDED",false);
    ?>


</div>




<?php include_once('includes/footer.php');?>