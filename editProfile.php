<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="logIn.css">
</head>
<?php
require_once ('header.php');


?>

            <?php 
            $pdo = connect_admin();
            $userDisplay = $_SESSION['sessionID'];
            $STH = $pdo -> prepare( "select * from customers where userID=:id" );
            $STH -> execute(['id' => $userDisplay]);
            $result = $STH -> fetchAll();?>
<form method="post" action="userProfile.php">
        <?php foreach( $result as $row ) {
          ?><p>Login Name: <?php echo $row["loginName"]?> </p> <?php ; ?>  
          <p>customerName:  </p> <?php ;    ?> <input type="text" name="customerName" placeholder="<?php echo $row["customerName"]?>">   
          <p>Contact First Name:</p> <?php ;?><input type="text" name="contactFirstName" placeholder="<?php echo $row["contactFirstName"]?>">  
          <p>Contact Last Name:</p> <?php ;?><input type="text" name="contactLastName" placeholder="<?php echo $row["contactLastName"]?>">  
          <p>phone:</p> <?php ;?><input type="text" name="phone" placeholder="<?php echo $row["phone"]?>">  
          <p>addressLine1:</p> <?php ;?><input type="text" name="addressLine1" placeholder="<?php echo $row["addressLine1"]?>">  
          <p>addressLine2:</p> <?php ;?><input type="text" name="addressLine2" placeholder="<?php echo $row["addressLine2"]?>">  
          <p>city:</p> <?php ;?><input type="text" name="city" placeholder="<?php echo $row["city"]?>">  
          <p>state:</p> <?php ;?><input type="text" name="state" placeholder="<?php echo $row["state"]?>">  
          <p>postalCode:</p> <?php ;?><input type="text" name="postalCode" placeholder="<?php echo $row["postalCode"]?>">  
          <p>country:</p> <?php ;?><input type="text" name="country" placeholder="<?php echo $row["country"]?>">  
          <p>salesRepEmployeeNumber:</p> <?php ;}?>
          <button type="submit" name="submit">save changes</button>
</form>    
          
<?php  include ('footer.php') ?>
</html>