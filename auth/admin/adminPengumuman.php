<?php
require '../../koneksi.php';

session_start();

if (!isset($_SESSION['adminname'])) {
    header('Location: login.php');
    exit();
}

$adminname = $_SESSION['adminname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST["pengumuman_content"];
    file_put_contents("pengumuman.txt", $content);
    updateIndexPengumuman($content);
    exit;
}

function updateIndexPengumuman($content)
{
    $indexFilePath = "../index.php";
    $indexFileContent = file_get_contents($indexFilePath);
    $updatedContent = preg_replace("/<p>(.*?)<\/p>/", "<p>$content</p>", $indexFileContent);
    file_put_contents($indexFilePath, $updatedContent);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pengumuman</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <form id="pengumumanForm" method="POST" onsubmit="return updatePengumuman()" class="w-full p-8 rounded-lg shadow-lg flex flex-col space-y-6" style="background-color: #fda085;">
                <h1 class="text-center text-3xl font-extrabold text-white">Admin Pengumuman</h1>
                <div class="flex flex-col space-y-2">
                    <label for="pengumuman_content" class="text-lg font-semibold text-white">Pengumuman:</label>
                    <textarea name="pengumuman_content" id="pengumuman_content" rows="6" class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical" placeholder="Masukkan pengumuman Anda di sini"><?php echo htmlspecialchars(file_get_contents("pengumuman.txt")); ?></textarea>
                </div>
                <div class="flex flex-col space-y-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white py-3 rounded-lg hover:from-green-500 hover:to-green-700 transition duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan perubahan</span>
                    </button>
                    <a href="../admin/home.php" class="w-full bg-gradient-to-r from-gray-400 to-gray-600 text-white py-3 rounded-lg hover:from-gray-500 hover:to-gray-700 transition duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </form>

            <!-- Modal -->
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <h2 class="text-2xl font-bold mb-4">Pengumuman Berhasil Disimpan</h2>
                    <p class="mb-4">Pengumuman Anda telah berhasil disimpan.</p>
                    <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300" onclick="closeModal()">Tutup</button>
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

        function updatePengumuman() {
            var form = document.getElementById("pengumumanForm");
            var formData = new FormData(form);

            fetch('adminPengumuman.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('successModal').classList.remove('hidden');
                        return true;
                    } else {
                        return false;
                    }
                })
                .catch(error => console.error('Error:', error));

            return false;
        }

        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
            window.location.href = 'home.php';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>