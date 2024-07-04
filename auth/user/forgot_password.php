<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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

<body class="min-h-screen" style="display: flex; justify-content: center; align-items: center; height: 100vh; background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md animate__animated animate__fadeInDown">
                    <div class="text-white rounded-t-lg py-4 text-center" style="background-color: #fda085;">
                        <h3><i class="fas fa-sign-in-alt"></i> Lupa Password ?</h3>
                    </div>
                    <div class="px-6 py-8">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="email" class="block mb-1" style="color: #fda085;"><i class="fas fa-envelope"></i> Masukkan Email Anda</label>
                                <input type="email" class="form-input rounded-md w-full custom-input" name="email" aria-describedby="email" placeholder="Masukkan Email Anda" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block mb-1" style="color: #fda085;"><i class="fas fa-lock"></i> Masukkan Password Baru Anda</label>
                                <input type="password" class="form-input rounded-md w-full custom-input" name="password" aria-describedby="password" placeholder="Masukkan Password Baru Anda" required>
                            </div>
                            <button type="submit" class="btn-primary w-full border-0 rounded-md py-2 px-4 text-white transition duration-300 hover:bg-yellow-500 hover:border-yellow-500" style="background-color: #fda085;">
                                <i class="fas fa-sign-in-alt text-white"></i> Kirim
                            </button>
                            <p class="text-center mt-4 mb-4 text-sm">
                                Sudah ganti password? <a href="../user/login.php" style="color: #fda085;">Login disini</a>
                            </p>

                        </form>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['email']) && isset($_POST['password'])) {
                                $email = $_POST['email'];
                                $password = $_POST['password'];

                                // Koneksi ke database
                                $conn = new mysqli('localhost', 'root', '', 'db_sabu');

                                // Cek koneksi
                                if ($conn->connect_error) {
                                    die("Koneksi gagal: " . $conn->connect_error);
                                }

                                // Update password
                                $sql = "UPDATE tb_loginuser SET password = ? WHERE email = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('ss', $password, $email);

                                if ($stmt->execute()) {
                                    echo "<p class='text-green-500 text-center mt-4'>Password berhasil diubah.</p>";
                                } else {
                                    echo "<p class='text-red-500 text-center mt-4'>Gagal mengubah password.</p>";
                                }

                                $stmt->close();
                                $conn->close();
                            } else {
                                echo "<p class='text-red-500 text-center mt-4'>Email dan password harus diisi.</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>