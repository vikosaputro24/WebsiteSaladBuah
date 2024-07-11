<?php
require '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $telepon = trim($_POST["telepon"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($fullname) || empty($username) || empty($telepon) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        $query_sql = $conn->prepare("INSERT INTO tb_loginuser (user_id, fullname, username, telepon, email, password) VALUES (UUID(), ?, ?, ?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
        $query_sql->bind_param("sssss", $fullname, $username, $telepon, $email, $hashed_password);

        if ($query_sql->execute()) {
            $query_sql->close();
            $conn->close();
            header("Location: login.php");
            exit;
        } else {
            echo "Pendaftaran Gagal: " . $query_sql->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .custom-input {
            padding: 0.5rem;
            border: none;
            border-radius: 0.375rem;
        }

        .custom-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(253, 160, 133, 0.25);
        }
    </style>
</head>

<body class="min-h-screen flex justify-center items-center" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="container">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="bg-white card rounded-lg shadow-md animate__animated animate__fadeInDown">
                    <div class="text-white rounded-t-lg py-4 text-center" style="background-color: #fda085;">
                        <h3><i class="fas fa-user-plus"></i> Ayo Daftar !</h3>
                    </div>
                    <div class="px-6 py-8">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="fullname" class="block mb-1" style="color: #fda085;"><i class="fas fa-user-tie"></i> Nama Lengkap</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="fullname" aria-describedby="fullnameHelp" placeholder="Masukkan Nama Lengkap Anda">
                            </div>
                            <div class="mb-4">
                                <label for="username" class="block mb-1" style="color: #fda085;"><i class="fas fa-user"></i> Nama Pengguna</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="username" aria-describedby="fullnameHelp" placeholder="Masukkan Nama Pengguna Anda">
                            </div>
                            <div class="mb-4">
                                <label for="telepon" class="block mb-1" style="color: #fda085;"><i class="fas fa-phone"></i> Telepon</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="telepon" aria-describedby="teleponHelp" placeholder="Masukkan Nomor Telepon Anda">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-1" style="color: #fda085;"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="email" aria-describedby="emailHelp" placeholder="Masukkan Email Anda">
                            </div>
                            <div class="mb-4 relative">
                                <label for="password" class="block mb-1" style="color: #fda085;"><i class="fas fa-lock"></i> Kata Sandi</label>
                                <input type="password" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="password" placeholder="Buat Kata Sandi Anda" id="password">
                                <span class="absolute inset-y-0 right-0 pr-3 pt-7 flex items-center">
                                    <i id="togglePassword" class="fas fa-eye cursor-pointer text-gray-400 hover:text-gray-600"></i>
                                </span>
                            </div>
                            <p class="text-center mt-4 mb-4 text-sm">
                                Sudah punya akun? <a href="login.php" style="color: #fda085;">Masuk disini</a>
                            </p>
                            <button type="submit" class="btn-primary w-full border-0 rounded-md py-2 px-4 text-white transition duration-300 hover:bg-yellow-500 hover:border-yellow-500" style="background-color: #fda085;">
                                <i class="fas fa-user-check text-white"></i> Daftar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>