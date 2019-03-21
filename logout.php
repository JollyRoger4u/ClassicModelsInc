
<html>
<?php require_once('header.php') ?>
<h2>
You have been successfully logged out, welcome back another time!
</h2>

<img src="img/bye.jpg">

<?php

session_destroy();

if(empty($_GET['status'])){
    header('Location:logout.php?status=1');
    exit;
}


require_once('footer.php')
?>

