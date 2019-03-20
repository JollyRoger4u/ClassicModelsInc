<?php 
require_once "classes.php";
$cart = [];
//$i = 0;
$test2 = new Product;
$sum = 0; 
if(isset($_COOKIE["cart"])) {
    $cart = unserialize($_COOKIE["cart"])  ;
}
if (isset($_POST['deleteBtn']) && $_POST['index_to_remove'] != "") {
    foreach($cart as &$cart_item) {
        if($cart_item["id"] == $_POST['index_to_remove']) {
            $temp = ((int)$cart_item["id"]) -1;
            unset($cart_item["id"]);
            $cart_item["id"] = $temp;
            
            setcookie("cart", serialize($cart), time()+3500);
        }
    }
    //$i++;
}
include_once "header.php" ?>

  <main>
<div class="cart">
<h1>Varukorg</h1>
<table>
    <tr>
        <th>Titel</th>
        <th>Artnr</th>
        <th>Pris</th>
        <th>Antal</th>
        <th>Summa</th>
        <th>Ta bort</th>
    </tr>
<?php
    foreach($cart as $cart_item) {
        $test2->productCode = $cart_item["id"];
        $result = $test2->get_product();
        while ($row = $result->fetch()){
    
            $rowsum = $row['MSRP'] * $cart_item['noOfItems'];
            $sum += $rowsum; 
?>
    <tr class="cartitem">
        <td><?php echo $row['productName']; ?></td>
        <td><?php echo $row['productCode']; ?></td>
        <td><?php echo $row['MSRP']; ?></td>
        <td><button id="subtract" onclick="subtract()";><</button>
           <input id="noOfItems" name="noOfItems" type="text" value="<?php echo $cart_item['noOfItems']; ?>" size="1" maxlength="2">
            <button id="add">></button></td>
        <td><?php echo $rowsum; ?></td>
        <td><form action="varukorg.php" method="post"><input name="deleteBtn" type="submit" value="X"/>
        <input name="index_to_remove" type="hidden" value="<?php echo $row['productCode']; ?>" /></form></td>
	</tr>
<?php   }
    } ?>
    <tr>
        <td colspan="3">Summa:</td>
        <td><?php echo $sum; ?></td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
<?php include_once "footer.php" ?>
</html>