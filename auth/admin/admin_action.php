<?php
require '../../koneksi.php'; // Sesuaikan dengan path koneksi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $adminname = $_POST['adminname'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action == 'addAdmin') {
        $sql = "INSERT INTO tb_loginadmin (fullname, adminname, telepon, email, password) VALUES ('$fullname', '$adminname', '$telepon', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Admin berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'editAdmin') {
        $sql = "UPDATE tb_loginadmin SET fullname='$fullname', adminname='$adminname', telepon='$telepon', email='$email', password='$password' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Admin berhasil diupdate";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'deleteAdmin') {
        $sql = "DELETE FROM tb_loginadmin WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Admin berhasil dihapus";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
