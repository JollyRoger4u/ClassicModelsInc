<?php

class Dbconnect{
    public function DatabaseConnect(){
        return new PDO("mysql:host=localhost; dbname=classicmodels", "root", "");
    }
}

?>