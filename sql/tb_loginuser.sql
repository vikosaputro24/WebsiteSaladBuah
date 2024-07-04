-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jun 2024 pada 15.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sabu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_loginuser`
--

CREATE TABLE `tb_loginuser` (
  `id` int(11) NOT NULL,
  `fullname` varchar(70) NOT NULL,
  `username` varchar(30) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_loginuser`
--

INSERT INTO `tb_loginuser` (`id`, `fullname`, `username`, `telepon`, `email`, `password`) VALUES
(7, 'fauzi viko saputro', 'vikosaputro', '081296049053', 'vikosaputro24@gmail.com', 'viko2408'),
(11, 'fauzi viko saputro', 'user', '085710847277', 'vikosaputro24@gmail.com', 'viko2408'),
(12, 'pekok', 'nadya', '0987654321', 'nadyaaaaaa@gmail.com', 'apaya'),
(15, 'fauziviko', 'fauzi', '085710847277', 'vikosaputro24@gmail.com', 'viko1234'),
(16, 'cobacoba', 'cobayukkssszzzz', '085710847277', 'coba@gmail.com', 'coba1234');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_loginuser`
--
ALTER TABLE `tb_loginuser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_loginuser`
--
ALTER TABLE `tb_loginuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
