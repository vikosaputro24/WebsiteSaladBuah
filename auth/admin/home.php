<?php
require '../../koneksi.php';

session_start();

if (!isset($_SESSION['adminname'])) {
    header('Location: login.php');
    exit();
}

$adminname = $_SESSION['adminname'];

// Query untuk mengambil jumlah total admin yang terdaftar
$query_total_admin = "SELECT COUNT(*) as total_admin FROM tb_loginadmin";
$result_total_admin = $conn->query($query_total_admin);
$row_total_admin = $result_total_admin->fetch_assoc();
$total_admin = $row_total_admin['total_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $telepon = trim($_POST["telepon"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"]; // Password tidak di-hash

    // Validate input
    if (empty($fullname) || empty($username) || empty($telepon) || empty($email) || empty($password)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $query_sql = $conn->prepare("INSERT INTO tb_loginadmin (fullname, username, telepon, email, password) VALUES (?, ?, ?, ?, ?)");
    $query_sql->bind_param("sssss", $fullname, $username, $telepon, $email, $password);

    if ($query_sql->execute()) {
        $query_sql->close();
        $conn->close();
        header("Location: login.php");
        exit;
    } else {
        echo "Pendaftaran Gagal: " . $query_sql->error;
    }
}

$query_total_user = "SELECT COUNT(*) as total_user FROM tb_loginuser";
$result_total_user = $conn->query($query_total_user);
$row_total_user = $result_total_user->fetch_assoc();
$total_user = $row_total_user['total_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $telepon = trim($_POST["telepon"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"]; // Password tidak di-hash

    // Validate input
    if (empty($fullname) || empty($username) || empty($telepon) || empty($email) || empty($password)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $query_sql = $conn->prepare("INSERT INTO tb_loginuser (fullname, username, telepon, email, password) VALUES (?, ?, ?, ?, ?)");
    $query_sql->bind_param("sssss", $fullname, $username, $telepon, $email, $password);

    if ($query_sql->execute()) {
        $query_sql->close();
        $conn->close();
        header("Location: login.php");
        exit;
    } else {
        echo "Pendaftaran Gagal: " . $query_sql->error;
    }
}

$query_total_pesan = "SELECT COUNT(*) as total_pesan FROM orders";
$result_total_pesan = $conn->query($query_total_pesan);
$row_total_pesan = $result_total_pesan->fetch_assoc();
$total_pesan = $row_total_pesan['total_pesan'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $city = $_POST['city'];
    $kodePos = $_POST['kodePos'];
    $orderDate = $_POST['orderDate'];
    $ukuran = $_POST['ukuran'];
    $banyak = $_POST['banyak'];
    $total_pembayaran = $_POST['total_pembayaran'];
    $paymentMethod = $_POST['paymentMethod'];

    // Validate input
    if (empty($name) || empty($telepon) || empty($email) || empty($alamat) || empty($city) || empty($kodePos) || empty($orderDate) || empty($ukuran) || empty($banyak) || empty($total_pembayaran) || empty($paymentMethod)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $query_sql = $conn->prepare("INSERT INTO orders (name, telepon, email, alamat, city, kodePos, orderDate, ukuran, banyak, total_pembayaran, paymentMethod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query_sql->bind_param("sssssssssss", $name, $telepon, $email, $alamat, $city, $kodePos, $orderDate, $ukuran, $banyak, $total_pembayaran, $paymentMethod);

    if ($query_sql->execute()) {
        $query_sql->close();
        $conn->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Pemesanan Gagal: " . $query_sql->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home with Side Navbar - Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media (min-width: 640px) {
            .sidebar {
                min-width: 16rem;
            }
        }

        .textFirst {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        #dropdownMenu {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col sm:flex-row">
    <aside class="sidebar bg-gray-800 text-gray-100 shadow-md h-screen fixed sm:relative transform -translate-x-full sm:translate-x-0 transition-transform duration-200">
        <div class="p-6 border-b border-white flex items-center justify-center">
            <span class="text-xl font-semibold">Salad Buah Mas Viko</span>
        </div>
        <nav class="mt-6">
            <a href="../admin/home.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                <i class="fas fa-home w-6 h-6 inline-block mr-2"></i>
                Beranda
            </a>
            <div class="relative">
                <button id="dropdownBtn" class="w-full flex justify-between items-center py-4 px-5 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <span class="inline-flex items-center">
                    <i class="fas fa-users w-6 h-6 inline-block mr-4"></i>
                        Data Daftar
                    </span>
                    <i id="dropdownIcon" class="fas fa-chevron-down w-4 h-4 inline-block"></i>
                </button>
                <div id="dropdownMenu" class="hidden bg-gray-700 text-gray-200 mt-1 shadow-lg z-10">
                    <a href="./loginUser.php" class="block py-2 px-6 text-sm font-medium hover:bg-indigo-500 hover:text-white transition-colors duration-200"><i class="fas fa-user w-6 h-6 inline-block mr-2"></i>Sebagai User</a>
                    <a href="./loginAdmin.php" class="block py-2 px-6 text-sm font-medium hover:bg-indigo-500 hover:text-white transition-colors duration-200"><i class="fas fa-user-tie w-6 h-6 inline-block mr-2"></i>Sebagai Admin</a>
                </div>
            </div>
            <div id="otherNavItems">
                <a href="../admin/pemesananAdmin.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fas fa-cart-plus w-6 h-6 inline-block mr-2"></i>
                    Pemesanan
                </a>
                <a href="../admin/adminPengumuman.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fas fa-circle-exclamation w-6 h-6 inline-block mr-2"></i>
                    Pengumuman
                </a>
                <a href="../Home/statusAdmin.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fas fa-circle-exclamation w-6 h-6 inline-block mr-2"></i>
                    Status Pemesanan
                </a>
                <a href="../admin/product_admin.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fas fa-circle-exclamation w-6 h-6 inline-block mr-2"></i>
                    Stok Pemesanan
                </a>
            </div>
        </nav>
    </aside>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <header class="bg-white shadow-md p-4 flex items-center justify-between w-full">
            <button id="hamburger" class="text-gray-500 focus:outline-none focus:text-gray-900 sm:hidden">
                <i class="fas fa-bars w-8 h-8"></i>
            </button>
            <h1 class="text-xl font-semibold text-gray-800">Haloo, <?php echo $adminname; ?></h1>
            <nav class="hidden sm:flex space-x-4">
                <a href="./login.php" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>
                    Keluar
                </a>
            </nav>
        </header>

        <!-- Dropdown Menu for Mobile -->
        <div id="mobile-menu" class=" hidden bg-white shadow-md">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Home</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">About</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Services</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Contact</a>
        </div>

        <main class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow-lg p-8" style="background-color:#f6d365 ;">
                <h1 class="textFirst text-3xl font-bold mb-4 text-white"><?php echo $adminname; ?>👋🏼</h1>
                <h1 class="textFirst text-4xl font-bold mb-4 text-white">Selamat Datang di Admin Salad Buah Mas Viko.</h1>
                <p class="text-gray-700 mb-6">Website ini digunakan untuk mengelola dan memperbaharui data yang ada di website salad buah mas viko.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-indigo-100 p-6 rounded-lg shadow-md flex items-center justify-center" style="background-color: #fda085;">
                        <div class="mr-10">
                            <i class="fas fa-user-tie text-6xl text-black"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-semibold text-white">Daftar Admin</h2>
                            <p class="text-white mb-2">Total admin: <?php echo $total_admin; ?></p>
                            <a href="./loginAdmin.php" class="inline-block bg-gray-600 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50 transition-colors duration-300">
                                <span class="flex items-center">
                                    Lihat Detail
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-indigo-100 p-6 rounded-lg shadow-md flex items-center justify-center" style="background-color: #fda085;">
                        <div class="mr-10">
                            <i class="fas fa-user text-6xl text-black"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-semibold text-white">Daftar User</h2>
                            <p class="text-white mb-2">Total admin: <?php echo $total_user; ?></p>
                            <a href="./loginUser.php" class="inline-block bg-gray-600 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50 transition-colors duration-300">
                                <span class="flex items-center">
                                    Lihat Detail
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="bg-indigo-100 p-6 rounded-lg shadow-md flex items-center justify-center" style="background-color: #fda085;">
                        <div class="mr-10">
                            <i class="fas fa-cart-shopping text-5xl text-black"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-semibold text-white">Daftar Pesan</h2>
                            <p class="text-white mb-2">Total pesanan: <?php echo $total_pesan; ?></p>
                            <a href="./pemesananAdmin.php" class="inline-block bg-gray-600 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50 transition-colors duration-300">
                                <span class="flex items-center">
                                    Lihat Detail
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.querySelector('.sidebar');
        const mobileMenu = document.getElementById('mobile-menu');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mobileMenu.classList.toggle('hidden');
        });

        document.getElementById('dropdownBtn').addEventListener('click', function() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            var otherNavItems = document.getElementById('otherNavItems');
            var dropdownIcon = document.getElementById('dropdownIcon');

            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                otherNavItems.classList.add('mt-15');
                dropdownIcon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                dropdownMenu.classList.add('hidden');
                otherNavItems.classList.remove('mt-15');
                dropdownIcon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    </script>
</body>

</html>