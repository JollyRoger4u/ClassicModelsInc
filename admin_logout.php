<?php  
$test = session_start();
unset($_SESSION['administrator']);
$test = session_destroy(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta HTTP-EQUIV=REFRESH CONTENT="1; 'admin_login.php'">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Logout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
</head>
<body>