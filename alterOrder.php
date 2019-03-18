<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin_login.php\'">';
    }

    // create an order object, an orderdetail object and a counter for the order details connected to the order object

    $orderObject = new Order;
    $orderDetailObject = new OrderDetail;
    $numberOfOrderDetails = 0;

    // check if the order has been saved

    if(isset($_POST['saveOrder'])){
        $orderNumber = filter_input(INPUT_POST, 'orderNumber', FILTER_SANITIZE_MAGIC_QUOTES);
        $orderDate = filter_input(INPUT_POST, 'orderDate', FILTER_SANITIZE_MAGIC_QUOTES);
        $requiredDate = filter_input(INPUT_POST, 'requiredDate', FILTER_SANITIZE_MAGIC_QUOTES);
        $shippedDate = filter_input(INPUT_POST, 'shippedDate', FILTER_SANITIZE_MAGIC_QUOTES);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_MAGIC_QUOTES);
        $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_MAGIC_QUOTES);
        $customerNumber = filter_input(INPUT_POST, 'customerNumber', FILTER_SANITIZE_MAGIC_QUOTES);
        $numberOfOrderDetails = filter_input(INPUT_POST, 'numberOfOrderDetails', FILTER_SANITIZE_NUMBER_INT);
        
        $orderObject->orderNumber = $orderNumber;
        $orderObject->orderDate = $orderDate;
        $orderObject->requiredDate = $requiredDate;
        $orderObject->shippedDate = $shippedDate;
        $orderObject->status = $status;
        $orderObject->comments = $comments;
        $orderObject->customerNumber = $customerNumber;
        $orderObject->update_order();

        for($i=0;$i<$numberOfOrderDetails;$i++){
            $productCode = filter_input(INPUT_POST, 'productCode'.$i, FILTER_SANITIZE_MAGIC_QUOTES);
            $quantityOrdered = filter_input(INPUT_POST, 'quantityOrdered'.$i, FILTER_SANITIZE_NUMBER_INT);
            $priceEach = filter_input(INPUT_POST, 'priceEach'.$i, FILTER_SANITIZE_SPECIAL_CHARS); // check sanitize filter for decimal
            $orderLineNumber = filter_input(INPUT_POST, 'orderLineNumber'.$i, FILTER_SANITIZE_NUMBER_INT);

            $orderDetailObject->orderNumber = $orderNumber;
            $orderDetailObject->productCode = $productCode;
            $orderDetailObject->quantityOrdered = $quantityOrdered;
            $orderDetailObject->priceEach = $priceEach;
            $orderDetailObject->orderLineNumber = $orderLineNumber;
            if($orderDetailObject->get_orderdetail()!=NULL){
                $orderDetailObject->update_orderdetail();
            } else {
                $orderDetailObject->create_orderdetail();
            }
        }
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=orders\'">';
    }

    // check if orderdetails have been added or deleted

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>
<?php include_once 'headnav.php'; ?>  
    
    <main>
        <!-- List the different info --><?php
        //fetch the admin to alter from post

        $orderID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);

        $orderObject->orderNumber = $orderID;
        $result = $orderObject->get_order_by_orderNumber();
        $row = $result->fetch();

        ?>
        <form action="alterOrder.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Ordernummer</td>
                        <td>
                            <input type="hidden" name="productID" value="<?php echo $row['orderNumber']; ?>">
                            <input type="text" value="<?php echo $row['orderNumber']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Beställningsdatum</td>
                        <td><input type="text" name="orderDate" value="<?php echo $row['orderDate']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Inköpsdatum</td>
                        <td><input type="text" name="requiredDate" value="<?php echo $row['requiredDate']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Skickad</td>
                        <td>
                            <input type="text" name="shippedDate" value="<?php echo $row['shippedDate']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><select name="status">
                                <option value="Shipped" <?php if($row['status'] == "Shipped") {
                                    echo "selected";
                                } ?>>Shipped</option>
                                <option value="Resolved" <?php if($row['status'] == "Resolved") {
                                    echo "selected";
                                } ?>>Resolved</option>
                                <option value="Cancelled" <?php if($row['status'] == "Cancelled") {
                                    echo "selected";
                                } ?>>Cancelled</option>
                                <option value="On Hold" <?php if($row['status'] == "On Hold") {
                                    echo "selected";
                                } ?>>On Hold</option>
                                <option value="Disputed" <?php if($row['status'] == "Disputed") {
                                    echo "selected";
                                } ?>>Disputed</option>
                                <option value="In Process" <?php if($row['status'] == "In Process") {
                                    echo "selected";
                                } ?>>In Process</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Kommentarer</td>
                        <td><input type="text" name="comments" value="<?php echo $row['comments']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Kundnummer</td>
                        <td><input type="text" name="customerNumber" value="<?php echo $row['customerNumber']; ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Order Detaljer</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <table>

    <?php 
        // print all the order details for each order item make sure each post name is different, get the name of the product for easier over view
        $i = 1;
        $productObject = new Product;
        $result2 = $orderObject->get_details();
        
        while($row = $result2->fetch()){
            //get the name of the product
            $productObject->productCode = $row['productCode'];
            $result3 = $productObject->get_product();
            $row2 = $result3->fetch();

    ?>

                    <tr>
                        <td>
                            ProduktID
                        </td>
                        <td><input type="text" name="productCode<?php echo $i ?>" value="<?php echo $row['productCode']; ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            Produktnamn
                        </td>
                        <td><input type="text" name="productName<?php echo $i ?>" value="<?php echo $row2['productName']; ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            Mängd
                        </td>
                        <td><input type="text" name="quantityOrdered<?php echo $i ?>" value="<?php echo $row['quantityOrdered']; ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            Styckepris
                        </td>
                        <td><input type="text" name="priceEach<?php echo $i ?>" value="<?php echo $row['priceEach']; ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            Beställningslinjenummer
                        </td>
                        <td><input type="text" name="orderLineNumber<?php echo $i ?>" value="<?php echo $row['orderLineNumber']; ?>"></td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <button id="deleteOrderDetail">Ta bort orderdetalj</button></td>
                    </tr>

    <?php
        $i++;
        } 
    ?>
                            </table>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button id="addOrderDetail">Lägg till orderdetalj</button>
                        </td>
                        <td>
                            <input type="submit" name="saveOrder" value="Spara">
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>
    </main>
</body>
</html>