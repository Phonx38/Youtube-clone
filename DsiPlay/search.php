<?php
require_once("includes/header.php");
require_once("includes/classes/searchProvider.php");

if(!isset($_GET["term"] )|| $_GET["term"] == "") {
    echo " enter search a Term......"; 
    exit();
}

$term = $_GET["term"];


if(!isset($_GET["orderBy"] )|| $_GET["orderBy"] =="views") {
    $orderBy= "views";

}else{
    $orderBy= "uploadDate";
}

$searchProvider = new SearchProvider($con,$userLoggedInObj);
$videos = $searchProvider->getVideos($term,$orderBy);

$videoGrid = new VideoGrid($con,$userLoggedInObj);




?>


<div class="largeVideoContainer">

    <?php
    if(sizeof($videos)>0){
        echo $videoGrid->createLarge($videos,sizeof($videos). "videos found",true);
    }else {
        echo "No Results Found";
    }

    ?>

</div>