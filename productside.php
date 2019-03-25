<?php 
require_once "classes.php";


$cart = [];
$inCart = false;

$test = new Product;
if(isset($_COOKIE["cart"])) {
    $cart = unserialize($_COOKIE["cart"]) ;
} 

if (isset($_POST['buy'])) {
    echo "Varan tillagd i korg";
    
    foreach($cart as &$cart_item) {
        if($cart_item["id"] == $_POST['productid']) {
            $inCart = true;
            $newnumberofitems = (int) $_POST['noOfProducts']; // filter_input(INPUT_POST, 'noOfProducts', FILTER_SANITIZE_MAGIC_QUOTES);
            $cart_item['noOfItems'] += $newnumberofitems;
            array_push($cart, $inCart);
            setcookie("cart", serialize($cart), time()+3500);
        }
    }
   if (!$inCart) {
        $cart_item = [
            'id' => $_POST['productid'],
            'noOfItems' => $_POST['noOfProducts']
        ];
        array_push($cart, $cart_item);
        
        setcookie("cart", serialize($cart), time()+3500);
    }

    header('Location: productside.php');
}

include_once "header.php" ?>

<main>
        <article> 
            <a href="shop.php">Tillbaka till shoppen</a> 
            <form method="post" action="productside.php"> 
    <?php
    if(isset($_GET['product'])) {
    $test->productCode = $_GET['product'];
    } else {
    $test->productCode = $_POST['productid'];
    }
    $result = $test->get_product();
    while ($row = $result->fetch()) {
    ?>       
                <div class="gallery">
                <img class="Productimg" src="<?php echo $row['productImage']; ?>">
                </div>
                    <div class="product-details">
                    <h2><?php echo $row['productName']; ?></h2>
                    <p><?php echo $row['productDescription']; ?></p>
                    <p><?php echo $row['MSRP'] ?></p>
                    <input type ="hidden" name="productid" value="<?php echo $row['productCode'] ?>">
                    <input type="number" name="noOfProducts" value="1" min="1">
                    <input type="submit" name="buy" value="Lägg till i korgen"><br>
                    <a href="varukorg.php"><button class="tillkassan">Till varukorgen</button></a>
                    </div>
                    <?php } ?>     

            </form>
        </article>
</main>
<?php include_once "footer.php" ?>