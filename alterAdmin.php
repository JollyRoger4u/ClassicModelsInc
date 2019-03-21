<?php  $session_test = session_start();
        if(!$session_test) {
            echo "Session har inte startat";
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
        $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminLastName = filter_input(INPUT_POST, 'adminLastName', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminFirstName = filter_input(INPUT_POST, 'adminFirstName', FILTER_SANITIZE_MAGIC_QUOTES);

        $adminObject->ID = $adminID;
        $adminObject->LastName = $adminLastName;
        $adminObject->FirstName = $adminFirstName;
        $return = $adminObject->update_admin();

        if($return){
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=administrators\'">';
        }
    }

    if(isset($_POST['savePassword'])){
        $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_MAGIC_QUOTES);
        $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_MAGIC_QUOTES);

        $adminObject->ID = $adminID;
        //password checks
        $checkPasswordGet = $adminObject->get_admin();
        $checkPassword = $checkPasswordGet->fetch();
        $databasePassword = $checkPassword['password'];

        if(($databasePassword == $newPassword)) {
            $err_message = "Lösenordet är redan satt.";
        } else {
            $passwordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $adminObject->password = $passwordHashed;
            $return = $adminObject->change_password();
            if(!$return) {
                $err_message = "Kunde inte spara lösenordet. Kontakta IT supporten";
            }
        }
    }

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ändra Administratör</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>
<?php include_once 'headnav.php'; ?>
    <main>
        <!-- List the different info -->
        <?php
        //fetch the admin to alter from post
        // check if it is from the list
        if(isset($_POST['number'])) {
            $adminID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);

            $adminObject->ID = $adminID;
            $result = $adminObject->get_admin();
            $row = $result->fetch();
        } if (isset($_POST['adminID'])) { 
            $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_NUMBER_INT);
            $adminObject->ID = $adminID;
            $result = $adminObject->get_admin();
            $row = $result->fetch();
        }

        ?>
            <div><?php echo $err_message; ?></div>
            <table>
        <form action="alterAdmin.php" method="post">
                <tr>
                    <td>Admin ID
                    </td>
                    <td>
                        <input type="hidden" name="adminID" value="<?php echo $row['ID']; ?>">
                        <input type="hidden" name="number" value="<?php echo $row['ID']; ?>">
                        <input type="text" value="<?php echo $row['ID']; ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Efternamn
                    </td>
                    <td><input type="text" name="adminLastName" value="<?php echo $row['LastName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Förnamn
                    </td>
                    <td><input type="text" name="adminFirstName" value="<?php echo $row['FirstName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Lösenord
                    </td>
                    <td>
                        <?php
                            $length = 8;
                            echo  str_repeat("*", $length);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="saveAdmin" value="Spara">
                    </td>
        </form>
                    <td>
                        <button id="changePasswordButton">Ändra lösenord</button>
                    </td>
                </tr>
            </table>

        <!-- put an overlay here for the password -->
        
        <div id="overlay_center">
            <div class="overlay">
                    <table>
                <form action="alterAdmin.php" method="post">
                        <tr>
                            <td colspan="2">
                                <?php

                                if($err_message = ""){
                                    echo "Ändra lösenord nedan";
                                }

                                ?>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>Nuvarande Lösenord
                            </td>
                            <td><input type="text" name="oldpassword">
                            </td>
                        </tr>
                        <tr>
                            <td>Nytt Lösenord
                            </td>
                            <td><input type="text" name="newPassword">
                            </td>
                        </tr>
                        <tr>
                            <td>Repetera det nya lösenordet
                            </td>
                            <td><input type="text" name="repeatNewPassword">
                            </td>
                        </tr>
                        <tr>
                            <td>
                        <input type="hidden" name="adminID" value="<?php echo $row['ID']; ?>">
                        <input type="hidden" name="number" value="<?php echo $row['ID']; ?>">
                                <input type="submit" id="savePasswordButton" name="savePassword" value="Spara Lösenord">
                            </td>
                </form>
                            <td>
                                <button id="cancelPasswordButton">Ångra</button>
                            </td>
                        </tr>
                    </table>
            </div>    
        </div>
    </main>
</body>
</html>