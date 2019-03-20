<?php  $session_test = session_start();
        if(!$session_test) {
            echo "session not started";
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

    // create a product object

    $productObject = new Product;

    //check if the object has been saved

    if(isset($_POST['productSave'])) {
        $productID = filter_input(INPUT_POST, 'productID', FILTER_SANITIZE_MAGIC_QUOTES);
        $productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_MAGIC_QUOTES);
        $productLine = filter_input(INPUT_POST, 'productLine', FILTER_SANITIZE_MAGIC_QUOTES);
        $productScale = filter_input(INPUT_POST, 'productScale', FILTER_SANITIZE_MAGIC_QUOTES);
        $productVendor = filter_input(INPUT_POST, 'productVendor', FILTER_SANITIZE_MAGIC_QUOTES);
        $productDescription = filter_input(INPUT_POST, 'productDescription', FILTER_SANITIZE_MAGIC_QUOTES);
        $quantityInStock = filter_input(INPUT_POST, 'quantityInStock', FILTER_SANITIZE_MAGIC_QUOTES);
        $buyPrice = filter_input(INPUT_POST, 'buyPrice', FILTER_SANITIZE_MAGIC_QUOTES);
        $MSRP = filter_input(INPUT_POST, 'MSRP', FILTER_SANITIZE_MAGIC_QUOTES);
        $productImage = filter_input(INPUT_POST, 'productImage', FILTER_SANITIZE_MAGIC_QUOTES);
        
        
        $productObject->productCode = $productID;
        $productObject->productName = $productName;
        $productObject->productLine = $productLine;
        $productObject->productScale = $productScale;
        $productObject->productVendor = $productVendor;
        $productObject->productDescription = $productDescription;
        $productObject->quantityInStock = $quantityInStock;
        $productObject->buyPrice = $buyPrice;
        $productObject->MSRP = $MSRP;
        $productObject->prductImage = $productImage;
        $productObject->update_product();
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=products\'">';
    }

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
        <!-- List the different info -->
        <?php
        //fetch the admin to alter from post

        $productID = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_MAGIC_QUOTES);
        echo $productID;
        $productObject->productCode = $productID;

        $result = $productObject->get_product();
        $row = $result->fetch();

        ?>
        <form action="alterProduct.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Produktnummer</td>
                        <td><input type="hidden" name="productID" value="<?php echo $row['productCode']; ?>">
                            <input type="text" value="<?php echo $row['productCode']; ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>Produktnamn</td>
                        <td><input type="text" name="productName" value="<?php echo $row['productName']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td><select name="productLine"><?php 
                        $pdo = connect_admin();
                        $uniqueProductlines = productline_names($pdo);

                        while($row2 = $uniqueProductlines->fetch()){
                            if($row2['productLine']==$row['productLine']) {  
                            ?>
                                <option value="<?php echo $row2['productLine'] ?>" selected><?php echo $row2['productLine'] ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?php echo $row2['productLine'] ?>"><?php echo $row2['productLine'] ?></option>
                            <?php
                            }
                        }
                        ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Skala</td>
                        <td><input type="text" name="productScale" value="<?php echo $row['productScale']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Tillverkare</td>
                        <td><input type="text" name="productVendor" value="<?php echo $row['productVendor']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Beskrivning</td>
                        <td><input type="text" name="productDescription" value="<?php echo $row['productDescription']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Lagerstatus</td>
                        <td><input type="text" name="quantityInStock" value="<?php echo $row['quantityInStock']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Inköpspris</td>
                        <td><input type="text" name="buyPrice" value="<?php echo $row['buyPrice']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Rekomenderat försäljningspris</td>
                        <td><input type="text" name="MSRP" value="<?php echo $row['MSRP']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Bildens sökväg</td>
                        <td><input type="text" name="productImage" value="<?php echo $row['productImage']; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="productSave" value="Spara"></td>
                    </tr>
                </tbody>
        </table>
        </form>
    </main> 
</body>
</html>