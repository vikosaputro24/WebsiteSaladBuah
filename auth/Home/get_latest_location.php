<?php
// get_latest_location.php
include '../../koneksi.php';

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("SELECT latitude, longitude, timestamp FROM tracking WHERE order_id = ? ORDER BY timestamp DESC LIMIT 1");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->bind_result($latitude, $longitude, $timestamp);
$stmt->fetch();
$stmt->close();

echo json_encode([
    "latitude" => $latitude,
    "longitude" => $longitude,
    "timestamp" => $timestamp
]);
?>
