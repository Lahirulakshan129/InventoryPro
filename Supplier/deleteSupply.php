<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);

    if (empty($id)) {
        echo '<script>alert("Invalid input."); window.location.href = "../supplies/supplies.php";</script>';
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM supplies WHERE supply_id = ?");
        if ($stmt->execute([$id])) {
            echo '<script>alert("Supply deleted successfully!"); window.location.href = "../supplies/supplies.php";</script>';
        } else {
            echo '<script>alert("Error occurred while deleting supply."); window.location.href = "../supplies/supplies.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: '. addslashes($e->getMessage()) .'"); window.location.href = "../supplies/supplies.php";</script>';
    }
}
?>
