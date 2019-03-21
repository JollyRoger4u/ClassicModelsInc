<?php

include_once 'functions.php';

class Administrator {

    //properties

    public $admin = ['ID' => 0, 'password' => "something"];

    //methods

    public function get_admin() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM adminLogin WHERE ID = '". $this->{"ID"} . "'"; // sql statement

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;
    }

    public function create_admin() {
        $pdo = connect_admin();

        $sql = "INSERT INTO adminLogin (ID, LastName, FirstName, password)
                VALUES ('" . $this->{"ID"} . "', '" . $this->{"LastName"} . "', '" . $this->{"FirstName"} . "', '" . $this->{"password"} . "')"; // sql statement

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_admin() {
        $pdo = connect_admin();

        $sql = "UPDATE adminLogin
                SET LastName = '" . $this->{"LastName"} . "', FirstName = '" . $this->{"FirstName"} . "'
                WHERE ID = '" . $this->{"ID"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }
    
    public function change_password() {
        $pdo = connect_admin();

        $sql = "UPDATE adminLogin
                SET password = '" . $this->{"password"} . "' 
                WHERE ID = '" . $this->{"ID"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }
    
    public function delete_admin() {
        $pdo = connect_admin();

        $sql = "DELETE FROM adminLogin
                WHERE ID = '" . $this->{"ID"} . "'"; // sql statementS

        $toDelete = $pdo->prepare($sql); // prepared statement
        $return = $toDelete->execute(); // execute sql statment

        return $return;
    }

    public function check_admin_login() {

        if($this->{'ID'} != 0){
            $pdo = connect_admin();
            $sql = "SELECT * FROM adminLogin WHERE ID = '" . $this->{"ID"} . "'";
            $toGet = $pdo->prepare($sql); // prepared statement
            $toGet->execute(); // execute sql statment
            $result = $toGet->fetch();

            if($result == FALSE){
                return "No such table";
            } else {

                $test = password_verify($this->{"password"}, $result['password']);

                if(isset($result['ID'])) {
                    if($test) {
                        return TRUE;
                    } else {
                        return "Wrong password";
                    }
                } else {
                    return "No such user";
                }

            }
        } else {
            return "No user specified";
        }
    }    
}

class Product {

    //properties

    public $productCode = 0;
    public $productName = 'something';
    public $productLine = 'Not Set';
    public $productScale = '1:1';
    public $productVendor = 'Companyname';
    public $productDescription = 'text';
    public $quantityInStock = 0;
    public $buyPrice = 0.0;
    public $MSRP = 0.0;

    //methods

    public function get_product() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM products
                WHERE productCode = '" . $this->{"productCode"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;

    }

    public function create_product() {
        $pdo = connect_admin();

        $sql = "INSERT INTO products (productCode, productName, productLine, productScale, productVendor, productDescription, quantityInStock, buyPrice, MSRP)
                VALUES ('" . $this->{"productCode"} . "', '" . $this->{"productName"} . "', '" . $this->{"productLine"} . "', '" . $this->{"productScale"} . "', '" . $this->{"productVendor"} . "', '" . $this->{"productDescription"} . "', '" . $this->{"quantityInStock"} . "', '" . $this->{"buyPrice"} . "', '" . $this->{"MSRP"} . "')"; // sql statement

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_product() {
        $pdo = connect_admin();

        $sql = "UPDATE products
                SET productName = '" . $this->{"productName"} . "', productLine = '" . $this->{"productLine"} . "', productScale = '" . $this->{"productScale"} . "', productVendor = '" . $this->{"productVendor"} . "', productDescription = '" . $this->{"productDescription"} . "', quantityInStock = '" . $this->{"quantityInStock"} . "', buyPrice = '" . $this->{"buyPrice"} . "', MSRP = '" . $this->{"MSRP"} . "'
                WHERE productCode = '" . $this->{"productCode"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }
    
    public function delete_admin() {
        $pdo = connect_admin();

        $sql = "DELETE FROM products
                WHERE productCode = '" . $this->{"productCode"} . "'"; // sql statementS

        $toDelete = $pdo->prepare($sql); // prepared statement
        $return = $toDelete->execute(); // execute sql statment

        return $return;
    }
}

class ProductLine {

    //properties

    public $productLine = '0';
    public $textDescription = 'something';
    public $htmlDescription = 'Not Set';
    public $image = NULL;

    //methods

    public function get_productline() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM productlines
                WHERE productLine = '" . $this->{"productLine"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;

    }

    public function create_productline() {
        $pdo = connect_admin();

        $sql = "INSERT INTO productLines (productLine, textDescription, htmlDescription, image)
                VALUES ('" . $this->{"productLine"} . "', '" . $this->{"textDescription"} . "', '" . $this->{"htmlDescription"} . "', NULL)"; // sql statements

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_productline() {
        $pdo = connect_admin();

        $sql = "UPDATE productLines
                SET textDescription = '" . $this->{"textDescription"} . "', htmlDescription = '" . $this->{"htmlDescription"} . "'
                WHERE productLine = '" . $this->{"productLine"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

    public function upload_picture(){
        
        $sql = "UPDATE productLines
                SET image = '" . $this->{"image"} . "'
                WHERE productLine = '" . $this->{"productLine"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }
    
    public function delete_productline() {
        $pdo = connect_admin();

        $sql = "DELETE FROM productLines
                WHERE productLine = '" . $this->{"productLine"} . "'"; // sql statementS

        $toDelete = $pdo->prepare($sql); // prepared statement
        $return = $toDelete->execute(); // execute sql statment

        return $return;
    }
}

class Customer {

    //properties

    public $customerNumber = 0;
    public $customerName = 'something';
    public $contactLastName = 'Not Set';
    public $contactFirstName = 'Not Set';
    public $phone ='Not Set';
    public $addressLine1 = 'Not Set';
    public $addressLine2 = 'Not Set';
    public $city = 'Not Set';
    public $state = 'Not Set';
    public $postalCode = 'Not Set';
    public $country = 'Not Set';
    public $salesRepEmployeeNumber = 0;
    public $creditLimit = 0.0;
    public $password = 'something';

    //methods

    public function get_customer() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM customers
                WHERE customerNumber = '" . $this->{"customerNumber"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;

    }

    public function create_customer() {
        $pdo = connect_admin();

        $sql = "INSERT INTO customers (customerNumber, customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, salesRepEmployeeNumber, creditLimit)
                VALUES ('" . $this->{"customerNumber"} . "', '" . $this->{"customerName"} . "', '" . $this->{"contactLastName"} . "', '" . $this->{"contactFirstName"} . "', '" . $this->{"phone"} . "', '" . $this->{"addressLine1"} . "', '" . $this->{"addressLine2"} . "', '" . $this->{"city"} . "', '" . $this->{"state"} . "', '" . $this->{"postalCode"} . "', '" . $this->{"salesRepEmployeeNumber"} . "', '" . $this->{"creditLimit"} . "')"; // sql statements

        $toCreate = $pdo->prepare($sql); // prepared statement
        $toCreate->execute(); // execute sql statment

        $sql = "INSERT INTO customers (customerNumber, password)
                VALUES '" . $this->{"customerNumber"} . "', '" . $this->{"password"} . "'"; // sql statementS

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_customer() {
        $pdo = connect_admin();

        $sql = "UPDATE customers
                SET customerName = '" . $this->{"customerName"} . "', contactLastName = '" . $this->{"contactLastName"} . "', contactFirstName = '" . $this->{"contactFirstName"} . "', phone = '" . $this->{"phone"} . "', addressLine1 = '" . $this->{"addressLine1"} . "', addressLine2 = '" . $this->{"addressLine2"} . "', city = '" . $this->{"city"} . "', state = '" . $this->{"state"} . "', postalCode = '" . $this->{"postalCode"} . "', salesRepEmployeeNumber = '" . $this->{"salesRepEmployeeNumber"} . "', creditLimit = '" . $this->{"creditLimit"} . "'
                WHERE customerNumber = '" . $this->{"customerNumber"} . "'"; // sql statement

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

    public function delete_customer() {
        // anonymize data

        $pdo = connect_admin();

        $sql = "UPDATE customers
                SET customerName = 'Deleted', contactLastName = 'Deleted', contactFirstName = 'Deleted', phone = 'Deleted', addressLine1 = 'Deleted', addressLine2 = 'Deleted', city = 'Deleted', state = 'Deleted', postalCode = 'Deleted', salesRepEmployeeNumber = 0, creditLimit = 0.0
                WHERE customerNumber = '" . $this->customerNumber . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

    public function change_password() {
        
        $pdo = connect_admin();

        $sql = "UPDATE customers
                SET password = '" . $this->{"password"} . "'
                WHERE customerNumber = '" . $this->{"customerNumber"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

    public function get_password() {
        
        $pdo = connect_admin();

        $sql = "SELECT password FROM customers
                WHERE customerNumber = '" . $this->{"customerNumber"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment
        
        return $toGet;
    }
}

class Order {

    //properties

    /* public $order = ['orderNumber = 0, 'orderDate = 'something', 'requiredDate = 'Not Set', 'shippedDate = 'Not Set', 'status = 'not set', 'comments = 'comments', 'customerNumber = 0]; */
    
    public $orderNumber = 0;
    public $orderDate = 'something';
    public $requiredDate = 'Not Set';
    public $shippedDate = 'Not Set'; 
    public $status = 'not set';
    public $comments = 'comments';
    public $customerNumber = 0;

    //methods

    public function get_order_by_orderNumber() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM orders
                WHERE orderNumber = '" . $this->{"orderNumber"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;

    }

    public function get_order_by_customerNumber() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM orders
                WHERE customerNumber = '" . $this->{"customerNumber"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;

    }

    public function create_order() {
        $pdo = connect_admin();

        $sql = "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber)
                VALUES '(" . $this->{"orderNumber"} . "', '" . $this->{"orderDate"} . "', '" . $this->{"requiredDate"} . "', '" . $this->{"shippedDate"} . "', '" . $this->{"status"} . "', '" . $this->{"comments"} . "', '" . $this->{"customerNumber"} . "')"; // sql statements

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_order() {
        $pdo = connect_admin();

        $sql = "UPDATE orders
                SET orderDate = '" . $this->{"orderDate"} . "', requiredDate = '" . $this->{"requiredDate"} . "', shippedDate = '" . $this->{"shippedDate"} . "', status = '" . $this->{"status"} . "', comments = '" . $this->{"comments"} . "', customerNumber = '" . $this->{"customerNumber"} . "'
                WHERE orderNumber = '" . $this->{"orderNumber"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

    public function get_details() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM orderdetails
                WHERE orderNumber = '" . $this->{"orderNumber"} . "'"; // sql statementS

        $toDisplay = $pdo->prepare($sql); // prepared statement
        $toDisplay->execute(); // execute sql statment
        
        return $toDisplay;
    }
}

class OrderDetail {

    //properties

    /* public $orderdetail = ['orderNumber = 0, 'productCode = 'something', 'quantityOrdered = 0, 'priceEach = 0.0, 'orderLineNumber = 0]; */

    public $orderNumber = 0;
    public $productCode = 'something'; 
    public $quantityOrdered = 0; 
    public $priceEach = 0.0;
    public $orderLineNumber = 0;

    //methods

    public function get_orderdetail() {
        $pdo = connect_admin();

        $sql = "SELECT * FROM orderdetails
                WHERE orderNumber = '" . $this->{"orderNumber"} . "'"; // sql statementS

        $toGet = $pdo->prepare($sql); // prepared statement
        $toGet->execute(); // execute sql statment

        return $toGet;
    }

    public function create_orderdetail() {
        $pdo = connect_admin();

        $sql = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber)
                VALUES ('" . $this->{"orderNumber"} . "', '" . $this->{"productCode"} . "', '" . $this->{"quantityOrdered"} . "', '" . $this->{"priceEach"} . "', '" . $this->{"orderLineNumber"} . "')"; // sql statements

        $toCreate = $pdo->prepare($sql); // prepared statement
        $return = $toCreate->execute(); // execute sql statment

        return $return;
    }
    
    public function update_orderdetail() {
        $pdo = connect_admin();

        $sql = "UPDATE orderdetails
                SET productCode = '" . $this->{"productCode"} . "', quantityOrdered = '" . $this->{"quantityOrdered"} . "', priceEach = '" . $this->{"priceEach"} . "', orderLineNumber = '" . $this->{"orderLineNumber"} . "'
                WHERE orderNumber = '" . $this->{"orderNumber"} . "'"; // sql statementS

        $toSave = $pdo->prepare($sql); // prepared statement
        $return = $toSave->execute(); // execute sql statment

        return $return;
    }

}

?>