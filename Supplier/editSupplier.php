<?php
require '../DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_var($_POST['s_id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['edit-name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['edit-address'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['edit-contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['edit-email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        header("Location: index.php?status=invalid_email");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $query = "UPDATE suppliers SET name = :name, address = :address, contact = :contact, email = :email WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: index.php?status=success_edit");
        } else {
            header("Location: index.php?status=error");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
