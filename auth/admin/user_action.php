<?php
require '../../koneksi.php'; // Sesuaikan dengan path koneksi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'] ?? '';
    $fullname = $_POST['fullname'] ?? '';
    $username = $_POST['username'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action == 'addUser') {
        $sql = "INSERT INTO tb_loginuser (fullname, username, telepon, email, password) VALUES ('$fullname', '$username', '$telepon', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "User berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'editUser') {
        $sql = "UPDATE tb_loginuser SET fullname='$fullname', username='$username', telepon='$telepon', email='$email', password='$password' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "User berhasil diupdate";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'deleteUser') {
        $sql = "DELETE FROM tb_loginuser WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "User berhasil dihapus";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
