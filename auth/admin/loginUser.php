<?php
require '../../koneksi.php'; // Sesuaikan dengan path koneksi Anda

session_start();

// Redirect ke halaman login jika adminname tidak tersedia dalam session
if (!isset($_SESSION['adminname'])) {
    header('Location: login.php');
    exit();
}

$adminname = $_SESSION['adminname'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Daftar User</title>
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
                    <i class="fa-solid fa-signal w-6 h-6 inline-block mr-2"></i>
                    Status Pemesanan
                </a>
                <a href="../admin/manage.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-arrow-trend-up w-6 h-6 inline-block mr-2"></i>
                    Stok Pemesanan
                </a>
                <a href="../admin/review_admin.php" class="block py-3 px-6 text-sm font-medium text-gray-200 hover:bg-indigo-500 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-magnifying-glass-dollar w-6 h-6 inline-block mr-2"></i>
                    Penilaian
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
                <a href="./login.php" class="flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>
                    Keluar
                </a>
            </nav>
        </header>

        <!-- Dropdown Menu for Mobile -->
        <div id="mobile-menu" class="hidden bg-white shadow-md">
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Home</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">About</a>
            <a href="#" class="block py-2 px-4 text-gray-600 hover:bg-gray-100">Contact</a>
        </div>

        <!-- Main Content -->
        <main class="p-4">
            <h2 class="text-5xl font-semibold text-gray-800 text-center">
                <i class="fas fa-user"></i> Data Daftar Pengguna
            </h2>

            <div class="mt-4">
                <button id="openModal" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                <i class="fa-solid fa-plus pr-2"></i>Tambah Pengguna
                </button>
                <table class="min-w-full bg-white mt-4">
                    <thead class="text-white uppercase text-sm leading-normal" style="background-color: #fda085;">
                        <tr>
                            <th class="py-3 px-6 text-center">ID</th>
                            <th class="py-3 px-6 text-center">Nama Lengkap</th>
                            <th class="py-3 px-6 text-center">Nama Pengguna</th>
                            <th class="py-3 px-6 text-center">Telepon</th>
                            <th class="py-3 px-6 text-center">Email</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-black text-sm font-light">
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'db_sabu'); 
                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }
                        $sql = "SELECT * FROM tb_loginuser";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($user = $result->fetch_assoc()) {
                                echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                                echo "<td class='py-3 px-6 font-bold text-center'>{$user['user_id']}</td>";
                                echo "<td class='py-3 px-6 font-bold text-center'>{$user['fullname']}</td>";
                                echo "<td class='py-3 px-6 font-bold text-center'>{$user['username']}</td>";
                                echo "<td class='py-3 px-6 font-bold text-center'>{$user['telepon']}</td>";
                                echo "<td class='py-3 px-6 font-bold text-center'>{$user['email']}</td>";
                                echo "<td class='py-3 px-6 text-center'>
                                        <button class='bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600 transition duration-200 edit-btn' data-id='{$user['user_id']}' data-fullname='{$user['fullname']}' data-username='{$user['username']}' data-telepon='{$user['telepon']}' data-email='{$user['email']}' data-password='{$user['password']}'><i class='fas fa-pencil-alt'></i></button>
                                        <button class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition duration-200 delete-btn' data-id='{$user['user_id']}'><i class='fas fa-trash-alt'></i></button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-4'>Tidak ada data</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="rounded-lg shadow-lg p-6 w-full max-w-md" style="background-color: #fda085;">
            <div class="flex justify-between items-center">
                <h2 id="modalTitle" class="text-xl font-bold text-white text-center">Tambah User</h2>
                <button id="closeModal" class="text-gray-600 hover:text-gray-900 transition duration-200">&times;</button>
            </div>
            <form id="modalForm">
                <input type="hidden" id="userId" name="id">
                <input type="hidden" id="action" name="action" value="addUser">
                <div class="mt-4">
                    <label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="fullname" name="fullname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                <div class="mt-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                <div class="mt-4">
                    <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="text" id="telepon" name="telepon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" id="modalSubmit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');
            const modal = document.getElementById('modal');
            const modalForm = document.getElementById('modalForm');
            const modalTitle = document.getElementById('modalTitle');
            const modalSubmit = document.getElementById('modalSubmit');
            const userId = document.getElementById('userId');
            const fullname = document.getElementById('fullname');
            const username = document.getElementById('username');
            const telepon = document.getElementById('telepon');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const action = document.getElementById('action');

            openModalBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modalTitle.textContent = 'Tambah User';
                action.value = 'addUser';
                modalForm.reset();
            });

            closeModalBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    modalTitle.textContent = 'Edit User';
                    action.value = 'editUser';
                    userId.value = this.dataset.id;
                    fullname.value = this.dataset.fullname;
                    username.value = this.dataset.username;
                    telepon.value = this.dataset.telepon;
                    email.value = this.dataset.email;
                    password.value = this.dataset.password;
                });
            });

            modalForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(modalForm);

                fetch('user_action.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                        const formData = new FormData();
                        formData.append('id', this.dataset.id);
                        formData.append('action', 'deleteUser');

                        fetch('user_action.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                alert(data);
                                location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            });
        });

        document.getElementById('dropdownBtn').addEventListener('click', function() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            var otherNavItems = document.getElementById('otherNavItems');
            var dropdownIcon = document.getElementById('dropdownIcon');

            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                otherNavItems.classList.add('mt-15'); // Adjust this value based on the height of your dropdown menu
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