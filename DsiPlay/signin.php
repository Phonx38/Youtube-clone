<?php require_once("includes/config.php");

require_once("includes/classes/Constants.php");
require_once("includes/classes/formSanitizer.php");
require_once("includes/classes/account.php");

$account = new Account($con);

if(isset($_POST['submitBtn']))
{
    
    $username = formSanitizer::sanitizeUsername($_POST['userName']);
    
    $password =formSanitizer::sanitizePassword($_POST['password']);
    

    

    $wasSuccessful=$account->login($username,$password);
    
    if($wasSuccessful){
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
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
                <h3>Sign In </h3>
            </div>

            <div class="loginForm">
                <form action="signIn.php" method="POST">

                    <?php  echo  $account->getError(Constants::$invalidLogin);?>
                    <input type="text" name="userName"value= "<?php getUserdata('userName');?>" autocomplete="off" placeholder="Username" required>
                    <input type="password" name="password" autocomplete="off" placeholder="Password" required>
                    <input type="submit" name="submitBtn"  value="Submit" required>
                </form> 
            </div>
            
            <a href="signUp.php" class="signInMessage">
                Dont Have an Account? Sign Up !
            </a>
        </div>
    </div>

</body>
</html>