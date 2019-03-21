<?php  $session_test = session_start();
        if(!$session_test) {
            echo "Session har inte startat.";
        }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    if(!(isset($_SESSION['administrator']))) {
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin_login.php\'">';
    }
    
    // create an admin object and an error message variable just in case

    $adminObject = new Administrator;
    $err_message = "";

    // check if the admin has been saved

    if(isset($_POST['saveAdmin'])){
        $pdo = connect_admin();
        $get = max_admin_id($pdo);
        $result = $get->fetch();
        if(!$result) {
            $err_message = "Finns inga admins.";
        } else {
        $adminID = ((int) $result['max(ID)']) + 1; 

        $adminLastName = filter_input(INPUT_POST, 'adminLastName', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminFirstName = filter_input(INPUT_POST, 'adminFirstName', FILTER_SANITIZE_MAGIC_QUOTES);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $adminObject->ID = $adminID;
        $adminObject->LastName = $adminLastName;
        $adminObject->FirstName = $adminFirstName;
        $adminObject->password = $passwordHashed;
        
        $return = $adminObject->create_admin();
        
        if($return){
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=administrators\'">';
        } else {
            $err_message = "Något har gått fel i sparfunktionen. Kontakta IT supporten.";
        }
    }
    }
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Skapa ny administratör</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
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