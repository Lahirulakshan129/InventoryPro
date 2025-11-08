<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['edit-name'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($_POST['edit-quantity'], FILTER_SANITIZE_NUMBER_INT);
    $supplier_id = filter_var($_POST['edit-supplier'], FILTER_SANITIZE_NUMBER_INT);

    if (empty($id) || empty($name) || empty($quantity) || empty($supplier_id)) {
        echo '<script>alert("Please fill in all required fields."); window.location.href = "../supplies/supplies.php";</script>';
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE supplies SET name = ?, quantity = ?, supplier_id = ? WHERE supply_id = ?");
        if ($stmt->execute([$name, $quantity, $supplier_id, $id])) {
            echo '<script>alert("Supply updated successfully!"); window.location.href = "../supplies/supplies.php";</script>';
        } else {
            echo '<script>alert("Error occurred while updating supply."); window.location.href = "../supplies/supplies.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: '. addslashes($e->getMessage()) .'"); window.location.href = "../supplies/supplies.php";</script>';
    }
}
?>
