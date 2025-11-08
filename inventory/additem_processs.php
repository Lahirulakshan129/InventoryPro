<?php
include '../DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $additemid = $_POST['itemid'];
    $additemname = $_POST["itemname"];
    $adddescription = $_POST["description"];
    $addcategory = $_POST['category'];
    $addcriticalvalue = $_POST['criticalvalue'];
    $addunitprice = $_POST['unitprice'];
    $addquantity = $_POST['quantity'];

    // Validate input (check if fields are not empty)

    if (!empty($additemname) && !empty($adddescription) && !empty($addcategory) && !empty($addcriticalvalue) && !empty($addunitprice)) {
        
        $status = "";
        if(($addquantity - $addcriticalvalue)>0){
            $status = "In Stock";
        }else if($addquantity==0){
            $status = "Out of Stock";
        }else if(($addquantity - $addcriticalvalue)<0){
            $status = "Low Stock";
        }
        
        $query = "INSERT INTO item (itemid,itemname, description, category, unitprice, criticalvalue, quantity, availability) VALUES (?, ?, ?, ?, ?, ?, ?,?)";

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $pstmt = $con->prepare($query);
        $pstmt->bindParam(1, $additemid);
        $pstmt->bindParam(2, $additemname);
        $pstmt->bindParam(3, $adddescription);
        $pstmt->bindParam(4, $addcategory);
        $pstmt->bindParam(5, $addunitprice);
        $pstmt->bindParam(6, $addcriticalvalue);
        $pstmt->bindParam(7, $addquantity);
        $pstmt->bindParam(8, $status);

        try {
            if ($pstmt->execute()) {
                echo '<script> 
                       alert("Item Added Successfully.");
                       window.location.href="inventory.php";
                      </script>';
            } else {
                echo '<script> 
                       alert("Error Occured.");
                       window.location.href="inventory.php";
                      </script>';
            }
        } catch (PDOException $e) {
            echo "Database error: ". $e->getMessage();
        }
    } else {
        echo '<script> 
               alert("Please fill in all required fields.");
               window.location.href="inventory.php";
              </script>';
    }
}
?>