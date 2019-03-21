<!DOCTYPE html>
<head>
  <script type="text/javascript" src="js.js"> </script>
</head>

  <html lang="en">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="Nav.css">
    
    <?php
    require_once('functions.php');
    require_once('classes.php');
    require_once('Rogerclasses.php');
    session_start();
   if(isset ($_SESSION['sessionID']) && $_SESSION['sessionID'] != 999){
      echo "Logged in as user number" . $_SESSION['sessionID']; 
    }else{
      $_SESSION['sessionID'] = 999;
      echo "welcome guest!";
    }



    ?>

    <!-------------------------------------------------------------------------------------------------------------------
      ----------                                                                                               ----------
      ----------          HEADER NAVIGATION MENU - Responds to logged in or not by checking $_SESSION          ----------
      ----------                                                                                               ----------
      ------------------------------------------------------------------------------------------------------------------->
    <header>                                                                
      <div class="navLeft">                                                             <!----------------------------------------------------->
          <a class="active" href="#store">Store</a>                                     <!---------                                   --------->
      </div>                                                                            <!--------- These elements are always visible --------->
        <img src="img/logo.png">                                                        <!---------                                   --------->
        <div class=navRight>                                                            <!----------------------------------------------------->



       <?php if($_SESSION['sessionID'] == 999){?>                                       <!----------------------------------------------------->
        <a href="logIn.php" class="right">LogIn</a>                                     <!---------   visible for logged out users    --------->
        <a href="register.php" class="right">Register</a>                               <!----------------------------------------------------->
        <?php } ?> 
        


        <?php if(isset ($_SESSION['sessionID']) && $_SESSION['sessionID'] != 999){ ?>   <!----------------------------------------------------->
        <a href="logout.php" class="right">Log Out</a>                                  <!---------    visible for logged in users    --------->
        <a href="userprofile.php" class="right">Profile</a>                             <!----------------------------------------------------->
        <?php } ?> 



        <a href="varukorg.php" class="right">Shopping cart</a>                          <!---------------    Always visible    ---------------->
      </div>
    </header>

<body>
