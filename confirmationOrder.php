<?php

    include_once 'classes.php';
    // check that you are logged in otherwise reroute to login page

    if(!isset($_SESSION['currentUser'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'login.php\'">';
    }


    // initilisation values
    if(isset($_COOKIE['order']) && $_COOKIE['order'] == 1) {
    setcookie('order', 1, time() - 3600, "/");

    $productObject = new Product;
    $total_basket = 0;
    $total_all = 0;
    $total_detail = 0;
    $deliveryCost = 20;
    $numberOfDetails = 0;
    $numberOfItems = 0;
    $row = array();
    
    $orderObject = new Order;
    $orderDetailObject = new OrderDetail;

    $pdo = connect_admin();
    $getOldOrderID = max_order_id($pdo);
    $formerMaxOrderID = $getOldOrderID->fetch();
    $orderID = $formerMaxOrderID['max(orderNumber)'] + 1;
    $date = date('Y-m-d');
    $requiredDate = "";
    $shippedDate = "";
    $status = "In Process";
    $customerNumber = $_COOKIE['customerNumber'];
                
    $orderObject->orderNumber = $orderID;
    $orderObject->orderDate = $date;
    $orderObject->requiredDate = $requiredDate;
    $orderObject->shippedDate = $shippedDate;
    $orderObject->status = $status;
    $orderObject->comments = "";
    $orderObject->customerNumber = $customerNumber;

    $isOK = $orderObject->create_order();

    if($isOK) {
        // create order details for all products
        
        $numberOfItems = $_COOKIE['numberOfItemsHidden'];

        for($i=1;$i<=$numberOfItems;$i++) {
            $numberOfDetailsID = "amount" . $i;
            $numberOfDetails = $_COOKIE[$numberOfDetailsID] ;
            $productCodeID = "productCode" . $i;
            $productCode = $_COOKIE[$productCodeID] ;
            $productPriceID = "detailTotalHidden" . $i;
            $productPrice = $_COOKIE[$productPriceID] ;
            $productPrice = (float) $productPrice;

            $orderDetailObject->orderNumber = $orderID;
            $orderDetailObject->productCode = $productCode;
            $orderDetailObject->quantityOrdered = $numberOfDetails;
            $orderDetailObject->priceEach = $productPrice;
            $orderDetailObject->orderLineNumber = 1;

            $isOK2 = $orderDetailObject->create_orderdetail();

        }
            if($isOK2) {

                //add confirmation order here instead of its own page
                ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order konfirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="checkout.css">
    <link rel="stylesheet" type="text/css" media="screen" href="confirmation.css">
</head>

<?php include_once "Header.html"; ?>

<body>
    
    <div class="centering">
        <div class="checkoutTable">
            <h1>Order lagd</h1>
            <h2>Orderdetaljer</h2>
            <h3>Order nummer: <?php echo $orderID; ?></h3>
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $numberOfItems = $_COOKIE['numberOfItemsHidden'];

                        for($i=1; $i<=$numberOfItems; $i++){
                            
                        $codeToAskFor = "productCode" . $i;
                        $productObject->productCode = $_COOKIE[$codeToAskFor];
                        $result = $productObject->get_product();
                        $row = $result->fetch();
                        $detailAmount = 'amount' . $i;
                        $numberOfDetails = $_COOKIE[$detailAmount];
                        $detailTotalID = "detailTotalHidden" . $i;
                        $detailTotal = $_COOKIE[$detailTotalID];
                        
                        ?>
                        
                    <tr>
                        <td class="detailPic"><?php echo $row['image']; ?>
                        </td>
                        <td class="detailDesciption"><?php echo $row['productDescription']; ?>
                        </td>
                        <td class="detailPrice"><?php echo $row['MSRP']; ?>
                        </td>
                        <td class="detailAmount"><?php echo $numberOfDetails; ?>
                        </td>
                        <td class="detailTotal"><?php echo $detailTotal; ?>
                        </td>
                    </tr>
                    <?php
                        }
    
                    ?>
                    <tr>
                        <td colspan="3" class="checkoutBottomThree">Total Summa:
                        </td>
                        <td class="detailTotal2"><?php echo $_COOKIE['totalCost']; ?>
                        </td>
                        <td class="detailTotal"> kr
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="checkoutBottomThree">Var av frakt:
                        </td>
                        <td class="detailTotal2" id="deliveryCost"><?php echo $_COOKIE['delivery']; ?>
                        </td>
                        <td class="detailTotal"> kr
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php
                }
        }
    }
?>