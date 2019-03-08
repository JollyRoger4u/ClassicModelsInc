<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php\'">';
    }*/ //enable when tables are complete

    // create a product object

    $productObject = new Product;

    //check if the object has been saved

    if(isset($_POST['productSave'])) {
        $pdo = connect_admin();
        $get = max_productCode($pdo);
        $productID = ($get->fetch()) + 1; 

        //$productID = filter_input(INPUT_POST, 'productID', FILTER_SANITIZE_MAGIC_QUOTES);
        $productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_MAGIC_QUOTES);
        $productLine = filter_input(INPUT_POST, 'productLine', FILTER_SANITIZE_SPECIAL_CHARS);
        $productScale = filter_input(INPUT_POST, 'productScale', FILTER_SANITIZE_SPECIAL_CHARS);
        $productVendor = filter_input(INPUT_POST, 'productVendor', FILTER_SANITIZE_SPECIAL_CHARS);
        $productDescription = filter_input(INPUT_POST, 'productDescription', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantityInStock = filter_input(INPUT_POST, 'quantityInStock', FILTER_SANITIZE_SPECIAL_CHARS);
        $buyPrice = filter_input(INPUT_POST, 'buyPrice', FILTER_SANITIZE_SPECIAL_CHARS);
        $MSRP = filter_input(INPUT_POST, 'MSRP', FILTER_SANITIZE_SPECIAL_CHARS);
        
        
        $productObject->productCode = $productID;
        $productObject->productName = $productName;
        $productObject->productLine = $productLine;
        $productObject->productScale = $productScale;
        $productObject->productVendor = $productVendor;
        $productObject->productDescription = $productDescription;
        $productObject->quantityInStock = $quantityInStock;
        $productObject->buyPrice = $buyPrice;
        $productObject->MSRP = $MSRP;
        
        $testResult =  $productObject->get_product();

        if($test = $testResult->fetch()){
            $err_message = "There is already an object with this productCode";
        } else {
        $productObject->create_product();
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=products\'">';
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
      
    <main>
        <!-- List the different info -->

        <form action="newProduct.php" method="post">
            <table>
                <tbody>
                   <!--  <tr>
                        <td>Produktnummer</td>
                        <td>
                            <input type="text" name="productCode"></td>
                    </tr> -->
                    <tr>
                        <td>Produktnamn</td>
                        <td><input type="text" name="productName"></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td><select name="productLine">
                        <?php 
                        $pdo = connect_admin();
                        $uniqueProductlines = productline_names($pdo);
                        $row = $uniqueProductlines->fetch();
                        while($row = $uniqueProductlines->fetch()){
                            ?>
                                <option value="<?php echo $row['productLine'] ?>"><?php echo $row['productLine'] ?></option>
                            <?php
                        }
                        ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Skala</td>
                        <td><input type="text" name="productScale"></td>
                    </tr>
                    <tr>
                        <td>Tillverkare</td>
                        <td><input type="text" name="productVendor"></td>
                    </tr>
                    <tr>
                        <td>Beskrivning</td>
                        <td><input type="text" name="productDescription"></td>
                    </tr>
                    <tr>
                        <td>Lagerstatus</td>
                        <td><input type="text" name="quantityInStock"></td>
                    </tr>
                    <tr>
                        <td>Inköpspris</td>
                        <td><input type="text" name="buyPrice"></td>
                    </tr>
                    <tr>
                        <td>Rekomenderat försäljningspris</td>
                        <td><input type="text" name="MSRP"></td>
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