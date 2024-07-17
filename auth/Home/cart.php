<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit();
}
include '../../koneksi.php'; 

$user_id = $_SESSION['user_id']; 

$sql_user = "SELECT fullname, telepon, email FROM tb_loginuser WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $user_id); 
$stmt_user->execute();
$stmt_user->bind_result($fullname, $telepon, $email);
$stmt_user->fetch();
$stmt_user->close();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $email = htmlspecialchars($_POST['email']);
    $wilayah = htmlspecialchars($_POST['wilayah']);
    $address = htmlspecialchars($_POST['address']);
    $totalPayment = floatval($_POST['totalPayment']);
    $orderDetails = isset($_POST['orderDetails']) ? htmlspecialchars_decode($_POST['orderDetails']) : '';
    $proofOfPayment = ''; 
    if (empty($address)) {
        echo "Address field cannot be empty.";
        exit();
    }
    $order_id = uniqid();
    $sql_insert = "INSERT INTO tb_orders (order_id, user_id, fullname, telepon, email, wilayah, address, total_payment, orderDetails)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssss", $order_id, $user_id, $fullname, $telepon, $email, $wilayah, $address, $totalPayment, $orderDetails);
    if ($stmt_insert->execute()) {
        $orderItems = json_decode($_POST['cartItems'], true);
        foreach ($orderItems as $productName => $item) {
            $quantity = $item['quantity'];
            $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE product_name = ?";
            $stmt_update_stock = $conn->prepare($sql_update_stock);
            $stmt_update_stock->bind_param("is", $quantity, $productName);
            $stmt_update_stock->execute();
            $stmt_update_stock->close();
        }
        require_once '../../midtrans-php-master/Midtrans.php';
        \Midtrans\Config::$serverKey = 'SB-Mid-server-Xeek4LO4Oh6YpdT36Tyf6Dmr';
        \Midtrans\Config::$isProduction = false; 
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => $totalPayment,
        );
        $item_details = array();
        foreach ($orderItems as $productName => $item) {
            $item_details[] = array(
                'id' => $productName,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $productName,
            );
        }
        $customer_details = array(
            'first_name' => $fullname,
            'last_name' => '',
            'email' => $email,
            'phone' => $telepon,
            'shipping_address' => $address,
        );
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            echo "<script>window.location.href = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken';</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken'></noscript>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $stmt_insert->close();
        $conn->close();

        exit();
    } else {
        echo "Error: " . $stmt_insert->error;
    }
    $stmt_insert->close();
    $conn->close();
    exit();
}
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
        .toast {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .show-toast {
            opacity: 1;
        }
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
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "db_sabu"; 
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
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
            $conn->close();
            ?>
        </div>
        <div class="p-4 bg-white rounded-lg shadow-md mt-4">
            <h2 class="text-2xl font-bold mb-4">Keranjang anda !</h2>
            <div id="cartItems">Keranjang anda masih kosong ...</div>
            <p class="mt-4">Total Pembayaran: Rp<span id="totalPayment">0</span></p>
            <button class="btn-primary mt-4" id="checkoutBtn">Bayar</button>
        </div>
    </div>
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

    // Update Cart Display
    function updateCartDisplay() {
        let cartItemsDiv = document.getElementById("cartItems");
        cartItemsDiv.innerHTML = "";

        let totalPrice = 0;
        for (let product in cart) {
            if (cart.hasOwnProperty(product)) {
                let item = cart[product];
                let itemPrice = item.price * item.quantity;
                totalPrice += itemPrice;

                let itemDiv = document.createElement("div");
                itemDiv.className = "cart-item";
                itemDiv.innerHTML = `
                    <span>${product}</span>
                    <span>Price: $${item.price.toFixed(2)}</span>
                    <span>Quantity: ${item.quantity}</span>
                    <span>Total: $${itemPrice.toFixed(2)}</span>
                `;

                cartItemsDiv.appendChild(itemDiv);
            }
        }

        let totalPaymentDiv = document.getElementById("totalPayment");
        totalPaymentDiv.innerText = totalPrice.toFixed(2);
    }

    // Close Modal
    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("checkoutModal").style.display = "none";
    });

    // Submit Order
    document.getElementById("orderForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);

        fetch("path/to/your/php/script.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Display response from the server (for debugging)
            // Handle success or failure here (e.g., show a toast notification)
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>



</body>

</html>