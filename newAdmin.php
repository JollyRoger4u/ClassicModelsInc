<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php\'">';
    }*/ //enable when tables are complete
    
    // create an admin object and an error message variable just in case

    $adminObject = new Administrator;
    $err_message = "";

    // check if the admin has been saved

    if(isset($_POST['saveAdmin'])){
        $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminLastName = filter_input(INPUT_POST, 'adminLastName', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminFirstName = filter_input(INPUT_POST, 'adminFirstName', FILTER_SANITIZE_MAGIC_QUOTES);

        $adminObject->adminID = $adminID;
        $adminObject->adminLastName = $adminLastName;
        $adminObject->adminFirstName = $adminFirstName;
        
        $return = $adminObject->create_admin();
        if($return){
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=administrators\'">';
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
<?php include_once 'headnav.php'; ?>
    <main>
        <!-- List the different info -->
        <form action="newAdmin.php" method="post">
            <table>
                <tr>
                    <td>Efternamn
                    </td>
                    <td><input type="text" name="adminLastName">
                    </td>
                </tr>
                <tr>
                    <td>Förnamn
                    </td>
                    <td><input type="text" name="adminFirstName">
                    </td>
                </tr>
                <tr>
                    <td>Lösenord
                    </td>
                    <td><input type="password" name="password">
                    </td>
                </tr>
                <tr>
                    <td>Repitera Lösenord
                    </td>
                    <td><input type="password" name="repPassword">
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" name="saveAdmin" value="Spara">
                    </td>
                </tr>
            </table>
        </form>

    </main>
</body>
</html>