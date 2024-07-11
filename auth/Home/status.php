<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit();
}

include '../../koneksi.php';

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT fullname, telepon, email FROM tb_loginuser WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $telepon, $email);
$stmt->fetch();
$stmt->close();

// Fetch payment status
$sql_payment = "SELECT order_id, fullname, telepon, email, wilayah, address, total_payment, payment_method, proof_of_payment, order_date, orderDetails, status FROM tb_orders WHERE email = ?";
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
    <!-- Bootstrap CSS (assuming Bootstrap 4 or 5) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        @media print {

            /* Menyembunyikan footer modal saat dicetak */
            .modal-footer {
                display: none !important;
            }
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($payments as $payment) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['order_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['fullname']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['telepon']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['email']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['total_payment']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['orderDetails']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($payment['order_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $payment['status'] == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo htmlspecialchars($payment['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($payment['proof_of_payment']) : ?>
                                    <a href="<?php echo htmlspecialchars($payment['proof_of_payment']); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900">Lihat Bukti</a>
                                <?php else : ?>
                                    <span class="text-gray-500">Tidak ada bukti pembayaran</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Button to trigger modal -->
                                <a href="invoiceModal_" class="text-indigo-600 hover:text-indigo-900 view-invoice" data-toggle="modal" data-target="#invoiceModal_<?php echo htmlspecialchars($payment['order_id']); ?>">Lihat Invoice</a>
                            </td>
                        </tr>

                        <!-- Modal for each invoice -->
                        <div class="modal fade" id="invoiceModal_<?php echo htmlspecialchars($payment['order_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel_<?php echo htmlspecialchars($payment['order_id']); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="invoiceModalLabel_<?php echo htmlspecialchars($payment['order_id']); ?>">Invoice </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>NOMOR PEMESANAN: <?php echo htmlspecialchars($payment['order_id']); ?></p>
                                        <p>NAMA: <?php echo htmlspecialchars($payment['fullname']); ?></p>
                                        <p>TELEPON: <?php echo htmlspecialchars($payment['telepon']); ?></p>
                                        <p>EMAIL: <?php echo htmlspecialchars($payment['email']); ?></p>
                                        <p>WILAYAH: <?php echo htmlspecialchars($payment['wilayah']); ?></p>
                                        <p>ALAMAT: <?php echo htmlspecialchars($payment['address']); ?></p>
                                        <p>TOTAL PEMBAYARAN: <?php echo htmlspecialchars($payment['total_payment']); ?></p>
                                        <p>METODE PEMBAYARAN: <?php echo htmlspecialchars($payment['payment_method']); ?></p>
                                        <p>BUKTI PEMBAYARAN: <?php echo htmlspecialchars($payment['proof_of_payment']); ?></p>
                                        <p>TANGGAL PEMBAYARAN: <?php echo htmlspecialchars($payment['order_date']); ?></p>
                                        <p>DETAIL PESANAN: <?php echo htmlspecialchars($payment['orderDetails']); ?></p>
                                        <!-- Isi konten faktur untuk ID pesanan <?php echo htmlspecialchars($payment['order_id']); ?> -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal_<?php echo htmlspecialchars($payment['order_id']); ?>">Tutup</button>
                                        <button type="button" class="btn btn-primary" id="printInvoice_<?php echo htmlspecialchars($payment['order_id']); ?>">Cetak</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="./index.php" class="btn btn-primary mt-4">Kembali</a>
    </div>

    <!-- Bootstrap JS (assuming Bootstrap 4 or 5) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menangani event klik pada tombol "Print"
            document.getElementById('printInvoice_<?php echo htmlspecialchars($payment['order_id']); ?>').addEventListener('click', function() {
                var printContents = document.getElementById('invoiceModal_<?php echo htmlspecialchars($payment['order_id']); ?>').innerHTML;
                var originalContents = document.body.innerHTML;

                // Menampilkan hanya konten modal untuk dicetak
                document.body.innerHTML = printContents;

                // Mencetak konten modal
                window.print();

                // Mengembalikan kembali konten asli
                document.body.innerHTML = originalContents;
            });

            // Menangani event klik pada tombol "Close"
            document.getElementById('closeModal_<?php echo htmlspecialchars($payment['order_id']); ?>').addEventListener('click', function() {
                // Menutup modal
                $('#invoiceModal_<?php echo htmlspecialchars($payment['order_id']); ?>').modal('hide');
            });
        });
    </script>
</body>

</html>