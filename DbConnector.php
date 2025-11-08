<?php
class DbConnector{
    private $hostname = "localhost";
    private $dbname = "test_wad";
    private $username = "root";
    private $password = "";
    
    public function getConnection(){
        $dsn = "mysql:host=".$this->hostname.";dbname=".$this->dbname;
        try{
        $con = new PDO($dsn, $this->username, $this->password);
        return $con;
        } catch (PDOException $ex){
            die("Connection Error:".$ex->getMessage());
        }
    }    
}
?>
 

