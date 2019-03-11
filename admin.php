

<!DOCTYPE html>
<html>

<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php\'">';
    }*/ //enable when tables are complete


        //object for searches

        $orderObject = new Order;
        $productObject = new Product;
        $productlineObject = new Productline;
        $customerObject = new Customer;
        $adminObject = new Administrator;

        // we dont want to show everything in the database for every search so creating limits and offsets for scrolling through the database

        $limit = 10;
        $pageThroughPageOrders = 1;
        $pageThroughPageProducts = 1;
        $pageThroughPageProductlines = 1;
        $pageThroughPageCustomers = 1;
        $pageThroughPageAdmins = 1;

        if(isset($_POST['nextPageOrders'])) {
                $pageThroughPageOrders = $_POST['pageThroughPageOrders'] + 1;
            } elseif (isset($_POST['previousPageOrders'])) {
                $pageThroughPageOrders = $_POST['pageThroughPageOrders'] - 1;
        }
        
        if(isset($_POST['nextPageProducts'])) {
            $pageThroughPageProducts = $_POST['pageThroughPageProducts'] + 1;
        } elseif (isset($_POST['previousPageProducts'])) {
            $pageThroughPageProducts = $_POST['pageThroughPageProducts'] - 1;
        }

        if(isset($_POST['nextPageProductlines'])) {
            $pageThroughPageProductlines = $_POST['pageThroughPageProductlines'] + 1;
        } elseif (isset($_POST['previousPageProductlines'])) {
            $pageThroughPageProductlines = $_POST['pageThroughPageProductlines'] - 1;
        }

        if(isset($_POST['nextPageCustomers'])) {
            $pageThroughPageCustomers = $_POST['pageThroughPageCustomers'] + 1;
        } elseif (isset($_POST['previousPageCustomers'])) {
            $pageThroughPageCustomers = $_POST['pageThroughPageCustomers'] - 1;
        }

        if(isset($_POST['nextPageAdmins'])) {
            $pageThroughPageAdmins = $_POST['pageThroughPageAdmins'] + 1;
        } elseif (isset($_POST['previousPageAdmins'])) {
            $pageThroughPageAdmins = $_POST['pageThroughPageAdmins'] - 1;
        }
        // just in case
        $err_message = "";
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>

<body>
<?php include_once 'headnav.php'; 

    //check where we have navigated to and store in variable

    $page = "";

    if(isset($_GET['page'])) {
        switch ($_GET['page']) {
            case "orders":
                $page = "orders";
                break;

            case "products":
                $page = "products";
                break;

            case "productlines":
                $page = "productlines";
                break;
                
            case "customers":
            $page = "customers";
                break;

            case "administrators":
                $page = "administrators";
                break;

            case "profile":
                $page = "profile";
                break;

            default:
                $page = "start";
        }
    }

?>

    <main>
        <!-- Start message -->

        <div class="<?php if($page!="start"){ echo "hidden";} ?>">

            <h1>Välkommen till administrationssidorna.</h1>

            <p>Använd navigation för att välja vad du vill administrera.</p>
        </div>

        <!-- Orders -->

        <div class="<?php if($page!="orders"){ echo "hidden";} ?>">
            
            
            <div class="tables">
            <h1>Ordrar</h1>
            
            <div>
                <?php
                    // print a row for each row in $result if this page
                    if($page=="orders"){
                        $pdo = connect_admin();
                        if(isset($_POST['search'])){
                            $orderID = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
                            if(strlen($orderID) == 5){
                                $orderObject->orderNumber = $orderID;
                                $result = $orderObject->get_order_by_orderNumber();
                            } elseif (strlen($orderID) == 3){
                                $orderObject->customerNumber = $orderID;
                                $result = $orderObject->get_order_by_customerNumber();
                            } else {
                                $err_message = "Can only search on orderNumber or customerNumber";
                            $offset = ($pageThroughPageOrders - 1) * 10;
                            
                            $result = get_all_orders($pdo, $limit, $offset);
                            }
                            $_POST['search'] = NULL;
                        } else {
                            $offset = ($pageThroughPageOrders - 1) * 10;
                            
                            $result = get_all_orders($pdo, $limit, $offset);
                        }
                ?>
                <form action="admin.php?page=orders" method="post">
                    <input type="text" name="search"><button name="page" value="orders" type="submit">Sök</button><?php echo $err_message; ?>
                </form>
            </div>

            <table class="fixedTable">
                <thead>
                    <tr>
                        <th>Ordernummer</th>
                        <th>Beställningsdatum</th>
                        <th>Inköpsdatum</th>
                        <th>Skickad</th>
                        <th>Status</th>
                        <th>Kommentarer</th>
                        <th>Kundnummer</th>
                        <th>Redigera</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = $result->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo $row['orderNumber']; ?>
                        </td>
                        <td><?php echo $row['orderDate']; ?>
                        </td>
                        <td><?php echo $row['requiredDate']; ?>
                        </td>
                        <td><?php echo $row['shippedDate']; ?>
                        </td>
                        <td><?php echo $row['status']; ?>
                        </td>
                        <td class="tdfixed"><?php echo $row['comments']; ?>
                        </td>
                        <td><?php echo $row['customerNumber']; ?>
                        </td>
                        <td>
                            <form method='POST' action='alterOrder.php'>
                                <input type='hidden' name='number' value='<?php echo $row['orderNumber']; ?>'>
                                <button type='submit'>Redigera</button>
                            </form>
                        </td>
                    <tr>
                    <?php
                        }
                        }
                    ?>

                </tbody>
            </table>
            <form action="admin.php?page=orders" method="post">
            <div class="pageThrough">
                <div>
                    <input type="hidden" name="pageThroughPageOrders" value="<?php echo $pageThroughPageOrders; ?>"><?php if($pageThroughPageOrders>1) { ?>
                    <button name="previousPageOrders" type="submit"><</button><?php } ?>
                </div>
                <div>
                    <button name="nextPageOrders" type="submit">></button>
                </div>
            </div>
            </form>
        </div>
        </div>
        
        </div>

        <!-- Products -->

        <div class="<?php if($page!="products"){ echo "hidden";} ?>">
            
                <div class="tables">

                    <h1>Produkter</h1>
                    <div>
                        <?php
                            // print a row for each row in $result if this page
                            if($page=="products"){
                                $pdo = connect_admin();
                                if(isset($_POST['productSearch'])){
                                    $productCode = filter_input(INPUT_POST, 'productSearch', FILTER_SANITIZE_MAGIC_QUOTES);
                                    if(strlen($productCode) == 8){
                                        $productObject->productCode = $productCode;
                                        $result = $productObject->get_product();
                                    } else {
                                        $err_message = "Can only search on productCode";
                                    $offset = ($pageThroughPageProducts - 1) * 10;
                                    
                                    $result = get_all_products($pdo, $limit, $offset);
                                    }
                                } else {
                                    $offset = ($pageThroughPageProducts - 1) * 10;
                                    
                                    $result = get_all_products($pdo, $limit, $offset);
                                }
                        ?>
                        <form action="admin.php?page=products" method="post">
                            <input type="text" name="productSearch"><button name="page" value="products" type="submit">Sök</button>
                        </form>
                    </div>
                    <div>
                        <form  action="newProduct.php" method="post">
                            <input type="hidden" name="new" value="product">
                            <button type="submit">Ny Produkt</button>
                        </form>
                    </div>

                    <table class="fixedTable">
                        <thead>
                            <tr>
                                <th>Produktnummer</th>
                                <th>Produktnamn</th>
                                <th>Kategori</th>
                                <th>Skala</th>
                                <th>Tillverkare</th>
                                <th>Lagerstatus</th>
                                <th>Inköpspris</th>
                                <th>Rekomenderat försäljningspris</th>
                                <th>Redigera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // print a row of the table for each row in the search if this page
                                while ($row = $result->fetch()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['productCode']; ?>
                                </td>
                                <td class="fixedTd">
                                    <?php echo $row['productName']; ?>
                                </td>
                                <td>
                                    <?php echo $row['productLine']; ?>
                                </td>
                                <td>
                                    <?php echo $row['productScale']; ?>
                                </td>
                                <td>
                                    <?php echo $row['productVendor']; ?>
                                </td>
                                <td>
                                    <?php echo $row['quantityInStock']; ?>
                                </td>
                                <td>
                                    <?php echo $row['buyPrice']; ?>
                                </td>
                                <td>
                                    <?php echo $row['MSRP']; ?>
                                </td>
                                <td>
                                    <form method="POST" action="alterProduct.php">
                                        <input type="hidden" name="number" value="<?php echo $row['productCode']; ?>">
                                        <button type="submit">Redigera</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                                }
                            ?>
                        </tbody>
                    </table>
                    
                    <form action="admin.php?page=products" method="post">
                    <div class="pageThrough">
                        <div>
                            <input type="hidden" name="pageThroughPageProducts" value="<?php echo $pageThroughPageProducts; ?>"><?php if($pageThroughPageProducts>1) { ?>
                            <button name="previousPageProducts" type="submit"><</button><?php } ?>
                        </div>
                        <div>
                            <button name="nextPageProducts" type="submit">></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        

        <!-- ProductLines -->

        <div class="<?php if($page!="productlines"){ echo "hidden";} ?>">
        
            
                <div class="tables">
                    <h1>Kategorier</h1>

                    <?php
                        // print a row for each row in $result if this page
                        if($page=="productlines"){
                            $pdo = connect_admin();
                            if(isset($_POST['productlineSearch'])){
                                $productLine = filter_input(INPUT_POST, 'productlineSearch', FILTER_SANITIZE_MAGIC_QUOTES);
                                $productlineObject->productLine = $productLine;
                                $result = $productlineObject->get_productline($pdo);
                            } else {
                                $offset = ($pageThroughPageProductlines - 1) * 10;
                                
                                $result = get_all_productlines($pdo, $limit, $offset);
                            }
                    ?>
                    <form  action="admin.php?page=productlines" method="post">
                        <input type="text" name="productlineSearch"><button name="page" value="productlines" type="submit">Sök</button>
                    </form>
                    <div>
                        <form action="newProductline.php" method="post">
                            <input type="hidden" name="new" value="productline">
                            <button type="submit">Ny Kategori</button>
                        </form>
                    </div>
                    <div>
                    <table class="fixedTable">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Redigera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // print a row of the table for each row in the search if this page
                                while ($row = $result->fetch()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['productLine']; ?>
                                </td>
                                <td>
                                    <form method="POST" action="alterProductline.php">
                                        <input type="hidden" name="productline" value="<?php echo $row['productLine']; ?>">
                                        <button type="submit">Redigera</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                                }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    <form action="admin.php?page=productlines" method="post">
                    <div class="pageThrough">
                        <div>
                            <input type="hidden" name="pageThroughPageProductlines" value="<?php echo $pageThroughPageProductlines; ?>"><?php if($pageThroughPageProductlines>1) { ?>
                            <button name="previousPageProductlines" type="submit"><</button><?php } ?>
                        </div>
                        <div>
                            <button name="nextPageProductlines" type="submit">></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        

        <!-- Customers -->

        <div class="<?php if($page!="customers"){ echo "hidden";} ?>">
            
                <div class="tables">

                    <h1>Kunder</h1>
                    <div>
                        <?php
                            if($page=="customers"){
                                $pdo = connect_admin();
                                if(isset($_POST['customerSearch'])){
                                    $customer = filter_input(INPUT_POST, 'customerSearch', FILTER_SANITIZE_NUMBER_INT);
                                    $customerObject->customerNumber = $customer;
                                    $result = $customerObject->get_customer($pdo);
                                } else {
                                    $offset = ($pageThroughPageCustomers - 1) * 10;
                                    
                                    $result = get_all_customers($pdo, $limit, $offset);
                                }
                        ?>
                        <form action="admin.php?page=customers" method="post">
                            <input type="text" name="customerSearch"><button name="page" value="customers" type="submit">Sök</button>
                        </form>
                    </div>

                    <table class="fixedTable">
                        <thead>
                            <tr>
                                <th>Kundnummer</th>
                                <th>Kundens namn</th>
                                <th>Kontaktpersonen</th>
                                <th>Telefonnummer</th>
                                <th>Säljare</th>
                                <th>Max Kredit</th>
                                <th>Redigera</th>
                                <th>Ta bort</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // print a row of the table for each row in the search if this page
                                while ($row = $result->fetch()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['customerNumber']; ?>
                                </td>
                                <td>
                                    <?php echo $row['customerName']; ?>
                                </td>
                                <td>
                                    <?php echo $row['contactLastName']; ?> <?php echo $row['contactFirstName']; ?>
                                </td>
                                <td>
                                    <?php echo $row['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $row['salesRepEmployeeNumber']; ?>
                                </td>
                                <td>
                                    <?php echo $row['creditLimit']; ?>
                                </td>
                                <td>
                                    <form method="POST" action="alterCustomer.php">
                                        <input type="hidden" name="number" value="<?php echo $row['customerNumber']; ?>">
                                        <button type="submit">Redigera</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="deleteCustomer.php">
                                        <input type="hidden" name="number" value="<?php echo $row['customerNumber']; ?>">
                                        <button type="submit">X</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                                }
                            ?>
                        </tbody>
                    </table>
                    <form action="admin.php?page=customers" method="post">
                    
                        <div class="pageThrough">
                            <div>
                                <input type="hidden" name="pageThroughPageCustomers" value="<?php echo $pageThroughPageCustomers; ?>"><?php if($pageThroughPageCustomers>1) { ?>
                                <button name="previousPageCustomers" type="submit"><</button><?php } ?>
                            </div>
                            <div>
                                <button name="nextPageCustomers" type="submit">></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        
        </div>

        <!-- Administrators -->

        <div class="<?php if($page!="administrators"){ echo "hidden";} ?>">
            
                <div class="tables">

                    <h1>Administratörer</h1>
                    <div  >
                        <?php
                            if($page=="administrators"){
                                $pdo = connect_admin();
                                if(isset($_POST['adminSearch'])){
                                    $admin = filter_input(INPUT_POST, 'adminSearch', FILTER_SANITIZE_NUMBER_INT);
                                    $adminObject->adminID = $admin;
                                    $result = $adminObject->get_admin($pdo);
                                } else {
                                    $offset = ($pageThroughPageAdmins - 1) * 10;
                                    $result = get_all_admins($pdo, $limit, $offset);
                                }
                        ?>
                        <form  action="admin.php?page=administrators" method="post">
                            <input type="text" name="adminSearch"><button name="page" value="administrator"
                                type="submit">Sök</button>
                        </form>
                    </div>
                    <div >
                        <form  action="newAdmin.php" method="post">
                            <input type="hidden" name="new" value="admin">
                            <button type="submit" name="page" value="administrator">Ny Administratör</button>
                        </form>
                    </div>

                    <table class="fixedTable">
                        <thead>
                            <tr>
                                <th>Administratörens arbetstagarnummer</th>
                                <th>Efternamn</th>
                                <th>Förnamn</th>
                                <th>Redigera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // print a row of the table for each row in the search if this page is showing
                                while ($row = $result->fetch()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['adminID']; ?>
                                </td>
                                <td>
                                    <?php echo $row['adminLastName']; ?>
                                </td>
                                <td>
                                    <?php echo $row['adminFirstName']; ?>
                                </td>
                                <td>
                                    <form method="POST" action="alterAdmin.php">
                                        <input type="hidden" name="number" value="<?php echo $row['adminID']; ?>">
                                        <button type="submit">Redigera</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                                }
                            ?>
                        </tbody>
                    </table>
                    
                    
                    <form  action="admin.php?page=administrators" method="post">
                        <div class="pageThrough">
                            <div>
                                <input type="hidden" name="pageThroughPageAdmins" value="<?php echo $pageThroughPageAdmins; ?>"><?php if($pageThroughPageAdmins>1) { ?>
                                <button name="previousPageAdmins" type="submit"><</button><?php } ?>
                            </div>
                            <div>
                                <button name="nextPageAdmins" type="submit">></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        
        </div>
        <!-- My Profile -->
        <div class="<?php if($page!="profile"){ echo "hidden";} ?>">
            
                <div class="tables">
        
                    <h1>Min Profil</h1>
                    <?php
                        if($page=="profile"){
                            $administratorNumber = filter_input(INPUT_COOKIE, 'adminID', FILTER_SANITIZE_NUMBER_INT);
                            $adminObject->adminID = $administratorNumber;
                            $result = $adminObject->get_admin();
                            $row = $result->fetch();
                    ?>
                    <table class="fixedTable">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>
                                    <input type="hidden" name="adminID" value="<?php echo $row['adminID']; ?>">
                                    <input type="text" value="<?php echo $row['adminID']; ?>" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>Efternamn</td>
                                <td><input type="text" name="adminLastName" value="<?php echo $row['adminLastName']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Förnamn</td>
                                <td><input type="text" name="adminFirstName" value="<?php echo $row['adminFirstName']; ?>"></td>
                            </tr>
                            <tr>
                                <td>Lösenord
                                </td>
                                <td>
                                    <?php 
                                        $length = strlen($row['password']);
                                        for($i=0;$i<$length;$i++) {
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
                        </tbody>
                    </table>
        
            </div>

            <div id="overlay_center">
                <div class="overlay">
                    <form action="Admin.php" method="post">
                        <table>
                            <tr>
                                <td colspan="2">
                                    <?php

                                    if($err_message = ""){
                                        echo "Ändra lösenord nedan";
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
                                    <button id="cancelPasswordButton">Ångra</button>
                                </td>
                                <td>
                                    <input type="submit" id="savePasswordButton" name="savePassword" value="Spara Lösenord">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>    
            </div>
            <?php
            }
            ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>