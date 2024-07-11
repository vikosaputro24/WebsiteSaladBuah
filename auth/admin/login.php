<?php
require '../../koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT adminname, email FROM tb_loginadmin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($adminname, $email);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $_SESSION['adminname'] = $adminname;
        $_SESSION['email'] = $email;
        header("Location: ../admin/home.php");
        exit;
    } else {
        echo "<script>
                alert('Email atau kata sandi Anda salah. Silakan coba login kembali.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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

<body class=" min-h-screen" style="display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(90deg, rgba(31,92,181,1) 0%, rgba(0,212,255,1) 100%);">
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md animate__animated animate__fadeInDown">
                    <div class=" text-white rounded-t-lg py-4 text-center" style="background-color: #fda085;">
                        <h3><i class="fas fa-sign-in-alt"></i> Ayo Masuk Sebagai Admin !</h3>
                    </div>
                    <div class="px-6 py-8">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="email" class="block mb-1" style="color: #fda085;"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-input rounded-md w-full custom-input" name="email" aria-describedby="emailHelp" placeholder="Masukkan Email Anda">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block mb-1" style="color: #fda085;"><i class="fas fa-lock"></i> Kata Sandi</label>
                                <input type="password" class="form-input rounded-md w-full custom-input" name="password" placeholder="Masukkan Kata Sandi Anda">
                            </div>
                            <p class="text-center mt-4 mb-4 text-sm">
                                Belum punya akun admin? <a href="../admin/register.php" style="color: #fda085;">Daftar disini</a>
                            </p>
                            <button type="submit" class="btn-primary w-full  border-0 rounded-md py-2 px-4 text-white transition duration-300 hover:bg-yellow-500 hover:border-yellow-500" style="background-color: #fda085;">
                                <i class="fas fa-sign-in-alt text-white"></i> Masuk Sebagai Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>