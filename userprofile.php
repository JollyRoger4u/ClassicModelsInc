<!doctype html>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="logIn.css">
</head>
<?php
require_once ('header.php');

if (isset($_POST['submit'])){
    $customerName = $_POST['customerName'];   
    $contactFirstName = $_POST['contactFirstName']; 
    $contactLastName = $_POST['contactLastName']; 
    $phone = $_POST['phone']; 
    $addressLine1 = $_POST['addressLine1']; 
    $addressLine2 = $_POST['addressLine2']; 
    $city = $_POST['city']; 
    $state = $_POST['state']; 
    $postalCode = $_POST['postalCode']; 
    $country = $_POST['country']; 
    echo $customerName;
    $db = connect_admin();
    $id = $_SESSION['sessionID'];
    echo $id;
    $sql = "UPDATE customers SET customerName=:customerName, 
    contactFirstName=:contactFirstName, 
    contactLastName=:contactLastName, 
    phone=:phone, 
    addressLine1=:addressLine1, 
    addressLine2=:addressLine2, 
    city=:city, 
    state=:state, 
    postalCode=:postalCode, 
    country=:country WHERE userID=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":customerName", $customerName, PDO::PARAM_STR);
    $stmt->bindValue(":contactFirstName", $contactFirstName, PDO::PARAM_STR);
    $stmt->bindValue(":contactLastName", $contactLastName, PDO::PARAM_STR);
    $stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
    $stmt->bindValue(":addressLine1", $addressLine1, PDO::PARAM_STR);
    $stmt->bindValue(":addressLine2", $addressLine2, PDO::PARAM_STR);
    $stmt->bindValue(":city", $city, PDO::PARAM_STR);
    $stmt->bindValue(":state", $state, PDO::PARAM_STR);
    $stmt->bindValue(":postalCode", $postalCode, PDO::PARAM_STR);
    $stmt->bindValue(":country", $country, PDO::PARAM_STR);
    $stmt->bindValue(":id", $id, PDO::PARAM_STR);
    $stmt->execute();
}

    ?>
            <?php 
            $pdo = connect_admin();
            $userDisplay = $_SESSION['sessionID'];
            $STH = $pdo -> prepare( "select * from customers where userID=:id" );
            $STH -> execute(['id' => $userDisplay]);
            $result = $STH -> fetchAll();

          foreach( $result as $row ) {
          ?><p>Login Name: <?php echo $row["loginName"]?> </p> <?php ;
          ?><p>customerName: <?php echo $row["customerName"]?> </p> <?php ;        
          ?><p>Contact first name: <?php echo $row["contactFirstName"]?> </p> <?php ;
          ?><p>Contact last name: <?php echo $row["contactLastName"]?> </p> <?php ;
          ?><p>phone: <?php echo $row["phone"]?> </p> <?php ;
          ?><p>addressLine1: <?php echo $row["addressLine1"]?> </p> <?php ;
          ?><p>addressLine2: <?php echo $row["addressLine2"]?> </p> <?php ;
          ?><p>city: <?php echo $row["city"]?> </p> <?php ;
          ?><p>state: <?php echo $row["state"]?> </p> <?php ;
          ?><p>postalCode: <?php echo $row["postalCode"]?> </p> <?php ;
          ?><p>country: <?php echo $row["country"]?> </p> <?php ;
          ?><p>salesRepEmployeeNumber: <?php echo $row["salesRepEmployeeNumber"]?> </p> <?php ;
          }
          
?>
          <a href="editProfile.php">Edit Profile</a>
    <!--<script src="js/scripts.js"></script>-->
<?php include ('footer.php') ?>



</html>