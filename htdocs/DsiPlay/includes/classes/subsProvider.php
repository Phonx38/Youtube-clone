<?php

class SubProvider {

    private $con,$userLoggedInObj;
    
    public function __construct($con ,$userLoggedInObj){
        $this->con =$con;
        $this->userLoggedInObj = $userLoggedInObj;
    }



    public function getVideos() {
        $videos =array();
        $followers = $this->userLoggedInObj->getFollowers();


        if (sizeof($followers) > 0) {




            $condition = "";
            $i=0;

            while($i < sizeof($followers)) {
                if($i==0){
                    $condition .=   "WHERE uploadedBy=?";
                }
                else{
                    $condition .=   " OR uploadedBy=?";
                }
                $i++;
            }
            $videoSql = "SELECT * FROM video $condition ORDER BY uploadDate DESC";
            $videoQuery = $this->con->prepare($videoSql);
            $i= 1;

            foreach($followers as $fol){
                $folUsername = $fol->getUn();
                $videoQuery->bindValue($i,$folUsername);
                
                $i++;
            }
            $videoQuery->execute();
            while($row = $videoQuery->fetch(PDO::FETCH_ASSOC)) {
                $video = new Video($this->con,$row,$this->userLoggedInObj);
                array_push($videos,$video);
            }
        }
        return $videos;
    }
}   

?>