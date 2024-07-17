<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS (for modal) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Additional CSS styles can be added here */
    </style>
</head>
<body class="min-h-screen" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">

    <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">
            <a href="../admin/home.php" class="mr-4">
                <i class="fa-solid fa-backward" style="color: black; text-decoration: none;"></i>
            </a>
            Kelola Produk
        </h1>

        <!-- Form to add new product -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Tambah Produk</h2>
            <form action="manage.php" method="POST" class="space-y-2">
                <div>
                    <label for="productName" class="block">Nama Produk:</label>
                    <input type="text" id="productName" name="productName" placeholder="Masukkan nama produk ..." class="border rounded px-2 py-1">
                </div>
                <div>
                    <label for="stock" class="block">Stok:</label>
                    <input type="text" id="stock" name="stock" placeholder="Masukkan stok produk ..." class="border rounded px-2 py-1">
                </div>
                <div>
                    <label for="price" class="block">Harga:</label>
                    <input type="text" id="price" name="price" placeholder="Masukkan harga produk ..." class="border rounded px-2 py-1">
                </div>
                <div>
                    <button type="submit" name="addProduct" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"><i class="fa-solid fa-plus mr-3"></i>Tambah</button>
                </div>
            </form>
        </div>

        <!-- Display existing products -->
        <div >
            <h2 class="text-xl font-semibold mb-2">Produk Salad Buah Mas Viko</h2>
            <table class="border-collapse border border-gray-200 w-full" >
                <thead>
                    <tr style="background-color:#fda085;">
                        <th class="border border-white text-white text-center px-4 py-2">ID</th>
                        <th class="border border-white text-white text-center px-4 py-2">Nama Produk</th>
                        <th class="border border-white text-white text-center px-4 py-2">Stok</th>
                        <th class="border border-white text-white text-center px-4 py-2">Harga</th>
                        <th class="border border-white text-white text-center px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root"; 
                    $password = ""; 
                    $dbname = "db_sabu"; 
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    if (isset($_POST['addProduct'])) {
                        $productName = $_POST['productName'];
                        $stock = $_POST['stock'];
                        $price = $_POST['price'];
                        $sql = "INSERT INTO products (product_name, stock, price) VALUES ('$productName', '$stock', '$price')";
                        if ($conn->query($sql) === TRUE) {
                            echo "Product added successfully.";
                            header("refresh:1; url=manage.php");
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    if (isset($_GET['delete'])) {
                        $id = $_GET['delete'];
                        $sql_delete = "DELETE FROM products WHERE id=$id";
                        if ($conn->query($sql_delete) === TRUE) {
                            echo "Product deleted successfully.";
                            header("refresh:1; url=manage.php");
                        } else {
                            echo "Error deleting record: " . $conn->error;
                        }
                    }
                    if (isset($_POST['updateProduct'])) {
                        $edit_id = $_POST['edit_id'];
                        $edit_productName = $_POST['edit_productName'];
                        $edit_stock = $_POST['edit_stock'];
                        $edit_price = $_POST['edit_price'];
                        $sql_update = "UPDATE products SET product_name='$edit_productName', stock='$edit_stock', price='$edit_price' WHERE id=$edit_id";
                        if ($conn->query($sql_update) === TRUE) {
                            echo "Product updated successfully.";
                            header("refresh:1; url=manage.php");
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                    }
                    $sql_select = "SELECT * FROM products";
                    $result = $conn->query($sql_select);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border text-center px-4 py-2'>" . $row["id"] . "</td>";
                            echo "<td class='border text-center px-4 py-2'>" . $row["product_name"] . "</td>";
                            echo "<td class='border text-center px-4 py-2'>" . $row["stock"] . "</td>";
                            echo "<td class='border text-center px-4 py-2'>" . $row["price"] . "</td>";
                            echo "<td class='border text-center px-4 py-2'>";
                            echo "<button class='bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded' data-toggle='modal' data-target='#editModal_" . $row["id"] . "'>Ubah</button>";
                            echo "<a href='manage.php?delete=" . $row["id"] . "' class='ml-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<div class='modal fade' id='editModal_" . $row["id"] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel_" . $row["id"] . "' aria-hidden='true'>";
                            echo "<div class='modal-dialog' role='document'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<h5 class='modal-title' id='editModalLabel_" . $row["id"] . "'>Ubah Produk</h5>";
                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                            echo "<span aria-hidden='true'>&times;</span>";
                            echo "</button>";
                            echo "</div>";
                            echo "<div class='modal-body'>";
                            echo "<form action='manage.php' method='POST'>";
                            echo "<input type='hidden' name='edit_id' value='" . $row["id"] . "'>";
                            echo "<div class='mb-3'>";
                            echo "<label for='edit_productName_" . $row["id"] . "' class='form-label'>Nama Produk:</label>";
                            echo "<input type='text' class='form-control' id='edit_productName_" . $row["id"] . "' name='edit_productName' value='" . $row["product_name"] . "'>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<label for='edit_stock_" . $row["id"] . "' class='form-label'>Stok:</label>";
                            echo "<input type='number' class='form-control' id='edit_stock_" . $row["id"] . "' name='edit_stock' value='" . $row["stock"] . "'>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<label for='edit_price_" . $row["id"] . "' class='form-label'>Harga:</label>";
                            echo "<input type='text' class='form-control' id='edit_price_" . $row["id"] . "' name='edit_price' value='" . $row["price"] . "'>";
                            echo "</div>";
                            echo "<button type='submit' name='updateProduct' class='btn btn-primary'>Simpan</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='border border-gray-200 px-4 py-2 text-center'>No products found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Bootstrap JS (for modal) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
</body>
</html>
