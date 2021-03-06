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
    } else {
        // create a customer object and an error message variable just in case

        $customerObject = new Customer;
        $err_message = "";

        // check if the customer has been saved

        if(isset($_POST['saveCustomer'])){
            $customerNumber = filter_input(INPUT_POST, 'customerNumber', FILTER_SANITIZE_MAGIC_QUOTES);
            $customerName = filter_input(INPUT_POST, 'customerName', FILTER_SANITIZE_MAGIC_QUOTES);
            $contactLastName = filter_input(INPUT_POST, 'contactLastName', FILTER_SANITIZE_MAGIC_QUOTES);
            $contactFirstName = filter_input(INPUT_POST, 'contactFirstName', FILTER_SANITIZE_MAGIC_QUOTES);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_MAGIC_QUOTES);
            $addressLine1 = filter_input(INPUT_POST, 'addressLine1', FILTER_SANITIZE_MAGIC_QUOTES);
            $addressLine2 = filter_input(INPUT_POST, 'addressLine2', FILTER_SANITIZE_MAGIC_QUOTES);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_MAGIC_QUOTES);
            $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_MAGIC_QUOTES);
            $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_MAGIC_QUOTES);
            $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_MAGIC_QUOTES);
            $salesRepEmployeeNumber = filter_input(INPUT_POST, 'salesRepEmployeeNumber', FILTER_SANITIZE_MAGIC_QUOTES);
            $creditLimit = filter_input(INPUT_POST, 'creditLimit', FILTER_SANITIZE_MAGIC_QUOTES);
            
            $customerObject->customerNumber = $customerNumber;
            $customerObject->customerName = $customerName;
            $customerObject->contactLastName = $contactLastName;
            $customerObject->contactFirstName = $contactFirstName;
            $customerObject->phone = $phone;
            $customerObject->addressLine1 = $addressLine1;
            $customerObject->addressLine2 = $addressLine2;
            $customerObject->city = $city;
            $customerObject->state = $state;
            $customerObject->postalCode = $postalCode;
            $customerObject->country = $country;
            $customerObject->salesRepEmployeeNumber = $salesRepEmployeeNumber;
            $customerObject->creditLimit = $creditLimit;
            $test = $customerObject->update_customer();
            if($test) {
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin.php?page=customers\'">';
            }
        }

        if(isset($_POST['savePassword'])) {
            $customerNumber = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_MAGIC_QUOTES);
            $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_MAGIC_QUOTES);

            $customerObject->customerNumber = $customerNumber;

            //password checks
            $databasePasswordGet = $customerObject->get_password();
            $databasePassword = $databasePasswordGet->fetch();
            $checkPassword = $databasePassword['password'];

            // check that the new password the same as the old password
            if($newPassword == $checkPassword) {
                $err_message = "Lösenordet är redan satt.";

            //check that it isnt too short
            } elseif (strlen($newPassword)<8){
                $err_message = "Lösenordet är för kort. Det behöver vara minst 8 tecken.";

            } else {
                $passwordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $customerObject->password = $passwordHashed;
                $test = $customerObject->change_password();
                if($test) {
                    echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin.php?page=customers\'">';
                    $err_message = "Kund sparad.";
                } else {
                    $err_message = "Kunde inte spara kontakta IT supporten.";
                }
            }
        }
    }
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ändra Kund</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>
<?php include_once 'headnav.php'; ?>
    
    <main class="customer">
        <!-- List the different info --><?php
        //fetch the admin to alter from post
        
        $customerID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
        
        $customerObject->customerNumber=$customerID;
        $result = $customerObject->get_customer();
        $row = $result->fetch();
        ?>
            <div><?php echo $err_message; ?></div>
            
            <table>
        <form action="alterCustomer.php" method="post">
                <tr>
                    <td>Kundnummer
                    </td>
                    <td>
                        <input type="hidden" name="number" value="<?php echo $row['customerNumber']; ?>">
                        <input type="hidden" name="productID" value="<?php echo $row['customerNumber']; ?>">
                        <input type="text" value="<?php echo $row['customerNumber']; ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td>Företagsnamn
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['customerName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Efternamn på företagskontakt
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['contactLastName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Förnamn på företagskontakt
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['contactFirstName']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Telefonnummer
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['phone']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>addressrad 1
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['addressLine1']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>addressrad 2
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['addressLine2']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Postort
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['city']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Stat
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['state']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Postnummer
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['postalCode']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Land
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['country']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Försäljarensanställningsnummer
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['salesRepEmployeeNumber']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Max kredit
                    </td>
                    <td><input type="text" name="orderDate" value="<?php echo $row['creditLimit']; ?>">
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
                        <input type="hidden" name="number" value="<?php echo $row['customerNumber']; ?>">
                        <input type="submit" name="saveCustomer" value="Spara">
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
                <form action="alterCustomer.php" method="post">
                        <tr>
                            <td colspan="2">
                                <?php echo "Ändra lösenord nedan"; ?>
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
                        <input type="hidden" name="number" value="<?php echo $row['customerNumber']; ?>">
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