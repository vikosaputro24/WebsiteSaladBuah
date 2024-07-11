<?php
session_start(); 

include '../../koneksi.php'; 

$search_query = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

$sql = "SELECT order_id, fullname, telepon, email, wilayah, address, total_payment, payment_method, proof_of_payment, orderDetails, order_date, status FROM tb_orders";
if (!empty($search_query)) {
    $sql .= " WHERE order_id LIKE '%$search_query%' OR fullname LIKE '%$search_query%' OR order_date LIKE '%$search_query%' OR telepon LIKE '%$search_query%' OR email LIKE '%$search_query%'";
}
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];

        $update_sql = "UPDATE tb_orders SET status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();

        header('Location: statusAdmin.php');
        exit();
    } elseif (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        $delete_sql = "DELETE FROM tb_orders WHERE order_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        header('Location: statusAdmin.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Status Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #fff;
        }
        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            white-space: nowrap;
            max-height: 400px; /* Adjust this value as needed */
        }
        .table-container::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background-color: #FFA500; /* Orange */
            border-radius: 6px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background-color: #FF8C00; /* Darker Orange */
        }
        .table-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 6px;
        }
        .bg-orange-500 {
            background-color: #FFA500; /* Orange */
        }
        .hover\\:bg-orange-700:hover {
            background-color: #FF8C00; /* Darker Orange */
        }
        .text-orange-500 {
            color: #FFA500; /* Orange */
        }
    </style>
</head>
<body class="min-h-screen py-12" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin - Status Pembayaran</h1>
        <div class="card">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-6">
                <input type="text" name="search_query" placeholder="Cari pesanan ? ..." value="<?php echo htmlspecialchars($search_query); ?>" class="border rounded px-4 py-2 w-full">
                <button type="submit" name="search" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mt-2"><i class="fa-solid fa-magnifying-glass mr-3"></i>Cari</button>
            </form>
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['order_id']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['telepon']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['total_payment']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['order_date']); ?></td>
                                <td class="px-4 py-2">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['order_id']); ?>">
                                        <select name="new_status" class="border rounded px-2 py-1">
                                            <option value="Sedang di proses" <?php echo ($row['status'] === 'Sedang di proses') ? 'selected' : ''; ?>>Sedang di proses</option>
                                            <option value="Pembayaran di terima" <?php echo ($row['status'] === 'Pembayaran di terima') ? 'selected' : ''; ?>>Pembayaran di terima</option>
                                            <option value="Pesanan sedang di buat" <?php echo ($row['status'] === 'Pesanan sedang di buat') ? 'selected' : ''; ?>>Pesanan sedang di buat</option>
                                            <option value="Pesanan sedang di kirim" <?php echo ($row['status'] === 'Pesanan sedang di kirim') ? 'selected' : ''; ?>>Pesanan sedang di kirim</option>
                                            <option value="Pesanan sudah diterima" <?php echo ($row['status'] === 'Pesanan sudah diterima') ? 'selected' : ''; ?>>Pesanan sudah diterima</option>
                                        </select>
                                        <button type="submit" name="update_status" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded ml-2">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-2">
                                    <?php if ($row['proof_of_payment']) : ?>
                                        <a href="<?php echo htmlspecialchars($row['proof_of_payment']); ?>" target="uploads/" class="text-orange-500 hover:underline">Lihat Bukti</a>
                                    <?php else : ?>
                                        <span class="text-gray-500">Tidak ada bukti pembayaran</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['order_id']); ?>">
                                        <button type="submit" name="delete_order" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <button onclick="window.history.back()" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mt-4"><i class="fa-solid fa-arrow-left mr-3"></i>Kembali</button>
        </div>
    </div>
</body>
</html>
