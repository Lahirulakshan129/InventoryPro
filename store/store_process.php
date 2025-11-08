<?php

class Stores{    
    private $id;
    private $name;
    private $address;
    private $contact;
    private $email;
    
    function __construct($name=null, $address=null, $contact=null, $email=null) {
        $this->name = $name;
        $this->address = $address;
        $this->contact = $contact;
        $this->email = $email;     
    }
    
    public function addStore($con) {
        $query="INSERT INTO store(store_name, contact_no, address,email) VALUES (?,?,?,?)";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindParam(1, $this->name);
            $pstmt->bindParam(2, $this->contact);
            $pstmt->bindParam(3, $this->address);
            $pstmt->bindParam(4, $this->email);
            
            return $pstmt->execute();
            
        } catch (PDOException $exc) {
            die( "Error occured when adding store".$exc->getMessage());
        }
    }
        
    public function editStore($con,$id) {
         $query="UPDATE store SET store_name=?,contact_no=?,address=?,email=? WHERE store_id =?";
         
         try {
            $pstmt = $con->prepare($query);
            $pstmt->bindParam(1, $this->name);
            $pstmt->bindParam(2, $this->contact);
            $pstmt->bindParam(3, $this->address);
            $pstmt->bindParam(4, $this->email);
            $pstmt->bindParam(5, $id);
            
            return $pstmt->execute();
            
        } catch (PDOException $exc) {
            die( "Error occured when editing details".$exc->getMessage());
        }
    }
    
    public function deleteS($con,$id) {
        $query = "DELETE FROM store WHERE store_id=?";
        
        try {
             $pstmt = $con->prepare($query);
        $pstmt->bindParam(1,$id);
        
        return $pstmt->execute();
        
        } catch (PDOException $exc) {
            die( "Error occured".$exc->getMessage());
        }      
    }

}




?>
