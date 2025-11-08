<?php
require '../DbConnector.php';
$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = filter_var($_POST['supplier-name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['supplier-address'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['supplier-contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['supplier-email'], FILTER_SANITIZE_EMAIL);

    // Check empty input first
    if (empty($name) || empty($address) || empty($contact) || empty($email)) {
        echo '<script>
                alert("Please fill in all required fields.");
                window.location.href = "../supplier/suppliers.php";
              </script>';
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
                alert("Invalid email address.");
                window.location.href = "../supplier/suppliers.php";
              </script>';
        exit;
    }

    try {
        $query = "INSERT INTO suppliers (name, address, contact, email) VALUES (:name, :address, :contact, :email)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $lastId = $conn->lastInsertId();

        if ($stmt->execute()) {
            echo '<script>
                    alert("Supplier added successfully!");
                    window.location.href = "../supplier/suppliers.php";
                  </script>';
        } else {
            echo '<script>
                    alert("Error occurred while adding supplier.");
                    window.location.href = "../supplier/suppliers.php";
                  </script>';
        }
    } catch (PDOException $e) {
        echo '<script>
                alert("Database error: ' . addslashes($e->getMessage()) . '");
                window.location.href = "../supplier/suppliers.php";
              </script>';
    }
}
