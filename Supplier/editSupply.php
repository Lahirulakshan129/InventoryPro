<?php
require '../DbConnector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['edit-name'], FILTER_SANITIZE_STRING);
    $quantity = filter_var($_POST['edit-quantity'], FILTER_SANITIZE_NUMBER_INT);
    $supplier_id = filter_var($_POST['edit-supplier'], FILTER_SANITIZE_NUMBER_INT);

    
    if (empty($id) || empty($name) || empty($quantity) || empty($supplier_id)) {
        header("Location: supplies.php?status=invalid_input");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $stmt = $conn->prepare("UPDATE supplies SET name = ?, quantity = ?, supplier_id = ? WHERE id = ?");
        $stmt->execute([$name, $quantity, $supplier_id, $id]);

        header("Location: supplies.php?status=success_edit");
    } catch (Exception $e) {
        header("Location: supplies.php?status=error");
    }
} else {
    header("Location: supplies.php");
}
?>
