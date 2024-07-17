<?php
session_start();
require '../../koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/profile.css">
    <style>
        body {
            background-image: url('./assets/p.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-header {
            background-color: #686D76;
            color: white;
            padding: 30px 0;
            text-align: center;
            border-bottom: 5px solid #484B52;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            cursor: pointer;
        }

        .profile-content {
            margin-top: 20px;
        }

        .profile-info {
            background-color: #fda085; /* Warna background card */
            color: white; /* Warna teks */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-info h3 {
            border-bottom: 2px solid #686D76;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #686D76;
        }

        .profile-info .form-label {
            font-weight: bold;
            color: #484B52;
        }

        .btn-primary {
            background-color: #484B52;
            border-color: #484B52;
        }

        .btn-primary:hover {
            background-color: #686D76;
            border-color: #686D76;
        }

        .btn-success {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .btn-success:hover {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }

        .btn-secondary {
            background-color: #7f8c8d;
            border-color: #7f8c8d;
        }

        .btn-secondary:hover {
            background-color: #95a5a6;
            border-color: #95a5a6;
        }
    </style>
</head>
<body class="min-h-screen" style="display: flex; justify-content: center; align-items: center; height: 100vh; background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <!-- Profile Content -->
    <div class="container profile-content">
        <div class="row justify-content-center">
            <div class="col-md-8 mx-auto">
                <div class="profile-info">
                    <h3 class="text-white">Profil Saya</h3>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM tb_loginUser WHERE email = '$email'");
                    if ($row = mysqli_fetch_object($result)) {
                    ?>
                        <form action="updateProfile.php" method="POST">
                            <div class="mb-3">
                                <label for="fullname" class="form-label text-white">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" value="<?php echo $row->fullname; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label text-white">Nama Pengguna</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $row->username; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label text-white">Nomor Telepon</label>
                                <input type="text" class="form-control" name="telepon" value="<?php echo $row->telepon; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $row->email; ?>" readonly>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-warning" onclick="location.href='./index.php'">Kembali</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-info" id="editButton">Ubah</button>
                                    <button type="submit" class="btn btn-success d-none" id="saveButton">Simpan</button>
                                    <button type="button" class="btn btn-secondary d-none" id="cancelButton">Batal</button>
                                </div>
                            </div>
                        </form>
                    <?php
                    } else {
                        echo "Data not found.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("editButton").addEventListener("click", function() {
            document.querySelectorAll('input[readonly]').forEach(input => {
                input.removeAttribute('readonly');
            });
            document.getElementById("editButton").classList.add("d-none");
            document.getElementById("saveButton").classList.remove("d-none");
            document.getElementById("cancelButton").classList.remove("d-none");
        });

        document.getElementById("cancelButton").addEventListener("click", function() {
            document.querySelectorAll('input:not([name="email"])').forEach(input => {
                input.setAttribute('readonly', true);
            });
            document.getElementById("editButton").classList.remove("d-none");
            document.getElementById("saveButton").classList.add("d-none");
            document.getElementById("cancelButton").classList.add("d-none");
        });
    </script>

</body>

</html>
