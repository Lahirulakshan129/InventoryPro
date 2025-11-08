<?php
require '../DbConnector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemid = filter_var($_POST['itemid'], FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_var($_POST['supply-quantity'], FILTER_SANITIZE_NUMBER_INT);
    $supplier_id = filter_var($_POST['supply-supplier'], FILTER_SANITIZE_NUMBER_INT);

    // Input validation
    if (empty($itemid) || empty($quantity) || empty($supplier_id)) {
        header("Location: supplies.php?status=invalid_input");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $stmt = $conn->prepare("INSERT INTO supplies (itemid, quantity, supplierid) VALUES (?, ?, ?)");
        $stmt->execute([$itemid, $quantity, $supplier_id]);

        header("Location: supplies.php?status=success_add");
    } catch (Exception $e) {
        header("Location: supplies.php?status=error");
    }
} else {
    header("Location: supplies.php");
}
?>
