<?php
include '../../koneksi.php';

// Assuming $user_id contains the logged-in user's user_id (UUID)
session_start();
$user_id = $_SESSION['user_id'];

// Prepare and execute a SELECT query to fetch stock values
$sql = "SELECT stock_small, stock_medium, stock_large, stock_jumbo FROM stock WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($stock_small, $stock_medium, $stock_large, $stock_jumbo);
$stmt->fetch();
$stmt->close();

echo json_encode([
    'stock_small' => $stock_small,
    'stock_medium' => $stock_medium,
    'stock_large' => $stock_large,
    'stock_jumbo' => $stock_jumbo,
]);

$conn->close();
?>
