<?php
session_start();

$login_status = false;

$show_popup = !isset($_SESSION['visited_before']);
if (isset($_SESSION['username'])) {
    $login_status = true;
    $username = $_SESSION['username'];
}

if (isset($_GET['logout'])) {

    session_destroy();

    header("Location: ../home/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'user' && $password === 'password') {

        $_SESSION['username'] = $username;

        header("Location: ../home/index.php");
        exit;
    } else {

        $error = "Username atau password salah!";
    }
}
$_SESSION['visited_before'] = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page with Background Image</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <style>
        .zoom-button {
            background-color: #f6e05e;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .zoom-button:hover {
            transform: scale(1.1);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .navbar-bg {
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-bg.scrolled {
            background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
        }

        .mobile-nav {
            background-color: #fda085;
            color: white;
        }

        .mobile-nav a {
            color: white;
        }

        .nav-item {
            transition: transform 0.3s ease;
        }

        .nav-item:hover {
            transform: scale(1.1);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 10;
            right: 0;
            top: 100%;
            min-width: 120px;
            transition: all 0.3s ease;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
            color: white;
            font-size: larger;
        }

        .dropdown-menu a:hover {
            background-color: rgb(115 115 115);
        }

        .mobile-menu-button {
            color: black;
            font-weight: bold;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #fda085;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 50;
        }

        .mobile-menu.active {
            display: flex;
        }

        .mobile-menu a {
            padding: 15px;
            font-size: 18px;
        }

        @keyframes fall-in {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-left {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-bottom {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .slide-in-left {
            animation: slide-in-left 1s ease-out;
        }

        .slide-in-right {
            animation: slide-in-right 1s ease-out;
        }

        .slide-in-bottom {
            animation: slide-in-bottom 1s ease-out;
        }

        .fall-in {
            animation: fall-in 1s ease-out;
        }

        .welcome-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .popup-content {
            background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
            padding: 20px;
            border-radius: 8px;
            max-width: 80%;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            animation: slide-in-bottom 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .popup-content h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #fff;
        }

        .popup-content p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .popup-content button {
            background-color: #686D76;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .popup-content button:hover {
            background-color: #fff;
            color: #000;
        }

        @keyframes slide-in-bottom {
            from {
                transform: translateY(50%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition duration-300 ease-in-out navbar-bg" style="background-color: transparent;">
        <div class="max-w-7xl mx-auto px-1 py-1">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center py-5 px-2">
                        <a href="#" class="flex items-center">
                            <img src="../../assets/logohome.png" alt="Logo" class="w-10 h-10 mr-2">
                            <span class="font-bold text-white text-shadow" style="font-size: 20px;">Sabu</span>
                        </a>
                    </div>
                </div>
                <!-- Primary Nav -->
                <div class="hidden md:flex items-center space-x-1 flex-grow justify-center">
                    <a href="./index.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">Beranda</a>
                    <a href="#pengumuman" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">Pengumuman</a>
                    <a href="./produk.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">Buah Kami</a>
                    <a href="./cart.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">Pemesanan</a>
                    <a href="./review.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">Penilaian</a>
                </div>
                <!-- Secondary Nav (User Menu) -->
                <div class="hidden md:flex items-center space-x-1 relative">
                    <?php if ($login_status) : ?>
                        <div class="dropdown">
                            <span class="py-5 px-3 text-white font-bold text-shadow nav-item relative" style="font-size: 20px;">
                                <i class="fas fa-user mr-1"></i><?= htmlspecialchars($username) ?>
                            </span>
                            <div class="dropdown-menu absolute bg-white py-2 mt-2 rounded-md w-48 z-10 shadow-lg">
                                <a href="./profile.php" class="block px-4 py-2 ">Profile</a>
                                <a href="./status.php" class="block px-4 py-2 ">Status Pesanan</a>
                                <a href="?logout=true" class="block w-full text-left py-2 px-4 text-sm text-white">Keluar</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="../user/login.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">
                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                        </a>
                    <?php endif; ?>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <?php if ($login_status) : ?>
                        <div class="flex items-center space-x-1 ml-2">
                            <div class="dropdown">
                                <span class="py-5 px-3 text-white font-bold text-shadow nav-item relative" style="font-size: 20px;">
                                    <i class="fas fa-user mr-1"></i><?= htmlspecialchars($username) ?>
                                </span>
                                <div class="dropdown-menu absolute bg-white py-2 mt-2 rounded-md w-48 z-10 shadow-lg">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profil</a>
                                    <a href="./status.php" class="block px-4 py-2 ">Status Pesanan</a>
                                    <a href="?logout=true" class="block w-full text-left py-2 px-4 text-sm text-white">Keluar</a>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="../user/login.php" class="py-5 px-3 text-white font-bold text-shadow nav-item" style="font-size: 20px;">
                            <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                        </a>
                    <?php endif; ?>
                    <button id="mobile-menu-button" class="mobile-menu-button text-black font-bold">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
<div class="mobile-menu hidden md:hidden absolute bg-gray-800 text-white flex flex-col items-center justify-center space-y-6 z-50 w-full">
    <a href="../Home/index.php" class="py-2 px-4 text-lg">Beranda</a>
    <a href="#pengumuman" class="py-2 px-4 text-lg">Pengumuman</a>
    <a href="./produk.php" class="py-2 px-4 text-lg">Buah Kami</a>
    <a href="./cart.php" class="py-2 px-4 text-lg">Pemesanan</a>
    <a href="./review.php" class="py-2 px-4 text-lg">Penilaian</a>
    <?php if ($login_status) : ?>
        <a href="?logout=true" class="py-2 px-4 text-lg">Keluar</a>
    <?php else : ?>
        <a href="../user/login.php" class="py-2 px-4 text-lg">Masuk</a>
    <?php endif; ?>
</div>
    </nav>
    <section class="bg-cover bg-center h-screen flex items-center" style="background-image: url(../../assets/coba.png);">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight fall-in" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Selamat Datang di Website</h1>
            <h3 class="text-4xl text-white font-bold mt-4 fall-in" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Salad Buah Mas Viko.</h3>
            <a href="./cart.php" class="bg-yellow-400 text-white font-bold py-2 px-4 rounded-lg mt-4 inline-block shadow-md slide-in-bottom zoom-button">Produk Kami</a>
        </div>
    </section>
    <section id="about" class="about bg-gradient-to-r from-pink-400 via-red-400 to-yellow-300">
        <div class="max-w-4xl mx-auto px-4 py-8 md:py-12 slide-in-bottom">
            <div class="rounded-lg shadow-lg overflow-hidden bg-white">
                <div class="px-6 py-4" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);"">
                <h1 class=" text-2xl font-bold text-white">Tentang Kami</h1>
                    <p class="text-md mt-1 text-white">Ayoo lihat semua tentang website ini.</p>
                </div>
                <div class="p-6 md:flex md:items-center md:justify-between">
                    <div class="md:w-1/2">
                        <img src="../../assets/wallpaper.png" alt="About Us" class="rounded-lg shadow-md mx-auto md:mx-0">
                    </div>
                    <div class="md:w-1/2 md:px-6 mt-6 md:mt-0">
                        <h2 class="text-xl font-semibold mb-2">Website Salad Buah Mas Viko</h2>
                        <p class="text-gray-700 leading-relaxed">
                            Website ini merupakan website salad buah yang dibuat untuk mempermudah pelanggan dalam memesan dan memilih salad buah, di website ini kami memberi kemudahan untuk pelanggan dari informasi sampai pemesanan serta pembayaran yang mudah juga merupakan prioritas kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-12 bg-gradient-to-r from-pink-400 via-red-400 to-yellow-300">
        <h1 class="text-5xl text-white text-center mb-9">Servis Kami</h1>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-center items-center h-48">
                        <img src="../../assets/s1.png" alt="Card image" class="w-36 h-36 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">Aman dan Mudah</h3>
                        <p class="text-gray-700 mb-4">Pemesanan yang dilakukan sangat mudah dan produk yang dipesan akan terjamin keamanan dan kualitasnya sampai ke pelanggan.</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-center items-center h-48">
                        <img src="../../assets/s2.png" alt="Card image" class="w-36 h-36 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">Cepat dan Terjamin</h3>
                        <p class="text-gray-700 mb-4">Pengiriman yang kami lakukan akan secepat mungkin selambat - lambatnya 1 hari setelah pemesanan salad buah.</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-center items-center h-48">
                        <img src="../../assets/s3.png" alt="Card image" class="w-36 h-36 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">Sampai</h3>
                        <p class="text-gray-700 mb-4">Ketika sampai, pelanggan dapat memberi penilaian terhadap website ini sesuai dengan apa yang dirasakan pelanggan tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="pengumumanModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 transform transition-transform duration-300 ease-in-out scale-95">
            <div class="border-b px-4 py-2 flex justify-between items-center bg-gradient-to-r from-pink-400 via-red-400 to-yellow-300">
                <h5 class="text-lg font-semibold text-white">Pengumuman</h5>
                <button id="closeModal" class="text-white hover:text-gray-300">&times;</button>
            </div>
            <div class="p-4">
                <p class="font-serif text-lg leading-relaxed"><?php echo file_get_contents("../admin/pengumuman.txt"); ?></p>
            </div>
        </div>
    </div>
    <footer class="text-center pt-5" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
        <div class="max-w-6xl m-auto text-gray-800 flex flex-wrap justify-center pt-5">
            <div class="p-5 w-1/2 sm:w-4/12 md:w-4/12">
                <div class="text-xs uppercase text-black font-bold mb-6">
                    Alamat
                </div>
                <p class="text-white font-medium">JL. Rama Raya No.2 Perumnas 2 Kota Tangerang</p>
                <p class="text-white font-medium">Cibodas, Cibodas Baru, 15138</p>
            </div>
            <div class="p-5 w-1/2 sm:w-4/12 md:w-4/12">
                <div class="text-xs uppercase text-black font-bold mb-6">
                    Kontak
                </div>
                <a href="https://api.whatsapp.com/send/?phone=085710847277&text&type=phone_number&app_absent=0" class="my-3 block text-white font-medium">Whatsapp</a>
                <a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox" class="my-3 block text-white font-medium">Email</a>
            </div>
            <div class="p-5 w-1/2 sm:w-4/12 md:w-4/12">
                <div class="text-xs uppercase text-black font-bold mb-6">
                    Media Sosial
                </div>
                <a href="https://www.facebook.com/profile.php?id=100084065671347&locale=id_ID" rel="noreferrer noopener nofollow" target="_blank" class="pl-4 text-white font-medium">
                    <i class="fab fa-facebook"></i> Facebook
                </a> <br>
                <a href="https://www.tiktok.com/@ordinaryyclown" rel="noreferrer noopener nofollow" target="_blank" class="pl-4 text-white font-medium">
                    <i class="fab fa-tiktok"></i> Tiktok
                </a> <br>
                <a href="https://www.instagram.com/viko_saputro/" rel="noreferrer noopener nofollow" target="_blank" class="pl-4 text-white font-medium">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
        </div>
        <div class="pt-5 mt-8 border-t border-gray-800 text-center">
            <div class="flex flex-col items-center">
                <div class="sm:w-2/3 text-center py-6">
                    <p class="text-sm text-white font-bold mb-2">
                        © 2024 Sabu Mas Viko.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <?php if ($show_popup) : ?>
        <div class="welcome-popup" id="welcome-popup">
            <div class="popup-content">
                <h2>:)</h2>
                <p>Terima kasih telah mengunjungi website kami.</p>
                <button id="close-popup">Tutup</button>
            </div>
        </div>
    <?php endif; ?>
    <script>
        const navbar = document.getElementById('navbar');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        window.onscroll = function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('active');
        });

        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        document.addEventListener('DOMContentLoaded', function() {
            const closePopupButton = document.getElementById('close-popup');
            const welcomePopup = document.getElementById('welcome-popup');

            closePopupButton.addEventListener('click', function() {
                welcomePopup.style.opacity = '0';
                setTimeout(() => {
                    welcomePopup.style.pointerEvents = 'none';
                }, 300);
            });

            setTimeout(() => {
                welcomePopup.style.opacity = '1';
                welcomePopup.style.pointerEvents = 'auto';
            }, 500);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const pengumumanButton = document.querySelector('a[href="#pengumuman"]');
            const pengumumanModal = document.getElementById('pengumumanModal');
            const closeModal = document.getElementById('closeModal');

            if (pengumumanButton) {
                pengumumanButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    pengumumanModal.classList.remove('hidden');
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', function() {
                    pengumumanModal.classList.add('hidden');
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target === pengumumanModal) {
                    pengumumanModal.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>