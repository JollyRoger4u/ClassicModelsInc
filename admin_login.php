<!DOCTYPE html>
<html>
<head>
<?php

    if(isset($_POST['login'])) {
    // a couple of variable to keep track of if the login attempt failed.

    $wrongpassword = 0;
    $wrongID = 0;

    // get and sanitize input

    $adminID = filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
    
    // connect to database

    $pdo = connect_login();

    // select the admin with that id

    $sql = "SELECT * FROM admins WHERE adminID = $adminID";

    $toDisplay = $pdo->prepare($sql); // prepared statement
    $toDisplay->execute(); // execute sql statment
    $result = $toDisplay->fetch();
    if($result != NULL){
        if($result['password'] == $password){
            //set cookie and redirect
            setcookie("administrator", $adminID]);
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=start\'">';
        } else {
            $wrongpassword = 1;
        }
    } else {
        $wrongID = 1;
    }

    }
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>



    <div>
        <form action="admin_login.php" method="post">
            <div>Administrator ID: <input name="adminID" type="text"></div>
            <div>Password:         <input name="password" type="text"></div>
            <input type="submit" value="Logga in" name="login">
        </form>
    </div>

    <?php

    if($wrongID == 1 || $wrongpassword == 1) {
        Log in failed. Check that your ID and password are correct.
    }

    ?>


</body>
</html>