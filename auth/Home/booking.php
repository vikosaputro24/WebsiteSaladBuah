<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Data Pemesanan</h1>
    <div class="bg-white shadow-md rounded my-6">
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 border-b border-gray-200">ID Pesanan</th>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 border-b border-gray-200">Nama Pelanggan</th>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 border-b border-gray-200">Tanggal Pemesanan</th>
            <th class="py-2 px-4 bg-gray-200 text-gray-600 border-b border-gray-200">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="py-2 px-4 border-b border-gray-200">001</td>
            <td class="py-2 px-4 border-b border-gray-200">John Doe</td>
            <td class="py-2 px-4 border-b border-gray-200">2024-06-15</td>
            <td class="py-2 px-4 border-b border-gray-200">
              <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Selesai</span>
            </td>
          </tr>
          <tr class="bg-gray-50">
            <td class="py-2 px-4 border-b border-gray-200">002</td>
            <td class="py-2 px-4 border-b border-gray-200">Jane Smith</td>
            <td class="py-2 px-4 border-b border-gray-200">2024-06-16</td>
            <td class="py-2 px-4 border-b border-gray-200">
              <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Proses</span>
            </td>
          </tr>
          <tr>
            <td class="py-2 px-4 border-b border-gray-200">003</td>
            <td class="py-2 px-4 border-b border-gray-200">Alice Johnson</td>
            <td class="py-2 px-4 border-b border-gray-200">2024-06-17</td>
            <td class="py-2 px-4 border-b border-gray-200">
              <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Dibatalkan</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>


buat di edit salad buah apabila dia memilih yang kecil maka ada pemberitahuan bahwan pilih 3 buah