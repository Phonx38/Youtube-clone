<?php
require_once("../includes/config.php");

if(isset($_POST['userTo'])&& isset($_POST['userFrom']))
{
    $userto = $_POST['userTo'];
    $userfrom = $_POST['userFrom'];


    $query = $con->prepare("SELECT * FROM followers WHERE userTo =:userTo AND userFrom=:userFrom");
    $query->bindParam(':userTo',$userto);
    $query->bindParam(':userFrom',$userfrom);
    $query->execute();
    
    if($query->rowCount() == 0){
        $query = $con->prepare(" INSERT INTO  followers(userTo,userFrom) VALUES(:userTo,:userFrom)");
        $query->bindParam(':userTo',$userto);
        $query->bindParam(':userFrom',$userfrom);
        $query->execute();
    }else{
        $query = $con->prepare("DELETE FROM followers WHERE userTo =:userTo AND userFrom=:userFrom");
        $query->bindParam(':userTo',$userto);
        $query->bindParam(':userFrom',$userfrom);
        $query->execute();
    }
   $query = $con->prepare("SELECT * FROM followers WHERE userTo =:userTo ");
    $query->bindParam(':userTo',$userto);
    $query->execute();
    echo $query->rowCount();

}else{
    echo "Params not set in Follow.php";
}


?>