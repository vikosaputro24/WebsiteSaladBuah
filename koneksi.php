<?php

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = ""; // Sesuaikan dengan password database Anda
    $dbname = "db_sabu"; // Sesuaikan dengan nama database Anda

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;

    $conn->close();

?>
