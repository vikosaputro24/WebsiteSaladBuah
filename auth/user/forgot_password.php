<?php
require '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $new_password = $_POST["new_password"];

    // Update password in the database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE tb_loginuser SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        echo "<script>
                alert('Password berhasil diubah. Silakan login dengan password baru Anda.');
                window.location.href = 'login.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Gagal mengubah password. Silakan coba lagi.');
                window.location.href = 'forgot_password.php';
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
    <title>Forgot Password</title>
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
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md animate__animated animate__fadeInDown">
                    <div class="text-white rounded-t-lg py-4 text-center" style="background-color: #fda085;">
                        <h3><i class="fas fa-lock"></i> Lupa Kata Sandi ?</h3>
                    </div>
                    <div class="px-6 py-8">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="email" class="block mb-1" style="color: #fda085;"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-input rounded-md w-full custom-input" name="email" aria-describedby="emailHelp" placeholder="Masukkan Email Anda" required>
                            </div>
                            <div class="mb-4 relative">
                                <label for="new_password" class="block mb-1" style="color: #fda085;"><i class="fas fa-lock"></i> Kata Sandi Baru</label>
                                <input type="password" class="form-input rounded-md w-full custom-input" name="new_password" placeholder="Masukkan Kata Sandi Baru" id="new_password" required>
                                <span class="absolute inset-y-0 right-0 pr-3 pt-7 flex items-center">
                                    <i id="toggleNewPassword" class="fas fa-eye cursor-pointer text-gray-400 hover:text-gray-600"></i>
                                </span>
                            </div>

                            <button type="submit" class="btn-primary w-full border-0 rounded-md py-2 px-4 text-white transition duration-300 hover:bg-yellow-500 hover:border-yellow-500 bg-orange-400" style="background-color: #fda085;">
                                <i class="fas fa-key text-white"></i> Kata Sandi Baru
                            </button>
                        </form>
                        <p class="text-center mt-4 text-sm">
                            <a href="login.php" class="text-sm" style="color: #fda085;">Kembali ke halaman Masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const toggleNewPassword = document.querySelector('#toggleNewPassword');
        const newPassword = document.querySelector('#new_password');

        toggleNewPassword.addEventListener('click', function() {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>