<?php

$dbresult = [
    35 => [
        'title' => 'Energidryck',
        'price' => 15,
    ],
    37 => [
        'title' => 'Coca cola',
        'price' => 18,
    ],
    40 => [
        'title' => 'GB Sandwich',
        'price' => 20,
    ]
];

$cart = [];

if(isset($_COOKIE["cart"])) {
    $cart = unserialize($_COOKIE["cart"])   ;
}

if (isset($_POST['buy'])) {
    echo "Användaren vill lägga till i korg.";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $cart_item = [
        'id' => $_POST['productid'],
        'noOfItems' => $_POST['noOfProducts']
    ];

    array_push($cart, $cart_item);

    setcookie("cart", serialize($cart), time()+3600);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <style>
        .cart {
            width: 500px;
            background-color: lightblue;
        }
    </style>
    <script src="main.js"></script>
</head>
<body>
    <div class="cart">
        <strong>Varukorg</strong><br>
        <table>
            <tr>
                <th>Titel</th>
                <th>Pris</th>
                <th>Antal</th>
                <th>Summa</th>
            </tr>
            <?php $sum = 0; ?>
            <?php foreach($cart as $cart_item): ?>
            <?php
                  $product_id = $cart_item['id'];
                  $rowsum = $dbresult[$product_id]['price'] * $cart_item['noOfItems'];
                  $sum += $rowsum;
             ?>
            <tr class="cartitem">
                <td><?php echo $dbresult[$product_id]['title']; ?></td>
                <td><?php echo $dbresult[$product_id]['price']; ?></td>
                <td><?php echo $cart_item['noOfItems']; ?></td>
                <td><?php echo $rowsum; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Summa:</td>
                <td><?php echo $sum; ?></td>
            </tr>
        </table>
    </div>
    <form method="post">
        <div class="product">
            <strong>Energidryck</strong><br>
            <span class="description">Liquorice brownie dessert icing gummies brownie bear claw icing jelly-o. Apple pie caramels bear claw donut soufflé lemon drops ice cream croissant cake. Chocolate cake oat cake lemon drops apple pie tart biscuit gummi bears cake cotton candy. Wafer gingerbread danish tiramisu sweet roll cheesecake jelly-o. Gummies cake sugar plum sweet bear claw biscuit dragée marzipan. Candy canes carrot cake carrot cake gummi bears. Chocolate bar fruitcake dessert jujubes cupcake croissant. Marzipan dragée powder. Pie marshmallow marshmallow toffee tart ice cream marzipan tiramisu.</span>
            <span class="price">15:-</span>
            <input type="text" name="productid" value="35">
            <input type="number" name="noOfProducts" value="1">
            <input type="submit" name="buy" value="Lägg till i korgen">
        </div>
    </form>
</body>
</html>