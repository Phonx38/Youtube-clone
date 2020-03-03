<?php 
require_once("includes/config.php");
require_once("includes/classes/User.php");
include_once('includes/classes/videoGrid.php');
include_once('includes/classes/videoGridItem.php');
include_once('includes/classes/Video.php');
include_once('includes/classes/BtnProvider.php');
include_once('includes/classes/subsProvider.php');

$usernameLoggedIn = User::isLoggedIn() ?  $_SESSION["userLoggedIn"] : "";
$userLoggedInObj = new User($con,$usernameLoggedIn); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel='stylesheet' href='assets/css/style.css' charset=  "UTF-8";>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,800" rel="stylesheet" >
    
    <!-- javascript folder "SHOULD REMAIN AT THE END " -->
    <script src="assets/js/commonAction.js"></script>
    <script src="assets/js/userActions.js"></script>




    <title>Dsiplay</title>
</head>
<body>
    <div id="pageContainer">
        <div id="mastHeadContainer">
            <button class="navShowHide">
                <i class="fa fa-bars"  style="color: grey; width:30px; font-size:20px;"></i>
            </button>

            <div class="logo">
                <a href="index.php"><h2><span style="color: #fff;">Dsi</span><span style="color: rgb(254,153,0);">Play</span></h2></a>
            </div>


            <div class="searchBarContainer">
                <form action="search.php" method="GET">
    
                    <input type='text'  name='term' class=' searchBar' placeholder="Search">
                    <button class="searchButton" >
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <div class="rightIcons">
                <a href="upload.php">  
                    <i class="fa fa-upload" aria-hidden="true"  style="color: grey; width:30px; font-size:30px;" ></i>
                </a>

                <?php echo BtnProvider::createUserProfileNavBtn($con,$userLoggedInObj->getUn()); ?>


            </div>

        
        </div>
        

        <div id="sideNavbar" style="display: none;"></div>
        <div id="mainSectionContainer">

            <div id="mainContentContainer">