<?php
require '../DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = filter_var($_POST['supplier-name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['supplier-address'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['supplier-contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['supplier-email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?status=invalid_email");
        exit;
    }

 
    if (empty($name) || empty($address) || empty($contact) || empty($email)) {
        header("Location: index.php?status=invalid_input");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $query = "INSERT INTO suppliers (name, address, contact, email) VALUES (:name, :address, :contact, :email)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: index.php?status=success_add");
        } else {
            header("Location: index.php?status=error");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
