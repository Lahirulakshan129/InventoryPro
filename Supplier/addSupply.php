<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemid = filter_var($_POST['itemid'], FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_var($_POST['supply-quantity'], FILTER_SANITIZE_NUMBER_INT);
    $supplier_id = filter_var($_POST['supply-supplier'], FILTER_SANITIZE_NUMBER_INT);

    if (empty($itemid) || empty($quantity) || empty($supplier_id)) {
        echo '<script>alert("Please fill in all required fields."); window.location.href = "../supplies/supplies.php";</script>';
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO supplies (itemid, quantity, supplierid) VALUES (?, ?, ?)");
        if ($stmt->execute([$itemid, $quantity, $supplier_id])) {
            echo '<script>alert("Supply added successfully!"); window.location.href = "../supplies/supplies.php";</script>';
        } else {
            echo '<script>alert("Error occurred while adding supply."); window.location.href = "../supplies/supplies.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: '. addslashes($e->getMessage()) .'"); window.location.href = "../supplies/supplies.php";</script>';
    }
}
?>
