<?php 
require_once "classes.php";



$pdo = connect_admin();
$limit = 10;
$offset = 0;
$result = get_all_products($pdo, $limit, $offset);



?>



<!DOCTYPE html>
<html>
    <head>
        
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </head>


    <?php include_once "header.php" ?>
<main>
<?php
while ($row = $result->fetch()) {
    ?>
       <div class="produktruta">
 <a href="productside.php?product=<?php echo $row['productCode']; ?>"><img class="productimg" src="<?php echo $row['productImage']; ?>"><br>
 <?php echo $row['productName']; ?></a> <br> <?php echo $row['MSRP']; ?><br><button class="readmore"><a href="productside.php?product=<?php echo $row['productCode']; ?>">Läs mer</a></button></div>
    <?php
   
}?> 

</main>
<?php include_once "footer.php" ?>

</html>
   
