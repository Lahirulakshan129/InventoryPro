<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_var($_POST['d_id'], FILTER_SANITIZE_NUMBER_INT);

    if (empty($id)) {
        echo '<script>alert("Invalid input."); window.location.href = "../supplier/suppliers.php";</script>';
        exit;
    }

    try {
        $query = "DELETE FROM suppliers WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<script>alert("Supplier deleted successfully!"); window.location.href = "../supplier/suppliers.php";</script>';
        } else {
            echo '<script>alert("Error occurred while deleting supplier."); window.location.href = "../supplier/suppliers.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: '. addslashes($e->getMessage()) .'"); window.location.href = "../supplier/suppliers.php";</script>';
    }
}
?>
