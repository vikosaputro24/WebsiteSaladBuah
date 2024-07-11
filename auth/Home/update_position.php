<?php
// update_location.php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $delivery_person_id = $_POST['delivery_person_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("INSERT INTO tracking (order_id, delivery_person_id, latitude, longitude) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iidd", $order_id, $delivery_person_id, $latitude, $longitude);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["status" => "success"]);
}
?>
