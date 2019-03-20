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
    }

    // create a product object

    $productObject = new Product;

    //check if the object has been saved

    if(isset($_POST['productSave'])) {
        $pdo = connect_admin();
        $get = max_productCode($pdo);
        $findcode = $get->fetch(); //get the old code, gets returned as an array with key 'max(productCode)
        $old_code = explode("_", $findcode['max(productCode)']); //devide the string so we can increase the second part by one
        $new_code = $old_code[1] + 1;
        $productID = "$old_code[0]" . "_" . "$new_code"; //splice the old start, the devider and the new code together for a new product code to save in

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
        $productObject->productImage = $productImage;
        
        $testResult =  $productObject->get_product();

        if($test = $testResult->fetch()){
            $err_message = "Det finns redan en produkt med denna produktkod.";
        } else {
            $test = $productObject->create_product();
            if($test) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=products\'">';
            } else {
                $err_message = "Något är fel i sparfunktionen. Kontakta IT supporten.";
            }
        }
    }

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Skapa Ny Produkt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
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