<?php
require '../DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $id = filter_var($_POST['d_id'], FILTER_SANITIZE_NUMBER_INT);


    if (empty($id)) {
        header("Location: index.php?status=invalid_input");
        exit;
    }

    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        $query = "DELETE FROM suppliers WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php?status=success_delete");
        } else {
            header("Location: index.php?status=error");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
