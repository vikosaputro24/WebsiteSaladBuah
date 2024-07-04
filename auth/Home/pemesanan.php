<?php
session_start(); // Start the session

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    // Handle the case when user_id is not set, for example, redirect to login page
    header('Location: ../user/login.php');
    exit();
}

// Include your database connection file if not included already
include '../../koneksi.php'; // adjust the path as per your file structure

// Assuming $user_id contains the logged-in user's user_id (UUID)
$user_id = $_SESSION['user_id']; // Replace with your session variable name

// Prepare and execute a SELECT query to fetch user details
$sql = "SELECT fullname, telepon, email FROM tb_loginuser WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id); // Assuming user_id is stored as CHAR/VARCHAR in database
$stmt->execute();
$stmt->bind_result($fullname, $telepon, $email);
$stmt->fetch();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salad Buah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(50, 50, 93, 0.15), 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 py-12" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">

    <div class="max-w-7xl mx-auto flex justify-between items-center mb-8">
        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </button>

        <button id="orderBtn" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md flex items-center">
            Pesan Sekarang
            <i class="fas fa-shopping-cart ml-2"></i>
        </button>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 gap-8 md:grid-cols-2">
        <!-- Card Kecil -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card md:col-span-1" data-product="Salad Kecil">
            <img class="h-48 w-full object-cover" src="/salad_kecil.jpg" alt="Salad Kecil">
            <div class="p-6">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Salad Kecil</div>
                <p class="mt-2 text-gray-500">Porsi kecil untuk camilan ringan.</p>
                <p class="mt-2 text-gray-500">Stock: <span id="stock-small">10</span></p>
                <p class="mt-2 text-gray-500">Price: <span id="price-small">13,000</span></p>
            </div>
        </div>

        <!-- Card Sedang -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card md:col-span-1" data-product="Salad Sedang">
            <img class="h-48 w-full object-cover" src="/salad_sedang.jpg" alt="Salad Sedang">
            <div class="p-6">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Salad Sedang</div>
                <p class="mt-2 text-gray-500">Porsi sedang untuk santapan sehari-hari.</p>
                <p class="mt-2 text-gray-500">Stock: <span id="stock-medium">20</span></p>
                <p class="mt-2 text-gray-500">Price: <span id="price-medium">16,000</span></p>
            </div>
        </div>

        <!-- Card Besar -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card md:col-span-1" data-product="Salad Besar">
            <img class="h-48 w-full object-cover" src="/salad_besar.jpg" alt="Salad Besar">
            <div class="p-6">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Salad Besar</div>
                <p class="mt-2 text-gray-500">Porsi besar untuk acara spesial.</p>
                <p class="mt-2 text-gray-500">Stock: <span id="stock-large">5</span></p>
                <p class="mt-2 text-gray-500">Price: <span id="price-large">19,000</span></p>
            </div>
        </div>

        <!-- Card Jumbo -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden card md:col-span-1" data-product="Salad Jumbo">
            <img class="h-48 w-full object-cover" src="/salad_jumbo.jpg" alt="Salad Jumbo">
            <div class="p-6">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Salad Jumbo</div>
                <p class="mt-2 text-gray-500">Porsi jumbo untuk berbagi dengan banyak orang.</p>
                <p class="mt-2 text-gray-500">Stock: <span id="stock-jumbo">2</span></p>
                <p class="mt-2 text-gray-500">Price: <span id="price-jumbo">25,000</span></p>
            </div>
        </div>
    </div>

    <!-- Order Form Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="text-2xl font-semibold mb-4">Form Pemesanan</h2>
            <form id="orderForm" action="submit_order.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Masukkan Nama Lengkap ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo htmlspecialchars($fullname); ?>" required>
                    </div>

                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                        <input type="tel" name="telepon" id="telepon" placeholder="Masukkan Nomor Telepon ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo htmlspecialchars($telepon); ?>" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan Email ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="address" id="address" placeholder="Masukkan Alamat ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <input type="text" name="city" id="city" placeholder="Masukkan Kota/Kabupaten ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="pos_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" name="pos_code" id="pos_code" placeholder="Masukkan Kode Pos ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Pemesanan</label>
                        <input type="date" name="date" id="date" class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div>
                        <label for="saladBuah_kecil" class="block text-sm font-medium text-gray-700">Salad Buah Kecil (Rp. 13.000)</label>
                        <input type="text" name="saladBuah_kecil" id="saladBuah_kecil" placeholder="Berapa banyak ? ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="saladBuah_sedang" class="block text-sm font-medium text-gray-700">Salad Buah Sedang (Rp. 16.000)</label>
                        <input type="text" name="saladBuah_sedang" id="saladBuah_sedang" placeholder="Berapa banyak ? ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="saladBuah_besar" class="block text-sm font-medium text-gray-700">Salad Buah Besar (Rp. 19.000)</label>
                        <input type="text" name="saladBuah_besar" id="saladBuah_besar" placeholder="Berapa banyak ? ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="saladBuah_jumbo" class="block text-sm font-medium text-gray-700">Salad Buah Jumbo (Rp. 25.000)</label>
                        <input type="text" name="saladBuah_jumbo" id="saladBuah_jumbo" placeholder="Berapa banyak ? ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="totalPayment" class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                        <input type="text" name="totalPayment" id="totalPayment" placeholder="Total Pembayaran Anda ..." class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                    </div>

                    <div>
                        <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <select name="paymentMethod" id="paymentMethod" class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>

                    <div>
                        <label for="proofOfPayment" class="block text-sm font-medium text-gray-700">Unggah Bukti Pembayaran (JPG/PNG)</label>
                        <input type="file" name="proofOfPayment" id="proofOfPayment" class="mt-1 p-3 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow-md hover:bg-indigo-700">Submit Order</button>
                </div>
            </form>
        </div>
    </div>
    <div id="totalPaymentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="text-2xl font-semibold mb-4">Total Pembayaran</h2>
        <form id="totalPaymentForm">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="totalPayment" class="block text-sm font-medium text-gray-700">Total Pembayaran</label>
                    <input type="text" id="totalPayment" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                </div>
            </div>
            <div class="mt-6">
                <button onclick="openPaymentMethodModal()" class="w-full bg-indigo-600 text-white py-2 rounded-md shadow-md hover:bg-indigo-700">Lanjutkan</button>
            </div>
        </form>
    </div>
</div>

    <script>
            function updateStock() {
            document.getElementById('stock-small').textContent = localStorage.getItem('stock-small') || 10;
            document.getElementById('stock-medium').textContent = localStorage.getItem('stock-medium') || 20;
            document.getElementById('stock-large').textContent = localStorage.getItem('stock-large') || 5;
            document.getElementById('stock-jumbo').textContent = localStorage.getItem('stock-jumbo') || 2;
        }

        updateStock();
        
        document.getElementById('orderBtn').addEventListener('click', function () {
            document.getElementById('orderModal').style.display = 'block';
        });

        document.querySelector('.close').addEventListener('click', function () {
            document.getElementById('orderModal').style.display = 'none';
        });

        function calculateTotalPayment() {
            var saladBuahKecil = document.getElementById('saladBuah_kecil').value;
            var saladBuahSedang = document.getElementById('saladBuah_sedang').value;
            var saladBuahBesar = document.getElementById('saladBuah_besar').value;
            var saladBuahJumbo = document.getElementById('saladBuah_jumbo').value;

            var priceSmall = 13000; // Update these with the actual prices
            var priceMedium = 16000;
            var priceLarge = 19000;
            var priceJumbo = 25000;

            var totalPayment = (saladBuahKecil * priceSmall) + (saladBuahSedang * priceMedium) + (saladBuahBesar * priceLarge) + (saladBuahJumbo * priceJumbo);

            document.getElementById('totalPayment').value = totalPayment;
        }

        document.getElementById('saladBuah_kecil').addEventListener('input', calculateTotalPayment);
        document.getElementById('saladBuah_sedang').addEventListener('input', calculateTotalPayment);
        document.getElementById('saladBuah_besar').addEventListener('input', calculateTotalPayment);
        document.getElementById('saladBuah_jumbo').addEventListener('input', calculateTotalPayment);

        document.getElementById('orderForm').addEventListener('submit', function(event) {
            calculateTotalPayment(); // Ensure total payment is updated before submission
        });
    </script>

</body>
</html>
