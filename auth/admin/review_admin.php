<?php
session_start();



// Include database connection file
include '../../koneksi.php';

$all_reviews = [];

$query = "SELECT r.rating, r.comment, r.created_at, u.fullname FROM reviews r JOIN tb_loginuser u ON r.user_id = u.user_id ORDER BY r.created_at DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_reviews[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - All Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-100 py-12" style="background-color:#f6d365;">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Semua Review</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b">Nama Pengguna</th>
                        <th class="px-6 py-3 border-b">Rating</th>
                        <th class="px-6 py-3 border-b">Komentar</th>
                        <th class="px-6 py-3 border-b">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all_reviews)) { ?>
                        <?php foreach ($all_reviews as $review) { ?>
                            <tr>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($review['fullname']); ?></td>
                                <td class="px-6 py-4 border-b">
                                    <div class="flex items-center">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <i class="fas fa-star text-<?php echo ($i <= $review['rating']) ? 'yellow-500' : 'gray-400'; ?> text-xl"></i>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($review['comment']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo $review['created_at']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="px-6 py-4 border-b text-center" colspan="4">Tidak ada review.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="./home.php" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md mt-4">
            Kembali
        </a>
    </div>
</body>

</html>
