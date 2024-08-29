<?php namespace dataBase;

/**
 * dataBase
 * 
 * @author Ivan Glibko 
 * @version 1.0
 */

class dataBase{
    public $connect;
    
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPassword;

    public function __construct(){
        getDataBasebConfiguration();
        dataBaseConnect();
    }

    public function __destruct(){
        $this->connect->close();
    }

    private function getDataBaseConfiguration(){
        
    }

    private function dataBaseConnect(){
        $this->connect = mysqli_conenct($this->$dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
        if($this->connect->connect_errno){
            die('Connection to database failed: ' . $this->connect->connect_error);
        }
    }
}
?>