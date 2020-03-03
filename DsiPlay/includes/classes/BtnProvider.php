<?php

class BtnProvider {

    public static $signInFunc = "notSignedIn()";

    public static function  createLink($link){
        return User::isLoggedIn() ? $link : BtnProvider::$signInFunc;
    }    

    public static function createBtn($text,$imgSrc,$action,$class)
    {
        $image = ($imgSrc == null)? "" : "<img src='$imgSrc'>";

        $action = BtnProvider::createLink($action);

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class ='text'>$text</span>
                </button>";
    }

    public static function createUserProfileBtn($con,$username) {
        $userObj = new User($con,$username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link'>
                    <img src='$profilePic' class='proPic'>
                </a>";    
    }

    public static function createHyperlinkBtn($text,$imgSrc,$href,$class)
    {
        $image = ($imgSrc == null)? "" : "<img src='$imgSrc'>";

        

        return "<a href='$href'>
                    <button class='$class' >
                        $image
                        <span class ='text'>$text</span>
                    </button>
                </a>";
    }

    public static function createEditBtn($videoId)
    {
        $href ="editVideo.php?videoId=$videoId";

        $button= BtnProvider::createHyperlinkBtn("EDIT VIDEO",null,$href,"edit button");

        return "<div class='editVideoBtnContainer'>
                    $button
                </div>";
    }

    public static function createFollowBtn($con,$userToObj,$userLoggedInObj)
    {
        $userTo = $userToObj->getUn();
        $userLoggedIn = $userLoggedInObj->getUn();


        $isFollowed = $userLoggedInObj->isFollowed($userToObj->getUn());
        $BtnText= $isFollowed ? "FOLLOWING" : "FOLLOW";
        $BtnText .= " ".$userToObj->getFollowerCount();

        $btnclass= $isFollowed ? "unfollow button" : "follow button";
        $action = "follow(\"$userTo\", \"$userLoggedIn\",this)";

        $button = BtnProvider::createBtn($BtnText,null,$action,$btnclass);

        return "<div class='followBtnContainer'>
                    $button
                </div>";
    }
    public static  function createUserProfileNavBtn($con,$username)
    {
        if(User::isLoggedIn()) {
            return BtnProvider::createUserProfileNavBtn($con,$username);
        }
        else{
            return "<a href='signIn.php'>
                        <span class= 'signInLink'>Sign In</span>
                    </a>";
        }
    }
}

?>