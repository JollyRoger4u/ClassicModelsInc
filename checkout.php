<?php

    include_once 'classes.php';
    // check that you are logged in otherwise reroute to login page

    if(!isset($_SESSION['sessionID']) || $_SESSION['sessionID'] == "999") {
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'login.php\'">';
    }

    // initilisation values
    $productObject = new Product; //to get and list products
    $i = 1; //indexation value
    $total_basket = 0; //to calculate the total before deliveryCost
    $total_all = 0; // to calculate total including deliveryCost
    $total_detail = 0; // to calculate total of each product
    $deliveryCost = 20; // set delivery cost before choices have been made
    $numberOfDetails = 0; //the amount of each product
    $numberOfItems = 0; // the total amount of product types
    $row = array(); // array to use for the fetched data from the database

    if(isset($_POST['ups'])){
        $deliveryCost = "200";
        setcookie('deliveryCost', $deliveryCost, time() + 60 * 60, "/");
    } elseif(isset($_POST['schenker'])){
        $deliveryCost = "100";
        setcookie('deliveryCost', $deliveryCost, time() + 60 * 60, "/");
    } elseif(isset($_POST['postnord'])){
        $deliveryCost = "20";
        setcookie('deliveryCost', $deliveryCost, time() + 60 * 60, "/");
    } else {
        setcookie('deliveryCost', $deliveryCost, time() + 60 * 60, "/");
    }

    if(isset($_POST['submit']) && isset($_POST['numberOfItemsHidden'])) {
    setcookie('order', 1, time() + 10, "/");
    setcookie('customerNumber', $_POST['customerNumber'], time() + 1 * 60, "/");
    $numberOfItems = $_POST['numberOfItemsHidden'];
    setcookie('numberOfItemsHidden', $numberOfItems, time() + 1 * 60, "/");
    
    setcookie('totalCost', $_POST['totalCost'], time() + 1 * 60, "/");
    setcookie('delivery', $_POST['delivery'], time() + 1 * 60, "/");


    for($i=1;$i<=$numberOfItems;$i++) {
        $cookieName = 'productCode' . $i;
        $cookieValue = $_POST[$cookieName];
        setcookie($cookieName, $cookieValue, time() + 1 * 60, "/");
        $cookieName = 'amount' . $i;
        $cookieValue = $_POST[$cookieName];
        setcookie($cookieName, $cookieValue, time() + 1 * 60, "/");
        $cookieName = 'detailTotalHidden' . $i;
        $cookieValue = $_POST[$cookieName];
        setcookie($cookieName, $cookieValue, time() + 1 * 60, "/");

    }

    echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'confirmationOrder.php\'">';
    } else {

?>
<?php include_once "header.html"; ?>

<body>
    
    <form method="post" action="checkout.php">
        <div class="centering">
            <div class="checkoutTable">
                <h1>Kassa</h1>
                <table class="checkoutDetails">
                    <thead>
                        <tr>
                            <th class="detailPic">&nbsp;
                            </th>
                            <th class="detailDesciption">&nbsp;
                            </th>
                            <th class="detailPrice">Pris
                            </th>
                            <th class="detailAmount">Mängd
                            </th>
                            <th class="detailTotal">Totalt
                            </th>
                            <th class="detailDelete">&nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // get the products and list one line for each dont forget to set the sums

                            if(!isset($_COOKIE['delete'])) {
                            
                            $cart = unserialize($_COOKIE['cart']);
                            $numberOfItems = count($cart);
                            setcookie('basketNumberOfProducts', $numberOfItems, time() + 5 * 60, "/");

                            foreach($cart as $cart_item) {

                            $productObject->productCode = $cart_item['id'];
                            $result = $productObject->get_product();
                            $row = $result->fetch();
                            $numberOfDetails = $cart_item['noOfItems'];

                            
                            ?>
                            
                        <tr id="<?php echo "detailRow" . $i; ?>">
                            <td class="detailPic"><?php echo $row['image']; ?><input type="hidden" name="<?php echo "detailPic" . "$i"; ?>" value="<?php  echo $row['image']; ?>">
                            </td>
                            <td class="detailDesciption"><?php echo $row['productDescription']; ?><input type="hidden" name="<?php echo "detailDescription" . "$i"; ?>" value="<?php echo $row['productDescription']; ?>">
                            </td>
                            <td class="detailPrice" id="<?php echo "detailPrice" . "$i"; ?>"><?php echo $row['MSRP']; ?><input type="hidden" id="<?php echo "detailPriceHidden" . "$i"; ?>" name="<?php echo "detailPriceHidden" . "$i"; ?>" value="<?php echo $row['MSRP']; ?>">
                            </td>
                            <td class="detailAmount"><div class="centering"><button id="<?php echo "removeQuantity" . "$i"; ?>" onclick="return removeQuantity(<?php echo $i . ', ' . $numberOfItems; ?>)">-</button>
                            <input type="text" value="<?php echo $numberOfDetails; ?>" class="amount" id="<?php echo "productAmount" . "$i"; ?>" name="<?php echo "amount" . "$i"; ?>"><button id="<?php echo "addQuantity" . "$i"; ?>" onclick="return addQuantity(<?php echo $i . ', ' . $numberOfItems; ?>)">+</button></div>
                            </td>
                            <td class="detailTotal" id="<?php echo "detailTotal" . "$i"; ?>"><?php 
                            /*on load this is true */ 
                            $total_detail = $row['MSRP'] * $numberOfDetails; echo $total_detail; /* if amount changes change javascript */
                            ?><input type="hidden" name="<?php echo "detailTotalHidden" . "$i"; ?>" id="<?php echo "detailTotalHidden" . "$i"; ?>" value="<?php echo $total_detail; ?>">
                            </td>
                            <td class="detailDelete"><div class="centering"><button id="<?php echo "delete" . "$i"; ?>" name="delete" onclick='deleteDetail(<?php echo "$numberOfItems" . ", " . "$i"; ?>)'>X</button></div><input type="hidden" id="<?php echo "productCode" . "$i"; ?>" name="<?php echo "productCode" . "$i"; ?>" value="<?php echo $row['productCode']; ?>">
                            </td>
                        </tr>
                        <?php 
                                    $total_basket = $total_basket + $total_detail;
                            
                                    $i++;
                                }
                            } else {

                                $numberOfItems = ((int) $_COOKIE['basketNumberOfProducts'] - 1);
                                setcookie('basketNumberOfProducts', $numberOfItems, time() + 5 * 60, "/");

                                for($i=1;$i<=$numberOfItems;$i++){
                                    $productID = "productCode" . $i;
                                    $productObject->productCode = $_COOKIE[$productID];
                                    $result = $productObject->get_product();
                                    $row = $result->fetch();
                                    $detailsID = "productAmount" . $i;
                                    $numberOfDetails = $_COOKIE[$detailsID];
                            
                            ?>
                            
                        <tr id="<?php echo "detailRow" . $i; ?>">
                            <td class="detailPic"><?php echo $row['image']; ?><input type="hidden" name="<?php echo "detailPic" . "$i"; ?>" value="<?php  echo $row['image']; ?>">
                            </td>
                            <td class="detailDesciption"><?php echo $row['productDescription']; ?><input type="hidden" name="<?php echo "detailDescription" . "$i"; ?>" value="<?php echo $row['productDescription']; ?>">
                            </td>
                            <td class="detailPrice" id="<?php echo "detailPrice" . "$i"; ?>"><?php echo $row['MSRP']; ?><input type="hidden" id="<?php echo "detailPriceHidden" . "$i"; ?>" name="<?php echo "detailPriceHidden" . "$i"; ?>" value="<?php echo $row['MSRP']; ?>">
                            </td>
                            <td class="detailAmount"><div class="centering"><button id="<?php echo "removeQuantity" . "$i"; ?>" onclick="return removeQuantity(<?php echo $i . ', ' . $numberOfItems; ?>)">-</button>
                            <input type="text" value="<?php echo $numberOfDetails; ?>" class="amount" id="<?php echo "productAmount" . "$i"; ?>" name="<?php echo "amount" . "$i"; ?>"><button id="<?php echo "addQuantity" . "$i"; ?>" onclick="return addQuantity(<?php echo $i . ', ' . $numberOfItems; ?>)">+</button></div>
                            </td>
                            <td class="detailTotal" id="<?php echo "detailTotal" . "$i"; ?>"><?php 
                            /*on load this is true */ 
                            $total_detail = $row['MSRP'] * $numberOfDetails; echo $total_detail; /* if amount changes change javascript */
                            ?><input type="hidden" name="<?php echo "detailTotalHidden" . "$i"; ?>" id="<?php echo "detailTotalHidden" . "$i"; ?>" value="<?php echo $total_detail; ?>">
                            </td>
                            <td class="detailDelete"><div class="centering"><button id="<?php echo "delete" . "$i"; ?>" name="delete" onclick='deleteDetail(<?php echo "$numberOfItems" . ", " . "$i"; ?>)'>X</button></div><input type="hidden" id="<?php echo "productCode" . "$i"; ?>" name="<?php echo "productCode" . "$i"; ?>" value="<?php echo $row['productCode']; ?>">
                            </td>
                        </tr>
                        <?php 
                                $total_basket = $total_basket + $total_detail;
                            
                                }

                            }
                        ?> 
                        <tr>
                            <td colspan="4" class="checkoutBottomThree">Summa varukorg:
                            </td>
                            <td class="detailTotal2" id="totalBasket"><?php echo $total_basket; ?><input type="hidden" id="totalBasketHidden" name="totalBasketHidden" value="<?php echo 520; ?>">
                            </td>
                            <td id="numberOfItems"><input type="hidden" id="numberOfItemsHidden" name="numberOfItemsHidden" value="<?php echo $numberOfItems; ?>"> kr
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="checkoutBottomThree">Frakt:
                            </td>
                            <td class="detailTotal2" id="deliveryCost"><?php echo $deliveryCost; ?><input id="deliveryCostHidden" type="hidden" name="delivery" value="<?php echo $deliveryCost; ?>">
                            </td>
                            <td> kr
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="checkoutBottomThree">Total Summa:
                            </td>
                            <td class="detailTotal2" id="totalCost"><?php /*calculate the initial sum and alter with javascript if changes are made */ $total_all = $total_basket + $deliveryCost; echo $total_all;?><input id="totalCostHidden" type="hidden" name="totalCost" value="<?php echo $total_all; ?>">
                            </td>
                            <td> kr
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="centering">
            <div class="sidebyside">
                <div class="centering deliveryTop">
                    <ul class="deliveryChoice">
                            <li id="postnord" class="deliveryItemChoice backgroundChosen">
                                <input name="postnord" type="hidden" value="postnord">
                                <button name="postnord" id="postnordButton" class="deliveryButtons" onclick="return changeDeliveryChoicePostnordButton()">Postnord</button>
                            </li>
                            <li id="ups" class="deliveryItemChoice">
                                <input name="ups" type="hidden" value="ups">
                                <button name="ups" id="upsButton" class="deliveryButtons" onclick="return changeDeliveryChoiceUPSButton()">UPS</button>
                            </li>
                            <li id="schenker" class="deliveryItemChoice">
                                <input name="schenker" type="hidden" value="schenker">
                                <button name="schenker" id="schenkerButton" class="deliveryButtons" onclick="return changeDeliveryChoiceSchenkerButton()">Schenker</button>
                            </li>
                    </ul>
                </div>
                <div class="centering">
                    <?php 
                        //get the customer from the login cookie

                        $customerNumber = $_COOKIE['user'];
                        $customerObject = new Customer;
                        $customerObject->customerNumber = $customerNumber;
                        $result = $customerObject->get_customer();
                        $row = $result->fetch();
                    ?>
                    <div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="customerName">Företagsnamn: </label>
                                <input type="hidden" name="customerNumber" id="customer" value="<?php echo $row['customerNumber']; ?>">
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="customerName" class="customerName" id="customerName" value="<?php echo $row['customerName']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="contactLastName">Kontaktens efternamn: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="contactLastName" class="contactLastName" id="contactLastName" value="<?php echo $row['contactLastName']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="contactFirstName">Kontaktens förnamn: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="contactFirstName" class="contactFirstName" id="contactFirstName" value="<?php echo $row['contactFirstName']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="addressLine1">Adressrad 1:</label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="addressLine1" class="addressLine1" id="addressLine1" value="<?php echo $row['addressLine1']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="addressLine2">Adressrad 2: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="addressLine2" class="addressLine2" id="addressLine2" value="<?php echo $row['addressLine2']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="city">Stad: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="city" class="city" id="city" value="<?php echo $row['city']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="state">Delstat: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="state" class="state" id="state" value="<?php echo $row['state']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="postalCode">Postnummer: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="postalCode" class="postalCode" id="postalCode" value="<?php echo $row['postalCode']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo1">
                                <label for="country">Land: </label>
                            </div>
                            <div class="customerInfo2">
                                <input type="text" name="country" class="country" id="country" value="<?php echo $row['country']; ?>">
                            </div>
                        </div>
                        <div class="customerInfoOuterDiv">
                            <div class="customerInfo">
                                <button class="customerInfoButton" name="submit" value="1">Lägg order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </form>
</body>
<?php 
    }
    echo $_COOKIE['basketNumberOfProducts'];
?>