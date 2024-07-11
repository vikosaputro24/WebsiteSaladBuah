<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Buah-buahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        @keyframes fall-in {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-left {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in-right {
            animation: slideInRight 0.75s ease-out forwards;
        }

        .title {
            animation: slide-in-left 1s ease-out;
        }

        .card {
            animation: fall-in 0.75s ease-out;
        }

        .hover-pop {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-pop:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .fixed-icons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            z-index: 1000;
        }

        .fixed-icons a,
        .fixed-icons button {
            background-color: white;
            /* White background */
            border-radius: 50%;
            /* Circular shape */
            padding: 15px;
            /* Adjust padding to make the circle larger */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            /* Adjust as needed */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Optional: Add shadow for better visibility */
            transition: transform 0.3s ease-in-out;
            /* Smooth hover effect */
        }

        .fixed-icons a:hover,
        .fixed-icons button:hover {
            transform: scale(1.1);
            /* Slightly enlarge on hover */
        }

        .scroll-animation {
            animation: pop-in 0.3s ease-in-out;
        }

        @keyframes pop-in {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="p-8 about " style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">
    <div class=" max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <h1 class="text-3xl font-bold mb-6 md:mb-0 text-white text-center title" id="falling-title">Berikut buah - buahan yang kami pakai !</h1>
        <div>
            <a href="../Home/index.php" class="items-center transition duration-300 slide-in-right" style="color: #fda085;">
                <i class="fas fa-arrow-left fixed-icons slide-in-right" style="background-color: #fff; padding: 10px; border-radius: 50%;"></i>
            </a>
            <button onclick="window.location.href='cart.php'" class="flex items-center p-3 rounded-lg bg-white transition duration-300 hover-pop slide-in-right" style="color: #fda085;">
                Lihat produk kami !
            </button>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1: Apel -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;">
            <img src="../../assets/apel.png" alt="Apel" class="w-full h-40 object-cover" style="width: fit-content; padding-left:60px; padding-top:8px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Apel</h2>
                <p class="text-gray-700 mb-4">Buah ini kaya akan serat yang membantu menjaga kesehatan pencernaan dan dapat menurunkan kadar kolesterol. </p>
            </div>
        </div>

        <!-- Card 2: Pisang -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;">
            <img src="../../assets/pisang.png" alt="Pisang" class="w-full h-40 object-cover" style="width: fit-content; padding-left:60px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Pisang</h2>
                <p class="text-gray-700 mb-4">Buah rendah lemak dan kaya akan kalium, membantu menjaga kesehatan jantung dan mengatur tekanan darah.</p>
            </div>
        </div>

        <!-- Card 3: Anggur -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;">
            <img src="../../assets/anggur.png" alt="Pisang" class="w-full h-40 object-cover" style="width: fit-content; padding-left:60px; padding-right:25px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Anggur</h2>
                <p class="text-gray-700 mb-4">Buah ini dapat meningkatkan kesehatan otak dan melindungi terhadap penyakit neurodegeneratif seperti Alzheimer.</p>
            </div>
        </div>
        <!-- Card 4: Buah Naga -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/naga.png" alt="Pisang" class="w-full h-40 object-cover" style="width: fit-content; padding-left:100px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Naga</h2>
                <p class="text-gray-700 mb-4">Buah ini dapat melawan radikal bebas, sehingga dapat mencegah kerusakan sel dan mengurangi risiko penyakit kronis.</p>
            </div>
        </div>

        <!-- Card 5: Mangga -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/mangga.png" alt="Mangga" class="w-full h-40 object-cover" style="width: fit-content; padding-left:60px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Mangga</h2>
                <p class="text-gray-700 mb-4">Buah ini mengandung vitamin C berguna untuk menjaga kekebalan tubuh dan melawan infeksi.</p>
            </div>
        </div>

        <!-- Card 6: Strawberry -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/strawberry.png" alt="Strawberry" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Strawberry</h2>
                <p class="text-gray-700 mb-4">Buah rendah lemak dan kaya akan kalium, membantu menjaga kesehatan jantung dan mengatur tekanan darah.</p>
            </div>
        </div>

        <!-- Card 7: Alpukat -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/alpukat.png" alt="alpukat" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Alpukat</h2>
                <p class="text-gray-700 mb-4">Alpukat mengandung antioksidan seperti beta-karoten, dan selenium yang membantu melawan kerusakan sel di dalam tubuh.</p>
            </div>
        </div>

        <!-- Card 8: Kiwi -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/kiwi.jpg" alt="kiwi" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Kiwi</h2>
                <p class="text-gray-700 mb-4">Kiwi mengandung serat pangan yang membantu memperlancar pencernaan, dan menjaga kesehatan usus secara keseluruhan.</p>
            </div>
        </div>

        <!-- Card 9: Jeruk -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/jeruk.png" alt="Jeruk" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Jeruk</h2>
                <p class="text-gray-700 mb-4"> Kandungan vitamin C dalam jeruk penting untuk membantu menjaga elastisitas kulit, mencegah penuaan dini.</p>
            </div>
        </div>
        <!-- Card 10: Bluberi -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/bluberi.jpg" alt="blueberry" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Blueberry</h2>
                <p class="text-gray-700 mb-4"> Anthocyanin dalam blueberry telah dikaitkan dengan meningkatkan fungsi kognitif dan melindungi otak dari stres oksidatif.</p>
            </div>
        </div>
        <!-- Card 11: Nanas -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/nanas.jpg" alt="nanas" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Nanas</h2>
                <p class="text-gray-700 mb-4"> Bromelain di nanas dapat membantu memperbaiki pencernaan, dan mencegah sembelit.</p>
            </div>
        </div>
        <!-- Card 12: Cerry -->
        <div class="bg-white rounded-lg overflow-hidden shadow-md card hover-pop" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 20px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
            <img src="../../assets/cerry.png" alt="cerry" class="w-full h-40 object-cover" style="width: fit-content; padding-left:90px;">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">Cerry</h2>
                <p class="text-gray-700 mb-4"> Antioksidan dan senyawa lainnya dalam cherry dapat membantu mengurangi risiko penyakit jantung dan menyehatkan tubuh.</p>
            </div>
        </div>
    </div>
    </div>

    <script>
        window.onload = function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fall-in');
                }, index * 100); // Delay animation for each card
            });
        };

        window.addEventListener('scroll', function() {
            const icons = document.querySelector('.fixed-icons');
            icons.classList.toggle('scroll-animation', window.scrollY > 50);
        });
    </script>
</body>

</html>