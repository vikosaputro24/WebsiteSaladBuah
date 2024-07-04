<?php
require '../../koneksi.php';

session_start();

if (!isset($_SESSION['adminname'])) {
    header('Location: login.php');
    exit();
}

$adminname = $_SESSION['adminname'];

// Tambahkan query untuk mengambil data dari tabel orders
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM orders WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR telepon LIKE '%$search%'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM orders WHERE id = $id";
    mysqli_query($conn, $deleteQuery);
    header('Location: pemesananAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Salad Buah Mas Viko</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .carousel-container {
            max-width: 100%;
            overflow: hidden;
        }

        .carousel-container .carousel-item {
            display: none;
        }

        .carousel-container .carousel-item.active {
            display: block;
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col sm:flex-row">
    <aside class="sidebar bg-gray-800 text-gray-100 shadow-md h-screen fixed sm:relative transform -translate-x-full sm:translate-x-0 transition-transform duration-200">
        <div class="p-6 border-b border-gray-700 flex items-center justify-center">
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
                <div id="dropdownMenu" class="hidden bg-gray-700 text-gray-200 mt-1 rounded-md shadow-lg z-10">
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
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
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

        <div id="mobile-menu" class="hidden bg-white shadow-md">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Home</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">About</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Services</a>
            <a href="#" class="block  py-2 px-4 text-gray-600 hover:bg-gray-100">Contact</a>
        </div>

        <main class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold">Daftar Pesanan</h2>
                <form method="GET" class="flex">
                    <input type="text" name="search" placeholder="Cari pesanan..." value="<?php echo htmlspecialchars($search); ?>" class="px-4 py-2 border rounded">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded ml-2">Cari</button>
                </form>
            </div>
            <div class="carousel-container">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="carousel-item bg-white p-4 mb-4 rounded shadow">
                        <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
                        <p><strong>Nama:</strong> <?php echo $row['name']; ?></p>
                        <p><strong>Telepon:</strong> <?php echo $row['telepon']; ?></p>
                        <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                        <p><strong>Alamat:</strong> <?php echo $row['alamat']; ?></p>
                        <p><strong>Kota:</strong> <?php echo $row['city']; ?></p>
                        <p><strong>Kode Pos:</strong> <?php echo $row['kodePos']; ?></p>
                        <p><strong>Tanggal Pesan:</strong> <?php echo $row['orderDate']; ?></p>
                        <p><strong>Produk:</strong> <?php echo $row['products']; ?></p>
                        <p><strong>Ukuran:</strong> <?php echo $row['ukuran']; ?></p>
                        <p><strong>Banyak:</strong> <?php echo $row['banyak']; ?></p>
                        <p><strong>Total Pembayaran:</strong> <?php echo $row['total_pembayaran']; ?></p>
                        <p><strong>Metode Pembayaran:</strong> <?php echo $row['paymentMethod']; ?></p>
                        <p><strong>Bukti Pembayaran:</strong> <?php echo $row['payment_proof']; ?></p>
                        <div class="actions mt-2">
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="edit" class="text-blue-500 hover:text-blue-700"><i class='fas fa-pencil-alt'></i></button>
                            </form>
                            <form method="POST" style="display:inline;" class="delete-form">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="button" name="delete" class="text-red-500 hover:text-red-700 delete-button"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="flex justify-between mt-4">
                <button class="carousel-prev px-4 py-2 bg-gray-600 text-white rounded">Prev</button>
                <button class="carousel-next px-4 py-2 bg-gray-600 text-white rounded">Next</button>
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

        let currentSlide = 0;
        let slides = document.querySelectorAll('.carousel-item');
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');

        function updateSlides() {
            slides = document.querySelectorAll('.carousel-item');
        }

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        prevButton.addEventListener('click', () => {
            currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
            showSlide(currentSlide);
        });

        nextButton.addEventListener('click', () => {
            currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
            showSlide(currentSlide);
        });

        showSlide(currentSlide);
    </script>
</body>

</html>