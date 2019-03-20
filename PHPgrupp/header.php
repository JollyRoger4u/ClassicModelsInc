<?php
    require_once ('functions.php');
    require_once ('classes.php');
    ?>

<!DOCTYPE html>
<head>
  <script type="text/javascript" src="js.js"> </script>
  <link rel="stylesheet" type="text/css" href="Nav.css">
  <link rel="stylesheet" type="text/css" href="style.css">


  <html lang="en">
  <meta charset="utf-8">

  </head>
  

    <header>
      <div class="navLeft">
          <a class="active" href="shop.php">Store</a>        
      </div>
        <img src="img/logo.png">
        <div class=navRight>  
        <a href="logIn.php" class="right">LogIn</a>                  <!--   To Be Hidden When Logged In      -->
        <a href="logOut.php" class="right">Log Out</a>               <!--   To Be Hidden When NOT Logged In  -->
        <a href="register.php" class="right">Register</a>            <!--   To Be Hidden When Logged In      -->
        <a href="userprofile.php" class="right">Profile</a>          <!--   To Be Hidden When NOT Logged In  -->
        <a href="varukorg.php" class="right">Varukorg</a>       
      </div>
    </header>

<body>
