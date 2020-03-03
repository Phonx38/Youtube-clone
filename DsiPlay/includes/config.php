<?php

ob_start();

session_start();

date_default_timezone_set("Asia/Calcutta");


try{
    $con= new PDO("mysql:dbname=dsiplay;host=localhost","root","");

    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    echo"Connection Failed: " . $e->getMessage();

}

?>