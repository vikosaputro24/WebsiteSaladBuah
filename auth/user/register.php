<?php
require '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $telepon = trim($_POST["telepon"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validate input
    if (empty($fullname) || empty($username) || empty($telepon) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $query_sql = $conn->prepare("INSERT INTO tb_loginuser (user_id, fullname, username, telepon, email, password) VALUES (UUID(), ?, ?, ?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
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
                        <h3><i class="fas fa-user-plus"></i> Ayo Register !</h3>
                    </div>
                    <div class="px-6 py-8">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="fullname" class="block mb-1" style="color: #fda085;"><i class="fas fa-user-tie"></i> Nama Lengkap</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="fullname" aria-describedby="fullnameHelp" placeholder="Masukkan Nama Lengkap Anda">
                            </div>
                            <div class="mb-4">
                                <label for="username" class="block mb-1" style="color: #fda085;"><i class="fas fa-user"></i> Username</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="username" aria-describedby="fullnameHelp" placeholder="Masukkan Username Anda">
                            </div>
                            <div class="mb-4">
                                <label for="telepon" class="block mb-1" style="color: #fda085;"><i class="fas fa-phone"></i> Telepon</label>
                                <input type="text" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="telepon" aria-describedby="teleponHelp" placeholder="Masukkan Nomor Telepon Anda">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-1" style="color: #fda085;"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="email" aria-describedby="emailHelp" placeholder="Masukkan Email Anda">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block mb-1" style="color: #fda085;"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-input rounded-md w-full focus:ring-0 focus:border-yellow-500 custom-input" name="password" placeholder="Buat Password Anda">
                            </div>
                            <p class="text-center mt-4 mb-4 text-sm">
                                Sudah punya akun? <a href="login.php" style="color: #fda085;">Login disini</a>
                            </p>
                            <button type="submit" class="btn-primary w-full border-0 rounded-md py-2 px-4 text-white transition duration-300 hover:bg-yellow-500 hover:border-yellow-500" style="background-color: #fda085;">
                                <i class="fas fa-user-check text-white"></i> Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
        