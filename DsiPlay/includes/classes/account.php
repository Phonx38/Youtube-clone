<?php

class Account{

    private $con;
    private $errorArray = array();

    public function  __construct($con)
    {
        $this->con  = $con;
    }

    public function login($username,$password)
    {
        $password = hash("sha512",$password);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username AND  password=:psw");

        $query->bindParam(":username",$username);
        $query->bindParam(":psw",$password);
        $query->execute();

        if($query->rowCount() == 1){
            return true;
        }
        else{
            array_push($this->errorArray,Constants::$invalidLogin);
            return false;
        }
    }

    public function register($fn,$ln,$un,$em,$psw,$psw2)
    {
        $this->validateFirstname($fn);
        $this->validateLastname($ln);
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePasswords($psw,$psw2);

        if(empty($this->errorArray))
        {
            return $this->insertUserData($fn,$ln,$un,$em,$psw,$psw);
        }
        else{
            return false;
        }
    }

    
    private function insertUserData($fn,$ln,$un,$em,$psw)
    {
        $psw=hash("sha512",$psw);
        $profilePic= "assets/images/profilePictures/defFemale.jpg";

        $query = $this->con->prepare("INSERT INTO users(firstname,lastname,username,email,password,profilePic)
                                    VALUES(:fn,:ln,:un,:em,:psw,:pic)");

        $query->bindParam(":fn",$fn);
        $query->bindParam(":ln",$ln);
        $query->bindParam(":un",$un);
        $query->bindParam(":em",$em);
        $query->bindParam(":psw",$psw);
        $query->bindParam(":pic",$profilePic);

        return $query->execute();
    }



    private function validateFirstName($fn)
    {
        if((strlen($fn) >25)||(strlen($fn) <2))
        {
            array_push($this->errorArray,Constants::$firstnameMinChar);
            return;
        } 
    }

    private function validateLastName($ln)
    {
        if((strlen($ln) >25)||(strlen($ln) <2))
        {
            array_push($this->errorArray,Constants::$lastnameMinChar);
            return;
        } 
    }
    private function validateUserName($un)
    {
        if((strlen($un) >25)||(strlen($un) <5))
        {
            array_push($this->errorArray,Constants::$usernameMinChar);
            return;
        } 

        $query=$this->con->prepare("SELECT username FROM users WHERE username=:un");

        $query->bindParam(":un",$un);

        $query->execute();

        if($query->rowCount() != 0)
        {
            array_push($this->errorArray,Constants::$userExists);
            return;
        }
    }

    private function validateEmail($em)
    {
        if(!filter_var($em,FILTER_VALIDATE_EMAIL))
        {
            array_push($this->errorArray,Constants::$invalidEmail);
            return;
        }

        $query=$this->con->prepare("SELECT email FROM users WHERE email=:em");

        $query->bindParam(":em",$em);

        $query->execute();

        if($query->rowCount() != 0)
        {
            array_push($this->errorArray,Constants::$emailExists);
            return;
        }
    }

    


    private function validatePasswords($psw,$psw2)
    {

        if($psw != $psw2)
        {
            array_push($this->errorArray,Constants::$passMatch);
            return;
        }



        if(preg_match("/[^A-Za-z0-9]/",$psw)){
            array_push($this->errorArray,Constants::$invalidPass);
            return;
        }

        

        if((strlen($psw) >25)||(strlen($psw) <5))
        {
            array_push($this->errorArray,Constants::$passMin);
            return;
        } 
    }

    public function getError($error)
    {
        if(in_array($error,$this->errorArray))
        {
            return "<span class= 'errorMessage'>$error</span>";
        }
    }
}



?>