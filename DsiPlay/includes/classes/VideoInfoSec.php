<?php
include_once('includes/classes/VideoInfoControl.php');
class VideoInfoSec {


    private $con,$video,$userLoggedInObj;

    public function __construct( $con,$video,$userLoggedInObj)
    {
        $this->video= $video;
        $this->con=$con;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    public function create()
    {
        return $this->createPrimaryInfo() .$this->createSecInfo();
    }

    private function createPrimaryInfo()
    {
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $videoInfoControl = new VideoInfoControl($this->video,$this->userLoggedInObj);
        $controls =  $videoInfoControl->create();


        return "<div class= 'videoInfo' >
                    <h1>$title</h1>

                    <div class= 'bottomSection'>
                        <span class='viewCount'>$views views </span> 
                        $controls
                    </div>
                </div>";
    }
    private function createSecInfo()
    {
        $description = $this->video->getDescription();
        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileBtn = BtnProvider::createUserProfileBtn($this->con,$uploadedBy);


        if($uploadedBy == $this->userLoggedInObj->getUn())
        {
            $actionBtn =BtnProvider::createEditBtn($this->video->getId());
        }
        else{
            $userToObject = new User($this->con,$uploadedBy);
            
            $actionBtn= BtnProvider::createFollowBtn($this->con,$userToObject,$this->userLoggedInObj);
        }
        return "<div class ='secInfo'>
                    <div class='topRow'>
                        $profileBtn

                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href= 'profile.php?username=$uploadedBy'>
                                    $uploadedBy
                                </a>
                            </span>

                            <span class='date'>
                            
                                Published on $uploadDate
                            </span>
                        </div>
                        $actionBtn  
                    </div>
                    <div class='descriptionContainer'>
                        $description
                    </div>    
                </div>";
    }
}


?>