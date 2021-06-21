-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jun 2021 pada 07.55
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos_sederhana`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `id_user` varchar(5) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `total_harga`, `bayar`, `kembali`, `created_at`, `updated_at`) VALUES
('TRX-21062112001', 'AD001', 35500, 40000, 4500, '2021-06-21 12:54:21', '2021-06-21 12:54:21'),
('TRX-21062112002', 'AD001', 23000, 25000, 2000, '2021-06-21 12:54:40', '2021-06-21 12:54:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_penjualan` varchar(20) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` tinyint(4) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_penjualan`, `barcode`, `harga`, `jumlah`, `subtotal`, `created_at`, `updated_at`) VALUES
('TRX-21062112001', '112233', 3500, 5, 17500, '2021-06-21 12:54:21', '2021-06-21 12:54:21'),
('TRX-21062112001', '12345', 18000, 1, 18000, '2021-06-21 12:54:21', '2021-06-21 12:54:21'),
('TRX-21062112002', '12347', 23000, 1, 23000, '2021-06-21 12:54:40', '2021-06-21 12:54:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `barcode` varchar(50) NOT NULL,
  `nm_produk` varchar(150) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`barcode`, `nm_produk`, `harga_jual`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('112233', 'Indomie Goreng', 3500, '', '2021-06-21 12:52:55', '2021-06-21 12:52:55', NULL),
('12345', 'Djarum Super', 18000, '', '2021-06-21 12:50:42', '2021-06-21 12:50:42', NULL),
('12346', 'Dji Sam Soe Filter', 23500, '', '2021-06-21 12:51:13', '2021-06-21 12:51:13', NULL),
('12347', 'Sampoerna Mild', 23000, '', '2021-06-21 12:51:35', '2021-06-21 12:51:35', NULL),
('12348', 'Gudang Garam', 21000, '', '2021-06-21 12:52:00', '2021-06-21 12:52:00', NULL),
('223344', 'Mie Sedaap Goreng', 3400, '', '2021-06-21 12:53:16', '2021-06-21 12:53:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` varchar(5) NOT NULL,
  `nm_user` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nm_user`, `username`, `password`, `level`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('AD001', 'Admin POS', 'admin', '$2y$10$sIuwlom.nr4I7he9ah7CTeY7xknOz34/BYr70qiwekXQ01I0OBab2', 'Admin', 'Aktif', '2021-05-28 14:36:00', '2021-06-02 07:17:16', NULL),
('AD002', 'Kasir POS', 'kasir', '$2y$10$vcXeDwHGkYIk0wq9H54SrelePK1UGysJFnSL6HH8fwujXwF833se2', 'Kasir', 'Aktif', '2021-06-21 12:50:15', '2021-06-21 12:50:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`barcode`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
