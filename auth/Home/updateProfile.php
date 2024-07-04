<?php
session_start(); // Start session to access session variables

// Check if POST request method is used
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have validated and sanitized your inputs
    $new_fullname = $_POST['fullname'];
    $new_username = $_POST['username'];
    $new_telepon = $_POST['telepon'];
    $new_email = $_POST['email'];

    // Example: Database connection parameters
    $db_host = 'localhost'; // Change this to your database host
    $db_user = 'root';      // Change this to your database username
    $db_pass = '';          // Change this to your database password
    $db_name = 'db_sabu'; // Change this to your database name

    // Create connection
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape variables for security to prevent SQL injection
    $new_fullname = mysqli_real_escape_string($conn, $new_fullname);
    $new_username = mysqli_real_escape_string($conn, $new_username);
    $new_telepon = mysqli_real_escape_string($conn, $new_telepon);
    $new_email = mysqli_real_escape_string($conn, $new_email);

    // Update query
    $update_query = "UPDATE tb_loginuser SET fullname = '$new_fullname', username = '$new_username', telepon = '$new_telepon' WHERE email = '$new_email'";

    // Execute query
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Update session with new username if it was changed
        $_SESSION['username'] = $new_username;
        // Redirect or display success message
        header("Location: profile.php"); // Redirect back to profile page
        exit;
    } else {
        // Handle update failure
        echo "Failed to update profile. Please try again.";
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Redirect or handle if it's not a POST request
    header("Location: profile.php"); // Redirect back to profile page
    exit;
}
?>
