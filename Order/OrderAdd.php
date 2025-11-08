<?php
require './order.php';
require './order_process.php';

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$username = $_POST['username'];
$itemid = $_POST['itemid'];
$storeid = $_POST['storeid'];
$quantity = $_POST['quantity'];
$orderdate = $_POST['orderdate'];

$order = new Order($username, $itemid, $storeid, $quantity,$orderdate);
if ($order->addOrder($con)) {
    echo
        '<script> 
            alert("Order Added Successfully");
            window.location.href="order.php";
        </script>';
} else {
        echo '<script> 
            alert("Not enough stock");
            window.location.href="order.php";
        </script>';
}
?>
