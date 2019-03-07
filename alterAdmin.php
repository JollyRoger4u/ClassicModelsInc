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

    $adminObject = new Admin;
    $err_message = "";

    // check if the admin has been saved

    if(isset($_POST['saveAdmin'])){
        $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminLastName = filter_input(INPUT_POST, 'adminLastName', FILTER_SANITIZE_MAGIC_QUOTES);
        $adminFirstName = filter_input(INPUT_POST, 'adminFirstName', FILTER_SANITIZE_MAGIC_QUOTES);

        $adminObject->adminID = $adminID;
        $adminObject->adminLastName = $adminLastName;
        $adminObject->adminFirstName = $adminFirstName;
        $return = $adminObject->update_admin();
        if($return){
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=administrators\'">';
        }
    }

    if(isset($_POST['savePassword'])){
        $adminID = filter_input(INPUT_POST, 'adminID', FILTER_SANITIZE_MAGIC_QUOTES);
        $oldPassword = filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_MAGIC_QUOTES);
        $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_MAGIC_QUOTES);
        $repeatNewPassword = filter_input(INPUT_POST, 'repeatNewPassword', FILTER_SANITIZE_MAGIC_QUOTES);
        
        $adminObject->adminID = $adminID);
        //password checks
        $checkPassword = $adminObject->get_password();

        //check that the new password is the same as the repeated one
        if($newPassword==$repeatNewPassword) {
            $err_message = "New password doesnt match the repeated New Password";

        // check that the new password the same as the old password
        } elseif($newPassword == $checkPassword) {
            $err_message = "Password is already set.";

        //check that it isnt too short
        } elseif (strlen($newPassword)<8){
            $err_message = "Password too short.";

        } else {
            $adminObject->adminPassword = $newPassword;
            $return = $adminObject->change_password();
            if($return) {
            //toggle the overlay
            }
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
    <header>
        <a href="admin.php"><img src="/uploads/productImg/Centennial-Light.jpg"></a>
    </header>
    <nav>
        <ul>
            <li>
                <a href="admin.php?page=orders">Ordrar</a>
            </li>
            <li>
                <a href="admin.php?page=products">Produkter</a>
            </li>
            <li>
                <a href="admin.php?page=productlines">Kategorier</a>
            </li>
            <li>
                <a href="admin.php?page=customers">Kunder</a>
            </li>
            <li>
                <a href="admin.php?page=administrators">Administratörer</a>
            </li>
            <li>
                <a href="admin.php?page=profile">Min Profil</a>
            </li>
        </ul>
    </nav>   
    <main>
        <!-- List the different info -->
        <?php
        //fetch the admin to alter from post

        $adminID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);

        $adminObject->adminID = $adminID;
        $result = $adminObject->get_admin();
        $row = $result->fetch();
        ?>
        <form action="alterAdmin.php" method="post">
            <table>
                <tr>
                    <td>Admin ID
                    </td>
                    <td>
                        <input type="hidden" name="adminID" value="<?php echo $row['adminID']; ?>">
                        <input type="text" value="<?php echo $row['adminID']; ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Efternamn
                    </td>
                    <td><input type="text" name="adminLastName" value="<?php echo $row['adminLastName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Förnamn
                    </td>
                    <td><input type="text" name="adminFirstName" value="<?php echo $row['adminFirstName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Lösenord
                    </td>
                    <td>
                        <?php 
                            $length = strlen($row['password']);
                            for($i=0;$i<$length;$i++)
                                echo "*";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button id="changePasswordButton">Ändra lösenord</button>
                    </td>
                    <td>
                        <input type="submit" name="saveAdmin" value="Spara">
                    </td>
                </tr>
            </table>
        </form>

        <!-- put an overlay here for the password -->
        
        <div class="overlay_center">
            <div class="overlay">
                <form action="alterAdmin.php" method="post">
                    <table>
                        <tr>
                            <td colspan="2">
                                <?php

                                if($err_message = ""){
                                    echo "Ändra lösenord nedan"
                                } else {
                                    echo $err_message;
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
                                <button id="changePasswordButton">Ångra</button>
                            </td>
                            <td>
                                <input type="submit" name="savePassword" value="Spara Lösenord">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>    
        </div>
    </main>
</body>
</html>