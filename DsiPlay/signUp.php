<?php 


require_once("includes/config.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/account.php");

$account = new Account($con);

if(isset($_POST['submitBtn']))
{
    $fn = formSanitizer::sanitizeString($_POST['firstName']);
    $ln = formSanitizer::sanitizeString($_POST['lastName']);
    $un = formSanitizer::sanitizeUsername($_POST['userName']);
    $em = formSanitizer::sanitizeEmail($_POST['email']);
    $psw =formSanitizer::sanitizePassword($_POST['password']);
    $psw2 =formSanitizer::sanitizePassword($_POST['password2']);

    

    $wasSuccessful=$account->register($fn,$ln,$un,$em,$psw,$psw2);
    
    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $un;
        header("Location: signin.php");
    }
}


function getUserdata($name)
{
    if(isset($_POST[$name]))
    {
        echo $_POST[$name];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel='stylesheet' href='assets/css/style.css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,800" rel="stylesheet">
    

    <title>Dsiplay</title>
</head>
<body>

    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <div class="logo" style="color:grey;"><h1 ><span style="color:black;">Dsi</span>Play</h1></div>
                <h3>Sign Up </h3>
            </div>

            <div class="loginForm">

                <form  action="signUp.php" method="POST">

                    <?php  echo  $account->getError(Constants::$firstnameMinChar);?>
                    <input type="text" name="firstName" value= "<?php getUserdata('firstName');?>" autocomplete="off" placeholder="First Name" required>
                    
                    <?php echo  $account->getError(Constants::$lastnameMinChar);?>
                    <input type="text" name="lastName"  value= "<?php getUserdata('lastName');?>"
                    autocomplete="off" placeholder="Last Name" required>

                    <?php echo  $account->getError(Constants::$usernameMinChar);?>
                    <?php echo  $account->getError(Constants::$userExists);?>
                    <input type="text" name="userName" value= "<?php getUserdata('userName');?>"
                    autocomplete="off" placeholder="Username" required>

                    <?php echo  $account->getError(Constants::$invalidEmail);?>
                    <?php echo  $account->getError(Constants::$emailExists);?>
                    <input type="email" name="email" value= "<?php getUserdata('email');?>"
                    autocomplete="off" placeholder="email" required>

                    <?php echo  $account->getError(Constants::$passMatch);?>
                    <?php echo  $account->getError(Constants::$invalidPass);?>
                    <?php echo  $account->getError(Constants::$passMin);?>
                    <input type="password" name="password" autocomplete="off" placeholder="Password" required>

                    <input type="password" name="password2" autocomplete="off" placeholder="Confirm Password" required>

                    <input type="submit" name="submitBtn"  value="Submit" required>
                </form>

            </div>
            
            <a href="signin.php" class="signInMessage">
                Already Have an account? Sign In
            </a>
        </div>
    </div>

</body>
</html>