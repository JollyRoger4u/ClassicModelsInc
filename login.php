<!doctype html>

<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="/logIn.css">
</head>

<?php
require_once('header.php');
require_once('Rogerclasses.php');
if (isset($_POST['submit'])){
  $userName = $_POST['userName'];
  $userPass = $_POST['password'];
  $user = new UserLogin();
  $user -> UserLogin($userName, $userPass);
  header('Location:index.php');
}


?>
<section id="logInSection">
      <form method="post" action="login.php">
        <ul class="wrapper">
          <li class="form-row">
            <label for="userName">Username:</label>
            <input type="text" id="userName" name="userName">
          </li>
          <li class="form-row">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
          </li>
          <li class="form-row">
            <button type="submit" name="submit">Submit</button>
          </li>
        </ul>
      </form>
      </section>

<!--<script src="js/scripts.js"></script>-->
<?php include'footer.php' ?>