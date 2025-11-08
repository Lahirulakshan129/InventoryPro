<?php

class Order {

    private $id;
    private $username;
    private $itemid;
    private $store_id;
    private $quantity;
    private $orderdate;

    function __construct($username, $itemid, $store_id, $quantity, $orderdate) {
        $this->username = $username;
        $this->itemid = $itemid;
        $this->store_id = $store_id;
        $this->quantity = $quantity;
        $this->orderdate = $orderdate;
    }

    public function addOrder($con) {
        $q1 = "SELECT userid FROM user WHERE username = ?";
        $p1 = $con->prepare($q1);
        $p1->bindParam(1, $this->username);
        $p1->execute();
        $result = $p1->fetch(PDO::FETCH_OBJ);
        $userid = $result->userid;

        $q3 = "SELECT quantity, criticalvalue FROM item WHERE itemid = ?";
        $p3 = $con->prepare($q3);
        $p3->bindParam(1, $this->itemid);
        $p3->execute();
        $r3 = $p3->fetch(PDO::FETCH_OBJ);
        $m = $r3->quantity;

        $status = "";
        if(($this->quantity - $r3->criticalvalue)>0){
            $status = "In Stock";
        }else if($this->quantity==0){
            $status = "Out of Stock";
        }else if(($this->quantity - $r3->criticalvalue)<0){
            $status = "Low Stock";
        }

        if (($m - $this->quantity) >= 0) {
            $q2 = "UPDATE item SET quantity = quantity - ?, availability = ? WHERE itemid = ?";
            $p2 = $con->prepare($q2);
            $p2->bindParam(1, $this->quantity);
            $p2->bindParam(2, $status);
            $p2->bindParam(3, $this->itemid);
            $a = $p2->execute();

            $query = "INSERT INTO orders(userid, itemid, store_id, quantity, orderdate) VALUES (?,?,?,?,?)";
            try {
                $pstmt = $con->prepare($query);
                $pstmt->bindParam(1, $userid);
                $pstmt->bindParam(2, $this->itemid);
                $pstmt->bindParam(3, $this->store_id);
                $pstmt->bindParam(4, $this->quantity);
                $pstmt->bindParam(5, $this->orderdate);

                return $pstmt->execute();
            } catch (PDOException $exc) {
                die("Error occured when adding store" . $exc->getMessage());
            }
        } else {
            return false;
        }
    }

}
?>

