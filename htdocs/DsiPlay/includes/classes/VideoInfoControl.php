<?php
include_once('includes/classes/BtnProvider.php');
class VideoInfoControl {


    private $video,$userLoggedInObj;

    public function __construct( $video,$userLoggedInObj)
    {
        $this->video= $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    public function create()
    {

        $likebutton = $this->createLikeButton();
        $dislikebutton = $this->createDislikeButton();

        return "<div class='controls'> 
                    $likebutton
                    $dislikebutton
        
                </div>";
    }

    private function createLikeButton() {

        $text =$this->video->getLikes();
        $videoId =  $this->video->getId();
        $action = "likeVideo(this,$videoId)";
        $class = "likeBtn";

        $imgSrc ="assets/icons/thumbs-up.png";

        if($this->video->wasLikedBy())
        {
            $imgSrc ="assets/icons/thumbs-up-act.png";
        }
        return  BtnProvider::createBtn($text,$imgSrc,$action,$class) ;
    }

    private function createDislikeButton() {

        $text =$this->video->getDislikes();
        $videoId =  $this->video->getId();
        $action = "dislikeVideo(this,$videoId)";
        $class = "dislikeBtn";

        $imgSrc ="assets/icons/thumbs-down.png";

        
        if($this->video->wasDislikedBy())
        {
            $imgSrc ="assets/icons/thumbs-down-act.png";
        }

        return  BtnProvider::createBtn($text,$imgSrc,$action,$class) ;
    }


}   


?>