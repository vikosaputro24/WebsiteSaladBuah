<?php
session_start();
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $saladBuahKecil = intval($_POST['saladBuah_kecil']);
    $saladBuahSedang = intval($_POST['saladBuah_sedang']);
    $saladBuahBesar = intval($_POST['saladBuah_besar']);
    $saladBuahJumbo = intval($_POST['saladBuah_jumbo']);

    // Decrease stock based on the ordered quantities
    $updateStockQuery = "UPDATE stock SET 
                            stock_small = stock_small - ?, 
                            stock_medium = stock_medium - ?, 
                            stock_large = stock_large - ?, 
                            stock_jumbo = stock_jumbo - ?";

    $stmt = $conn->prepare($updateStockQuery);
    $stmt->bind_param('iiii', $saladBuahKecil, $saladBuahSedang, $saladBuahBesar, $saladBuahJumbo);

    if ($stmt->execute()) {
        echo "Stock updated successfully.";
    } else {
        echo "Error updating stock: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
