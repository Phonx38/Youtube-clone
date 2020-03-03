<?php
include_once('includes/header.php');
include_once('includes/classes/VideoInfoControl.php');
class commentSec {


    private $con,$video,$userLoggedInObj;

    public function __construct( $con,$video,$userLoggedInObj)
    {
        $this->video= $video;
        $this->con=$con;
        $this->userLoggedInObj = $userLoggedInObj;
    }
    public function create()
    {
       return $this->createCommentSec();
    }
    private function createCommentSec() {
        $numComment = $this->video->getNoOfComment();
        $postedBy = $this->userLoggedInObj->getUn();
        $videoId = $this->video->getId();
        $profileBtn = BtnProvider::createUserProfileBtn($this->con,$postedBy);
        $commentAction =  "postComment(this,\"$postedBy\",$videoId,null,\"comments\")";
        $commentBtn = BtnProvider::createBtn("COMMENT",null,$commentAction,"postComment");


        return "<div class='commentSec'>
        
                    <div class='header'>
                        <span class='count'>$numComment Comments </span>
                    
                    </div>

                    <div class= 'commentForm'>
                        $profileBtn
                        <textarea class='commentBody' placeholder='Add a comment'></textarea>
                        $commentBtn
                        
                    </div>
        
                    <div class='comments'></div>
                </div>";
    }
    
}


?>