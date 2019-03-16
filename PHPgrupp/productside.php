<?php 

require_once "classes.php";

$cart = [];

if (isset($_POST['buy'])) {
    echo "Varan tillagd i korg";
    echo "<pre>";
   //print_r($_POST);
    echo "</pre>";

    $cart_item = [
        'id' => $_POST['productid'],
        'noOfItems' => $_POST['noOfProducts']
    ];

    array_push($cart, $cart_item);

    setcookie("cart", serialize($cart), time()+3500);
}
$test = new Product;
$test->productCode = $_GET['product'];
$result = $test->get_product();
?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="js.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            </head>

    <?php include_once "header.php" ?>
  <main>
        <?php
while ($row = $result->fetch()) {
    ?>
        <article> 
        <a href="shop.php">Tillbaka till shoppen</a> 
            <form method="post">        
        <section class="gallery">
<img src="<?php echo $row['productImage']; ?>">
        </section>
        <section class="product-details">
            <h2><?php echo $row['productName']; ?></h2>
                <p><?php echo $row['productDescription']; ?></p>
               <input type="text" name="price"value="<?php echo $row['MSRP'] ?>">
               <input type ="hidden" name="productid" value="<?php echo $row['productCode'] ?>">
        <input type="number" name="noOfProducts" value="1">
<input type="submit" name="buy" value="Lägg till i korgen">
<a href="varukorg.php">Till varukorgen</a>
        </section>
<?php } ?>     

    </article>
</form>
        </main>
        <?php include_once "footer.php" ?>
</html>
        
   
