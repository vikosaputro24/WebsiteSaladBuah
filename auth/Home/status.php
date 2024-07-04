<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit();
}

include '../../koneksi.php';

$user_id = $_SESSION['user_id']; 

$sql = "SELECT fullname, telepon, email FROM tb_loginuser WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $telepon, $email);
$stmt->fetch();
$stmt->close();

$sql_payment = "SELECT orders_id, date, fullname, telepon, email, totalPayment, paymentMethod, proofOfPayment, status FROM orders WHERE email = ?";
$stmt_payment = $conn->prepare($sql_payment);
$stmt_payment->bind_param("s", $email);
$stmt_payment->execute();
$result_payment = $stmt_payment->get_result();
$payments = $result_payment->fetch_all(MYSQLI_ASSOC);
$stmt_payment->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            white-space: nowrap;
            max-height: 400px; 
        }
        .table-container::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background-color: #FFA500; 
            border-radius: 6px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background-color: #FF8C00; 
        }
        .table-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 6px;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 py-12" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Status Pembayaran</h1>
        <div class="table-container bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($payments as $payment) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['orders_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($fullname); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($telepon); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($email); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['totalPayment']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['paymentMethod']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $payment['status'] == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo htmlspecialchars($payment['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($payment['proofOfPayment']) : ?>
                                    <a href="uploads/<?php echo htmlspecialchars($payment['proofOfPayment']); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat Bukti</a>
                                <?php else : ?>
                                    <span class="text-gray-500">Tidak ada bukti pembayaran</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="invoice.php?orders_id=<?php echo htmlspecialchars($payment['orders_id']); ?>" class="text-indigo-600 hover:text-indigo-900">Lihat Invoice</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
