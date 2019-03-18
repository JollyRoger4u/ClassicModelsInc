<!DOCTYPE html>
<html>
<head>
<?php

    if(isset($_POST['login'])) {
    // a couple of variable to keep track of if the login attempt failed.

    $err_message = "";

    // get and sanitize input

    $adminID = filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_NUMBER_INT);
    $password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
    
    // connect to database
    $result = check_admin_login($adminID, $password);
    if(gettype($result) == 'string') {
        $err_message = "Log in failed. Check that your ID and password are correct.";
    } else {
        setcookie("administrator", $adminID, time() + (60 * 60 * 12 ), "/");
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=start\'">';
    }

?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>



    <div>
        <form action="admin_login.php" method="post">
            <div>Administrator ID: <input name="adminID" type="text"></div>
            <div>Password:         <input name="password" type="password"></div>
            <input type="submit" value="Logga in" name="login">
        </form>
    </div>
    <div class="errMessage">
        <p><?php

        echo $err_message;

        ?></p>
    </div>

</body>
</html>