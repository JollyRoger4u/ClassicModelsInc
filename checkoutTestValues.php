<?php 
    unset($_POST['submit']);
    setcookie('delete', 'delete', time() - 3600, "/");
    setcookie('user', 103, time() + 5 * 60, "/");
    $cart = array();

    $cart_item = array(
                            "id" => "S12_1666",
                            "noOfItems" => 3
    );
    
    array_push($cart, $cart_item);
    $cart_item = array(
                            "id" => "S12_3380",
                            "noOfItems" => 1
    );
    
    array_push($cart, $cart_item);
    $cart_item = array(
                            "id" => "S10_4698",
                            "noOfItems" => 4
    );
    
    array_push($cart, $cart_item);
    setcookie('cart', serialize($cart), time() + 5 * 60, "/");
?>