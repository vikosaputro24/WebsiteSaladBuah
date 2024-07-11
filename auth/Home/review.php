<?php
session_start();

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit();
}

// Include database connection file
include '../../koneksi.php';

// Assuming $user_id contains the logged-in user's user_id
$user_id = $_SESSION['user_id'];

$message = "";
$latest_reviews = []; // Initialize the variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $query = "INSERT INTO reviews (user_id, rating, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $user_id, $rating, $comment);

    if ($stmt->execute()) {
        $message = "Review Anda berhasil disimpan!";

        // Fetch the latest reviews by the user
        $review_query = "SELECT rating, comment, created_at FROM reviews WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
        $review_stmt = $conn->prepare($review_query);
        $review_stmt->bind_param("i", $user_id);
        $review_stmt->execute();
        $result = $review_stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $latest_reviews[] = $row;
        }
        $review_stmt->close();

        // Store latest reviews in session for persistence
        $_SESSION['latest_reviews'] = $latest_reviews;
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Check if there are reviews in session to display
if (isset($_SESSION['latest_reviews'])) {
    $latest_reviews = $_SESSION['latest_reviews'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <style>
        .slick-prev,
        .slick-next {
            background-color: black !important;
            border-radius: 50%;
            color: white !important;
        }

        .slick-prev:hover,
        .slick-next:hover {
            background-color: #333 !important;
        }

        .reviews-carousel {
            max-width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Toast styling */
        #toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
            padding: 10px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 py-12" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Berikan Penilaian Anda</h2>
        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Penilaian</label>
                <div class="flex">
                    <?php for ($i = 5; $i >= 1; $i--) { ?>
                        <div class="flex items-center">
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" class="hidden">
                            <label for="star<?php echo $i; ?>" class="cursor-pointer">
                                <i class="fas fa-star text-gray-400 text-2xl"></i>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Komentar</label>
                <textarea name="comment" rows="4" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" placeholder="Tulis komentar Anda di sini..."></textarea>
            </div>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md mt-5 mb-8">Kirim Review</button>
            <a href="./index.php" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md mt-4">
                Kembali
            </a>

        </form>
        <!-- Toast notification -->
        <?php if ($message) { ?>
            <div id="toast" class="bg-green-500 text-white py-2 px-4 rounded-md shadow-md">
                <?php echo $message; ?>
            </div>
        <?php } ?>
        <!-- Display latest reviews -->
        <?php if (!empty($latest_reviews)) { ?>
            <div class="reviews-carousel mt-8 p-6 bg-gray-100 rounded-lg shadow-md">
                <?php foreach ($latest_reviews as $review) { ?>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Penilaian Terbaru Anda</h3>
                        <div class="flex items-center mb-2">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <i class="fas fa-star text-<?php echo ($i <= $review['rating']) ? 'yellow-500' : 'gray-400'; ?> text-2xl"></i>
                            <?php } ?>
                        </div>
                        <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($review['comment']); ?></p>
                        <p class="text-gray-500 text-sm">Dikirim pada: <?php echo $review['created_at']; ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <!-- JavaScript libraries -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Show toast if message is set
            <?php if ($message == "Review Anda berhasil disimpan!") { ?>
                $('#toast').removeClass('hidden').fadeIn(1000).delay(3000).fadeOut(1000);
            <?php } ?>

            // Initialize slick carousel
            $('.reviews-carousel').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
            });

            // Update star ratings display
            $('input[name="rating"]').change(function() {
                let rating = $(this).val();
                $('.fa-star').each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('text-gray-400').addClass('text-yellow-500');
                    } else {
                        $(this).removeClass('text-yellow-500').addClass('text-gray-400');
                    }
                });
            });
        });
    </script>
</body>

</html>
