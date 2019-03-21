<?php  
$test = session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php

    require_once "classes.php";
    // a couple of variable to keep track of if the login attempt failed.

    $err_message = "";
    $adminObject = new Administrator;

    if(isset($_POST['login'])) {

    // get and sanitize input

    $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
    $adminObject->ID = $adminID;
    $adminObject->password = $password;

    // connect to database
    $result = $adminObject->check_admin_login();
        if($result == TRUE) {
            $_SESSION['administrator'] = $adminID;
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin.php?page=start\'">';
        } else {
            $err_message = "Log in failed. Check that your ID and password are correct."; 
        }
    }
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
</head>
<body>
    <div class="loginForm">
        <form action="admin_login.php" method="post">
            <div>Administrator ID: <input name="adminID" type="text"></div>
            <div>Password:         <input name="password" type="password"></div>
            <input type="submit" value="Logga in" name="login">
        </form>
    </div>
    <div class="errMessage">
        <p><?php echo $err_message; ?></p>
    </div>
</body>
</html>