<?php require_once "classes.php";

$cart = [];

if(isset($_COOKIE["cart"])) {
    $cart = unserialize($_COOKIE["cart"])   ;
}

$test2 = new Product;
//$test2->productCode = $_GET['product'];
 ?>

  <?php include_once "header.php" ?>
<div class="cart">
<strong>Varukorg</strong><br>
<table>
    <tr>
        <th>Titel</th>
        <th>Artnr</th>
        <th>Pris</th>
        <th>Antal</th>
        <th>Summa</th>
    </tr>
    <?php $sum = 0; ?>

        <?php foreach($cart as $cart_item): ?>
<?php $product_id = $cart_item['id'];
$test2->productCode = $product_id;
$result = $test2->get_product();
while ($row = $result->fetch()){
     ?>
     <?php  $rowsum = $row['MSRP'] * $cart_item['noOfItems'];
$sum += $rowsum; ?>
    <tr class="cartitem">
        <td><?php echo $row['productName']; ?></td>
        <td><?php echo $row['productCode']; ?></td>
        <td><?php echo $row['MSRP']; ?></td>
        <td><?php echo $cart_item['noOfItems']; ?></td>
        <td><?php echo $rowsum; ?></td>
</tr><?php } ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3">Summa:</td>
        <td><?php echo $sum; ?></td>
    </tr>
</table>
</div>
<?php include_once "footer.php" ?>
</html>