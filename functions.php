<?php

function connect_admin() {
    /* Establish a connection to the database */
     $host = 'localhost';
     $db   = 'classicmodels';
     $user = 'root';
     $pass = '';
     $charset = 'utf8mb4';

     $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

     try {
          $pdo = new PDO($dsn, $user, $pass);
     } catch (\PDOException $e) {
          throw new \PDOException($e->getMessage(), (int)$e->getCode());
     }

     return $pdo;
}

function productline_names($pdo) {

     $sql = "SELECT DISTINCT productLine FROM productlines";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function max_admin_id($pdo) {

     $sql = "SELECT max(adminID) FROM admins";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function min_admin_id($pdo) {

     $sql = "SELECT min(adminID) FROM admins";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function max_customer_id($pdo) {

     $sql = "SELECT max(customerNumber) FROM customers";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function max_productCode($pdo) {

     $sql = "SELECT max(productCode) FROM products";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function max_orderNumber($pdo) {

     $sql = "SELECT max(orderNumber) FROM orders";

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function get_all_productlines($pdo, $limit, $offset) {
     $sql = "";
     if($offset>0){
          $sql = "SELECT * FROM productlines LIMIT $offset, $limit" ;
     } else {
          $sql = "SELECT * FROM productlines LIMIT $limit" ;
     }
     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;

}

function get_all_products($pdo, $limit, $offset) {
     $sql = "";
     if($offset>0){
     $sql = "SELECT * FROM products LIMIT $offset, $limit";
     } else {
          $sql = "SELECT * FROM products LIMIT $limit";
     }

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;
}

function get_all_orders($pdo, $limit, $offset) {
     $sql = "";
     if($offset>0){
     $sql = "SELECT * FROM orders LIMIT $offset, $limit";
     } else {
     $sql = "SELECT * FROM orders LIMIT $limit";
     }

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;
}

function get_all_customers($pdo, $limit, $offset) {
     $sql = "";
     if($offset>0){
     $sql = "SELECT * FROM customers LIMIT $offset, $limit";
     } else {
     $sql = "SELECT * FROM customers LIMIT $limit";
     }

     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;
}

function get_all_admins($pdo, $limit, $offset) {
     $sql = "";
     if($offset>0){
     $sql = "SELECT * FROM admins LIMIT $offset, $limit";
     } else {
     $sql = "SELECT * FROM customers LIMIT $limit";
     }
     $toGet = $pdo->prepare($sql); // prepared statement
     $toGet->execute(); // execute sql statment

     return $toGet;
}

?>