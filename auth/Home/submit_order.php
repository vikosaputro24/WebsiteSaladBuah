<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_sabu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$fullname = $_POST['fullname'];
$telepon = $_POST['telepon'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$pos_code = $_POST['pos_code'];
$date = $_POST['date'];
$saladBuah_kecil = $_POST['saladBuah_kecil'];
$saladBuah_sedang = $_POST['saladBuah_sedang'];
$saladBuah_besar = $_POST['saladBuah_besar'];
$saladBuah_jumbo = $_POST['saladBuah_jumbo'];
$totalPayment = $_POST['totalPayment'];
$paymentMethod = $_POST['paymentMethod'];

// File upload handling
$proofOfPayment = $_FILES['proofOfPayment']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["proofOfPayment"]["name"]);

// Select file type
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Valid file extensions
$extensions_arr = array("jpg", "jpeg", "png");

// Initialize notification message
$message = "";

// Check extension
if (in_array($imageFileType, $extensions_arr)) {
    // Upload file
    if (move_uploaded_file($_FILES['proofOfPayment']['tmp_name'], $target_dir . $proofOfPayment)) {
        // Generate unique order ID
        $orders_id = uniqid();

        // Check if order ID already exists (just an example, adjust as needed)
        $check_query = "SELECT * FROM orders WHERE orders_id = '$orders_id'";
        $result = $conn->query($check_query);
        if ($result->num_rows > 0) {
            // If somehow generated ID already exists, generate again (handle as per your logic)
            $orders_id = uniqid();
        }

        // Insert record
        $query = "INSERT INTO orders (orders_id, fullname, telepon, email, address, city, pos_code, date, saladBuah_kecil, saladBuah_sedang, saladBuah_besar, saladBuah_jumbo, totalPayment, paymentMethod, proofOfPayment) 
                  VALUES ('$orders_id', '$fullname', '$telepon', '$email', '$address', '$city', '$pos_code', '$date', '$saladBuah_kecil', '$saladBuah_sedang', '$saladBuah_besar', '$saladBuah_jumbo', '$totalPayment', '$paymentMethod', '$proofOfPayment')";

        if ($conn->query($query) === TRUE) {
            $message = "Pembayaran Anda Telah Berhasil, Terima Kasih !";
        } else {
            $message = "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        $message = "Error uploading file.";
    }
} else {
    $message = "Invalid file type.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Toast</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <script>
        // Function to show toast notification
        function showToast(message, type) {
            Swal.fire({
                icon: type,
                title: message,
                position: 'center',
                showConfirmButton: false,
                timer: 3000
            }).then(function() {
                // Redirect to index.php after showing toast
                window.location.href = '../Home/index.php';
            });
        }

        // Call the function to show toast based on PHP message
        showToast("<?php echo $message; ?>", "<?php echo ($message == 'Pembayaran Anda Telah Berhasil, Terima Kasih !') ? 'success' : 'error'; ?>");
    </script>
</body>

</html>
