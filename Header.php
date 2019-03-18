<!DOCTYPE html>
<head>
  <script type="text/javascript" src="js.js"> </script>
</head>

  <html lang="en">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/Nav.css">
    
    <?php
    require_once('functions.php');
    require_once('classes.php');
    ?>

    <header>
      <div class="navLeft">
          <a class="active" href="#store">Store</a>        
      </div>
        <img src="img/logo.png">
        <div class=navRight>  
        <a href="logIn.php" class="right">LogIn</a>                  <!--   To Be Hidden When Logged In      -->
        <a href="logOut.php" class="right">Log Out</a>               <!--   To Be Hidden When NOT Logged In  -->
        <a href="register.php" class="right">Register</a>            <!--   To Be Hidden When Logged In      -->
        <a href="userprofile.php" class="right">Profile</a>          <!--   To Be Hidden When NOT Logged In  -->
        <a href="varukorg.php" class="right">Le Grande Vino Tinto</a>       
      </div>
    </header>

<body>
