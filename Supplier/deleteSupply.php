<?php
require '../DbConnector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);

    if (empty($id)) {
        header("Location: supplies.php?status=invalid_input");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $stmt = $conn->prepare("DELETE FROM supplies WHERE supply_id = ?");
        $stmt->execute([$id]);

        header("Location: supplies.php?status=success_delete");
    } catch (Exception $e) {
        header("Location: supplies.php?status=error");
    }
} else {
    header("Location: supplies.php");
}
?>
