<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['edit-name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['edit-address'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['edit-contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['edit-email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address."); window.location.href = "../supplier/suppliers.php";</script>';
        exit;
    }

    try {
        $query = "UPDATE suppliers SET name = :name, address = :address, contact = :contact, email = :email WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo '<script>alert("Supplier updated successfully!"); window.location.href = "../supplier/suppliers.php";</script>';
        } else {
            echo '<script>alert("Error occurred while updating supplier."); window.location.href = "../supplier/suppliers.php";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Database error: '. addslashes($e->getMessage()) .'"); window.location.href = "../supplier/suppliers.php";</script>';
    }
}
?>
