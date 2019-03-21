<?php 

require_once 'dbconnect.php';
Class UserLogin{

    private $db;

    public function __construct(){
        $this -> db = new DbConnect();
        $this -> db = $this->db->DatabaseConnect();
    }

    public function UserLogIn($userName, $userPass){
        if(!empty($userName) && !empty($userPass)){
            $stmt = $this->db->prepare("select * from customers where loginName=? and password=?");   
            $stmt -> bindParam(1, $userName);
            $stmt -> bindParam(2, $userPass);
            $stmt -> execute();
            $result = $stmt->fetch();
            echo $result['loginName'] . $result['password'];
            echo $userName . $userPass;

        if (($result['loginName'] == $userName) && ($result['password'] == $userPass)){
            $userObj = $stmt->fetch();
            echo "Correct login, ACCESS GRANTED";
            echo "welcome" . $userObj['firstName'];
            $_SESSION['sessionID'] = $result['userID'];
            echo $_SESSION['sessionID'];
        }else{
            echo "Incorrect username or password";
        }
    }else{
        echo "enter username and password plixx";
    }

}
public function logout(){
    session_destroy();
}
}

Class editProfile{
    private $db;

    public function __construct(){
        $this -> db = new DbConnect();
        $this -> db = $this->db->DatabaseConnect();
    }
    public function editProfileData($userName, $userPass){
        if(!empty($userName) && !empty($userPass)){
            $stmt = $this->db->prepare("select * from customers where loginName=? and password=?");   
            $stmt -> bindParam(1, $userName);
            $stmt -> bindParam(2, $userPass);
            $stmt -> execute();
            $result = $stmt->fetch();
            echo $result['loginName'] . $result['password'];
            echo $userName . $userPass;

        if ($result['loginName'] == $userName && $result['password'] == $userPass ){
            $userObj = $stmt->fetch();
            echo "Correct login, ACCESS GRANTED";
            echo "welcome" . $userObj['firstName'];
            $_SESSION['sessionID'] = $result['userID'];
            echo $_SESSION['sessionID'];
        }else{
            echo "Incorrect username or password";
        }
    }else{
        echo "enter username and password plixx";
    }

}
}


?>