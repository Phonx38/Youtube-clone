<?php

class User {

    private $con,$sqlData;

    public function __construct($con,$username)
    {
        $this->con=$con;

        $query= $this->con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindParam(":un",$username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUn() {
        return $this->sqlData["username"];
    }

    public function getName() {
        return $this->sqlData["firstname"] ."  ".$this->sqlData["lastname"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profilePic"];
    }

    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }

    public  function isFollowed($userTo) 
    {
        $query=$this->con->prepare("SELECT * FROM followers WHERE userTo=:userTo AND  userFrom=:userFrom");
        $query->bindParam(":userTo",$userTo);
        $query->bindParam(":userFrom",$username);
        $username = $this->getUn();
        $query->execute();

        return $query->rowCount() > 0;

    }

    public function getFollowerCount() 
    {
        $query=$this->con->prepare("SELECT * FROM followers WHERE userTo=:userTo ");
        $query->bindParam(":userTo",$username);
        
        $username = $this->getUn();
        $query->execute();

        return $query->rowCount();

    }


    public function getFollowers() {
            $query = $this->con->prepare("SELECT userTo FROM followers WHERE userFrom=:userFrom");
            $username = $this->getUn();
            $query->bindParam(":userFrom",$username);

            $query->execute();

            $subs = array();

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($this->con, $row["userTo"]);
                array_push($subs,$user);
            }
            return $subs;
    }
}




?>