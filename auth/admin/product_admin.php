<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Update Stock</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .card {
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(50, 50, 93, 0.15), 0 3px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="min-h-screen bg-gray-100 py-12" style="background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);">

  <div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden card p-6">
      <h2 class="text-2xl font-bold mb-4">Update Stock</h2>
      
      <div class="mb-4">
        <label class="block text-gray-700">Salad Kecil</label>
        <input id="stock-small-input" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="10">
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700">Salad Sedang</label>
        <input id="stock-medium-input" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="20">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Salad Besar</label>
        <input id="stock-large-input" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="5">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700">Salad Jumbo</label>
        <input id="stock-jumbo-input" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="2">
      </div>
      
      <button onclick="updateStock()" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md">Update Stock</button>
      
      <!-- Tombol Kembali -->
      <a href="../admin/home.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mt-4 inline-block">Kembali</a>
    </div>
  </div>

  <script>
    // Load stock values from local storage
    document.getElementById('stock-small-input').value = localStorage.getItem('stock-small') || 10;
    document.getElementById('stock-medium-input').value = localStorage.getItem('stock-medium') || 20;
    document.getElementById('stock-large-input').value = localStorage.getItem('stock-large') || 5;
    document.getElementById('stock-jumbo-input').value = localStorage.getItem('stock-jumbo') || 2;

    // Function to update stock in local storage
    function updateStock() {
      localStorage.setItem('stock-small', document.getElementById('stock-small-input').value);
      localStorage.setItem('stock-medium', document.getElementById('stock-medium-input').value);
      localStorage.setItem('stock-large', document.getElementById('stock-large-input').value);
      localStorage.setItem('stock-jumbo', document.getElementById('stock-jumbo-input').value);
      alert('Stock updated successfully!');
    }
  </script>

</body>

</html>
