<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php\'">';
    }*/ //enable when tables are complete
    // create a customer object and an error message variable just in case

    $customerObject = new Customer;
    $err_message = "";

    // check if the customer has been saved

    if(isset($_POST['saveCustomer'])){
        $customerNumber = filter_input(INPUT_POST, 'customerNumber', FILTER_SANITIZE_MAGIC_QUOTES);
        
        $customerObject->customerNumber = $customerNumber;
        $customerObject->delete_customer();
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=customers\'">';
    }

    if(isset($_POST['changePassword'])) {
        $customerNumber = filter_input(INPUT_POST, 'customerNumber', FILTER_SANITIZE_MAGIC_QUOTES);
        $oldPassword = filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_MAGIC_QUOTES);
        $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_MAGIC_QUOTES);
        $repeatNewPassword = filter_input(INPUT_POST, 'repeatNewPassword', FILTER_SANITIZE_MAGIC_QUOTES);

        $customerObject->customerNumber = $customerNumber;

        //password checks
        $checkPassword = $customerObject->get_password();

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
            $customerObject->password = $newPassword;
            $customerObject->change_password();
            //toggle the overlay
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

        $customerID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);

        $customerObject->customerNumber=$customerID;
        $result = $customerObject->get_customer();
        $row = $result->fetch();
        ?>
            
            <table>
                <tr>
                    <td>Kundnummer
                    </td>
                    <td>
                        <?php echo $row['customerNumber']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Företagsnamn
                    </td>
                    <td><?php echo $row['customerName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Efternamn på företagskontakt
                    </td>
                    <td><?php echo $row['contactLastName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Förnamn på företagskontakt
                    </td>
                    <td><?php echo $row['contactFirstName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Telefonnummer
                    </td>
                    <td><?php echo $row['phone']; ?>
                    </td>
                </tr>
                <tr>
                    <td>addressrad 1
                    </td>
                    <td><?php echo $row['addressLine1']; ?>
                    </td>
                </tr>
                <tr>
                    <td>addressrad 2
                    </td>
                    <td><?php echo $row['addressLine2']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Postort
                    </td>
                    <td><?php echo $row['city']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Stat
                    </td>
                    <td><?php echo $row['state']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Postnummer
                    </td>
                    <td><?php echo $row['postalCode']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Land
                    </td>
                    <td><?php echo $row['country']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Försäljarensanställningsnummer
                    </td>
                    <td><?php echo $row['salesRepEmployeeNumber']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Max kredit
                    </td>
                    <td><?php echo $row['creditLimit']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <button id="deleteButton">Ta bort Kund</button>
                    </td>
                </tr>
            </table>

        <!-- put an overlay here to make sure that the customer is supposed to be deleted -->

        <div class="overlay_center">
            <div class="overlay">
                <form action="deleteCustomer.php" method="post">
                    <h1>Bort tagning av kund
                    </h1>
                    <p>Denna åtgärd kan inte ångras. Är du säke rpå att du vill fotsätta?
                    </p>
                    <table>
                            <td>
                                <input type="submit" name="cancel" value="Ångra">
                            </td>
                            <td>
                                <input type="submit" name="deleteCustomer" value="Ta bort">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>    
        </div>
    </main>
</body>
</html>