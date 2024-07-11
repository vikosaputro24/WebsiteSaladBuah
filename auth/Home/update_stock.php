<?php
include '../../koneksi.php'; // Adjust the path as per your file structure

// Handle POST request to update stock
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = htmlspecialchars($_POST['productName']);
    $action = htmlspecialchars($_POST['action']);

    // Update stock based on action (add or remove)
    if ($action == 'add') {
        $sql_update = "UPDATE products SET stock = stock - 1 WHERE product_name = ?";
    } elseif ($action == 'remove') {
        $sql_update = "UPDATE products SET stock = stock + 1 WHERE product_name = ?";
    }

    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("s", $productName);

    if ($stmt_update->execute()) {
        echo "Stock updated successfully!";
    } else {
        echo "Error updating stock: " . $conn->error;
    }

    $stmt_update->close();
    $conn->close();
}
?>
