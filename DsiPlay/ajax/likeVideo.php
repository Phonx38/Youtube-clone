<?php
require_once("../includes/config.php");
require_once("../includes/classes/Video.php");
require_once("../includes/classes/User.php");

$username = $_SESSION["userLoggedIn"];
$videoId= $_POST["videoId"];
 

$userloggedInObj = new User($con,$username);
$video = new Video($con,$videoId,$userloggedInObj);
    
echo $video->like();


?>