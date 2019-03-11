<?php 
require_once "functions.php";
require_once "classes.php";


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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


    </head>

    <?php include_once "header.php" ?>



        <main>
        <?php
while ($row = $result->fetch()) {
    ?>
        <article>          
        <section class="gallery">
<img src="<?php echo $row['productImage']; ?>">
        </section>
        <section class="product-details">
            <h2><?php echo $row['productName']; ?></h2>
                <p><?php echo $row['productDescription']; ?></p>
               <h3><?php echo $row['MSRP']; ?>kr</h3>
               <div class="button_group">
	<button onclick="subtract()" id="subtract">- </button><div id="counter">0</div>
	<button onclick="add()" id="add">+</button>
</div>
               <input type="submit" value="Lägg i varukorg">
        </section>
<?php } ?>     

    </article>
        </main>
        <?php include_once "footer.php" ?>
</html>
        
   
