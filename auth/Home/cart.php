<?php
session_start(); // Start the session

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    // Handle the case when user_id is not set, for example, redirect to login page
    header('Location: ../user/login.php');
    exit();
}

// Include your database connection file if not included already
include '../../koneksi.php'; // Adjust the path as per your file structure

// Assuming $user_id contains the logged-in user's user_id (UUID)
$user_id = $_SESSION['user_id']; // Replace with your session variable name

// Prepare and execute a SELECT query to fetch user details
$sql_user = "SELECT fullname, telepon, email FROM tb_loginuser WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $user_id); // Assuming user_id is stored as CHAR/VARCHAR in database
$stmt_user->execute();
$stmt_user->bind_result($fullname, $telepon, $email);
$stmt_user->fetch();
$stmt_user->close();

// Handle form submission
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $fullname = htmlspecialchars($_POST['fullname']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $wilayah = htmlspecialchars($_POST['wilayah']);
    $address = htmlspecialchars($_POST['address']);
    $totalPayment = floatval($_POST['totalPayment']);
    $paymentMethod = htmlspecialchars($_POST['paymentMethod']);
    $orderDetails = isset($_POST['orderDetails']) ? htmlspecialchars_decode($_POST['orderDetails']) : '';
    // Ensure order_details is properly retrieved

    // Handling file upload for proof of payment
    $proofOfPayment = ''; // Placeholder for handling file upload

    // Check if address is not empty
    if (empty($address)) {
        echo "Address field cannot be empty.";
        exit();
    }

    // Check if proof of payment file is uploaded
    if (isset($_FILES['proofOfPayment']) && $_FILES['proofOfPayment']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['proofOfPayment']['tmp_name'];
        $targetFile = 'uploads/' . basename($_FILES['proofOfPayment']['name']);

        if (move_uploaded_file($tempFile, $targetFile)) {
            $proofOfPayment = $targetFile; // Set $proofOfPayment to the file path
        } else {
            echo "Failed to move uploaded file.";
            exit();
        }
    } else {
        echo "Proof of payment file is required.";
        exit();
    }

    // Generate UUID for order_id
    $order_id = uniqid();

    // Prepare INSERT statement
    $sql_insert = "INSERT INTO tb_orders (order_id, user_id, fullname, telepon, email, wilayah, address, total_payment, payment_method, proof_of_payment, orderDetails)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssssss", $order_id, $user_id, $fullname, $telepon, $email, $wilayah, $address, $totalPayment, $paymentMethod, $proofOfPayment, $orderDetails);

    // Execute the INSERT statement
    if ($stmt_insert->execute()) {
        // Order successfully inserted

        // Update stock for each product in the order
        $orderItems = json_decode($_POST['cartItems'], true);
        foreach ($orderItems as $productName => $item) {
            $quantity = $item['quantity'];
            $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE product_name = ?";
            $stmt_update_stock = $conn->prepare($sql_update_stock);
            $stmt_update_stock->bind_param("is", $quantity, $productName);
            $stmt_update_stock->execute();
            $stmt_update_stock->close();
        }

        echo "<script>
        alert('Pemesanan Berhasil !');
        window.location.href = 'cart.php'; // Ganti dengan halaman tujuan Anda
      </script>";
        // You can redirect or perform further actions here
    } else {
        // Error in executing SQL statement
        echo "Error: " . $stmt_insert->error;
    }

    // Close statement and connection
    $stmt_insert->close();
    $conn->close();

    // Redirect or show success message as needed
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Gaya kustom tambahan */
        .toast {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .show-toast {
            opacity: 1;
        }

        /* Gaya khusus untuk modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 10px 16px;
            background-color: #5DADE2;
            color: white;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .modal-body {
            padding: 16px;
        }

        .modal-footer {
            padding: 10px 16px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            text-align: right;
        }

        /* Gaya khusus untuk tombol-tombol */
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .btn-secondary {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-secondary:hover {
            background-color: #da190b;
        }
    </style>
</head>

<body class="min-h-screen" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="container mx-auto p-4">
    <div class="flex items-center mb-4">
    <a href="./index.php" class="flex items-center">
        <i class="fas fa-arrow-left text-blue-500 hover:text-blue-700 cursor-pointer mr-3" style="color: black;"></i>
        <h1 class="text-3xl font-bold">Produk Kami</h1>
    </a>
</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php
            // Konfigurasi koneksi ke database
            $servername = "localhost";
            $username = "root"; // Ganti dengan username MySQL Anda
            $password = ""; // Ganti dengan password MySQL Anda
            $dbname = "db_sabu"; // Ganti dengan nama database Anda

            // Buat koneksi ke database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Periksa koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mengambil data produk
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Tampilkan data produk
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="bg-white p-4 rounded-lg shadow-md">';
                    echo '<h3 class="text-lg text-center font-bold mb-2" style="font-size: 24px;">' . $row['product_name'] . '</h3>';
                    echo '<p class="mb-2">Stok: <span id="stock' . str_replace(' ', '', $row['product_name']) . '" class="font-semibold">' . $row['stock'] . '</span></p>';
                    echo '<p class="mb-2">Harga: Rp<span class="font-semibold">' . $row['price'] . '</span></p>';
                    echo '<label for="quantity' . str_replace(' ', '', $row['product_name']) . '">Banyak:</label>';
                    echo '<input placeholder="Berapa banyak ?" type="text" id="quantity' . str_replace(' ', '', $row['product_name']) . '" name="quantity' . str_replace(' ', '', $row['product_name']) . '" class="w-full border rounded p-1 mb-2">';
                    echo '<button class="add-to-cart btn-primary w-full" style="background-color:blue;" data-product="' . $row['product_name'] . '" data-price="' . $row['price'] . '" data-stock="' . $row['stock'] . '">Tambah Ke keranjang</button>';
                    echo '</div>';
                }
            } else {
                echo "Tidak ada produk yang tersedia.";
            }

            // Tutup koneksi database
            $conn->close();
            ?>
        </div>

        <!-- Shopping Cart -->
        <div class="p-4 bg-white rounded-lg shadow-md mt-4">
            <h2 class="text-2xl font-bold mb-4">Keranjang anda !</h2>
            <div id="cartItems">Keranjang anda masih kosong ...</div>
            <p class="mt-4">Total Pembayaran: Rp<span id="totalPayment">0</span></p>
            <button class="btn-primary mt-4" id="checkoutBtn">Bayar</button>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header flex">
                <span class="close mr-4">&times;</span>
                <h2>Pembayaran</h2>
            </div>
            <div class="modal-body">
                <form id="checkoutForm" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" id="totalPaymentInput" name="totalPayment">
                    <input type="hidden" id="cartItemsInput" name="cartItems">
                    <div class="mb-4">
                        <label for="fullname" class="block">Nama Lengkap:</label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="telepon" class="block">Nomor Telepon:</label>
                        <input type="text" id="telepon" name="telepon" value="<?php echo htmlspecialchars($telepon); ?>" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="wilayah" class="block">Wilayah / Daerah:</label>
                        <select id="wilayah" name="wilayah" class="w-full border rounded p-2" required>
                            <option value="sekitar_perumnas">Sekitar Perumnas</option>
                            <option value="sekitar_gunadarma_karawaci">Sekitar Gunadarma Karawaci</option>
                            <option value="sekitar_tangerang">Sekitar Tangerang</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block">Alamat Lengkap:</label>
                        <textarea id="address" name="address" class="w-full border rounded p-2" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="paymentMethod" class="block">Metode Pembayaran:</label>
                        <select id="paymentMethod" name="paymentMethod" class="w-full border rounded p-2" required>
                            <option value="Bank BCA (7235535874)">Bank BCA (7235535874)</option>
                            <option value="Bank Mandiri (1550012084433)">Bank Mandiri (1550012084433)</option>
                            <option value="Bank DKI (62723140933)">Bank DKI (62723140933)</option>
                            <option value="Gopay (085710847277)">Gopay (085710847277)</option>
                            <option value="Shopee Pay (081514587316)">Shopee Pay (081514587316)</option>
                            <option value="Ovo (081514587316)">Ovo (081514587316)</option>
                            <option value="Dana (085710847277)">Dana (081514587316)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="proofOfPayment" class="block">Unggah Bukti Pembayaran:</label>
                        <input type="file" id="proofOfPayment" name="proofOfPayment" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="orderDetails" class="block">Detail Pesanan:</label>
                        <div id="orderDetails" class="w-full border rounded p-2"></div>
                        <input type="hidden" id="orderDetailsInput" name="orderDetails" value="">

                    </div>

                    <button type="submit" class="btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cart = {}; // Initialize an empty cart

            // Add to Cart button click event
            document.querySelectorAll(".add-to-cart").forEach(function(button) {
                button.addEventListener("click", function() {
                    let productName = button.getAttribute("data-product");
                    let productPrice = parseFloat(button.getAttribute("data-price"));
                    let productStock = parseInt(button.getAttribute("data-stock"));
                    let quantityInput = document.getElementById("quantity" + productName.replace(/ /g, ""));
                    let quantity = parseInt(quantityInput.value);

                    if (quantity > 0 && quantity <= productStock) {
                        if (cart[productName]) {
                            cart[productName].quantity += quantity;
                        } else {
                            cart[productName] = {
                                price: productPrice,
                                quantity: quantity,
                                stock: productStock
                            };
                        }

                        updateCartDisplay();
                        quantityInput.value = ""; // Reset the quantity input
                    } else {
                        alert("Invalid quantity. Please enter a quantity between 1 and " + productStock);
                    }
                });
            });

            function displayOrderDetails() {
    const orderDetailsDiv = document.getElementById('orderDetails');
    let orderDetails = []; // Menyimpan detail pesanan dalam bentuk array

    for (const product in cart) {
        if (cart.hasOwnProperty(product)) {
            orderDetails.push(`${product}: ${cart[product].quantity}`); // Tambahkan setiap item sebagai string
        }
    }

    // Tampilkan sebagai daftar HTML
    const orderDetailsHTML = '<ul>' + orderDetails.map(item => `<li>${item}</li>`).join('') + '</ul>';
    orderDetailsDiv.innerHTML = orderDetailsHTML;

    // Simpan sebagai JSON untuk PHP
    const orderDetailsJSON = JSON.stringify(orderDetails);
    // Menggunakan hidden input untuk menyimpan orderDetailsJSON
    document.getElementById('orderDetailsInput').value = orderDetailsJSON;
}


            document.getElementById("checkoutBtn").addEventListener("click", function() {
                displayOrderDetails(); // Update the order details before displaying the modal
                let totalPayment = parseFloat(document.getElementById("totalPayment").innerText);
                document.getElementById("totalPaymentInput").value = totalPayment;
                document.getElementById("cartItemsInput").value = JSON.stringify(cart);

                // Show the checkout modal
                document.getElementById("checkoutModal").style.display = "block";
            });

            // Update Cart display
            function updateCartDisplay() {
                let cartItemsDiv = document.getElementById("cartItems");
                cartItemsDiv.innerHTML = "";

                let totalPayment = 0;
                for (let product in cart) {
                    let item = cart[product];
                    totalPayment += item.price * item.quantity;

                    cartItemsDiv.innerHTML += `
                <div class="cart-item mb-2">
                    <p class="font-semibold">${product}</p>
                    <p>Harga: Rp${item.price} x Banyak: ${item.quantity} = Rp${item.price * item.quantity}</p>
                    <button class="btn-secondary remove-from-cart" data-product="${product}">Hapus</button>
                </div>
            `;
                }

                document.getElementById("totalPayment").innerText = totalPayment.toFixed(2);

                // Add click event to Remove buttons
                document.querySelectorAll(".remove-from-cart").forEach(function(button) {
                    button.addEventListener("click", function() {
                        let productName = button.getAttribute("data-product");
                        delete cart[productName];
                        updateCartDisplay();
                    });
                });
            }

            // Checkout button click event
            document.getElementById("checkoutBtn").addEventListener("click", function() {
    displayOrderDetails(); // Update the order details before displaying the modal
    let totalPayment = parseFloat(document.getElementById("totalPayment").innerText);
    document.getElementById("totalPaymentInput").value = totalPayment;
    document.getElementById("cartItemsInput").value = JSON.stringify(cart);

    // Show the checkout modal
    document.getElementById("checkoutModal").style.display = "block";
});


            // Close the modal
            document.querySelector(".close").addEventListener("click", function() {
                document.getElementById("checkoutModal").style.display = "none";
            });

            // Close the modal when clicking outside the modal content
            window.addEventListener("click", function(event) {
                if (event.target == document.getElementById("checkoutModal")) {
                    document.getElementById("checkoutModal").style.display = "none";
                }
            });
        });
    </script>
</body>

</html>