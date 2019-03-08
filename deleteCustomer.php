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
<?php include_once 'headnav.php'; ?>   
    
    <main class="customer">
        <!-- List the different info -->
        <?php
        //fetch the admin to alter from post

        //check if it is from customers list
        if(isset($_POST['number'])) {
        $customerID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);

        $customerObject->customerNumber=$customerID;
        $result = $customerObject->get_customer();
        $row = $result->fetch();
        } else {
            $row = array("customerNumber" => $_POST['customerNumber'],
                    "customerName" => $_POST['customerName'],
                    "contactLastName" => $_POST['contactLastName'],
                    "contactFirstName" => $_POST['contactFirstName'],
                    "phone" => $_POST['phone'],
                    "addressLine1" => $_POST['addressLine1'],
                    "addressLine2" => $_POST['addressLine2'],
                    "city" => $_POST['city'],
                    "state" => $_POST['state'],
                    "postalCode" => $_POST['postalCode'],
                    "country" => $_POST['country'],
                    "salesRepEmployeeNumber" => $_POST['salesRepEmployeeNumber'],
                    "creditLimit" => $_POST['creditLimit']
            );
        }
        ?>
            <table>
            <form method="post" action="deleteCustomer.php">
                <tr>
                    <td>Kundnummer
                    </td>
                    <td>
                        <input type="hidden" name="customerNumber" value="<?php echo $row['customerNumber']; ?>">
                        <?php echo $row['customerNumber']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Företagsnamn
                    </td>
                    <td>
                        <input type="hidden" name="customerName" value="<?php echo $row['customerName']; ?>">
                        <?php echo $row['customerName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Efternamn på företagskontakt
                    </td>
                    <td>
                        <input type="hidden" name="contactLastName" value="<?php echo $row['contactLastName']; ?>">
                        <?php echo $row['contactLastName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Förnamn på företagskontakt
                    </td>
                    <td>
                        <input type="hidden" name="contactFirstName" value="<?php echo $row['contactFirstName']; ?>">
                        <?php echo $row['contactFirstName']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Telefonnummer
                    </td>
                    <td>
                        <input type="hidden" name="phone" value="<?php echo $row['phone']; ?>">
                        <?php echo $row['phone']; ?>
                    </td>
                </tr>
                <tr>
                    <td>addressrad 1
                    </td>
                    <td>
                        <input type="hidden" name="addressLine1" value="<?php echo $row['addressLine1']; ?>">
                        <?php echo $row['addressLine1']; ?>
                    </td>
                </tr>
                <tr>
                    <td>addressrad 2
                    </td>
                    <td>
                        <input type="hidden" name="addressLine2" value="<?php echo $row['addressLine2']; ?>">
                        <?php echo $row['addressLine2']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Postort
                    </td>
                    <td>
                        <input type="hidden" name="city" value="<?php echo $row['city']; ?>">
                        <?php echo $row['city']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Stat
                    </td>
                    <td>
                        <input type="hidden" name="state" value="<?php echo $row['state']; ?>">
                        <?php echo $row['state']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Postnummer
                    </td>
                    <td>
                        <input type="hidden" name="postalCode" value="<?php echo $row['postalCode']; ?>">
                        <?php echo $row['postalCode']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Land
                    </td>
                    <td>
                        <input type="hidden" name="country" value="<?php echo $row['country']; ?>">
                        <?php echo $row['country']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Försäljarensanställningsnummer
                    </td>
                    <td>
                        <input type="hidden" name="salesRepEmployeeNumber" value="<?php echo $row['salesRepEmployeeNumber']; ?>">
                        <?php echo $row['salesRepEmployeeNumber']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Max kredit
                    </td>
                    <td>
                        <input type="hidden" name="creditLimit" value="<?php echo $row['creditLimit']; ?>">
                        <?php echo $row['creditLimit']; ?>
                    </td>
                </tr>
                
            </form>
                <tr>
                    <td>
                    </td>
                    <td>
                        <button id="changePasswordButton" onclick="false">Ta bort Kund</button>
                    </td>
                </tr>
            </table>
        <!-- put an overlay here to make sure that the customer is supposed to be deleted -->

        <div id="overlay_center">
            <div class="overlay">
                    <h1>Bort tagning av kund
                    </h1>
                    <p>Denna åtgärd kan inte ångras. Är du säker på att du vill fortsätta?
                    </p>
                    <table>
                            <td>
                                <button id="cancelPasswordButton" onclick="false">Ångra</button>
                            </td>
                            <form action="deleteCustomer.php" method="post">
                                <td>
                                    <input type="submit" id="savePasswordButton" name="deleteCustomer" value="Ta bort">
                                </td>
                            </form>
                        </tr>
                    </table>
            </div>    
        </div>
    </main>
</body>
</html>