-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinjam_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_login` int(11) NOT NULL,
  `tgl_aktif_agt` date NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `agama` varchar(20) NOT NULL,
  `j_kel` varchar(15) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama`, `id_login`, `tgl_aktif_agt`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `agama`, `j_kel`, `no_hp`, `saldo`) VALUES
(7, 'Ridwan Kamil', 5, '2025-04-24', 'Makale', '2025-04-25', 'Bandung', 'Kristen', 'Laki-laki', '082197371947', 0),
(8, 'Michael Viktor', 2, '2025-04-24', 'Makale Tana Toraja', '2025-04-25', 'Mangkupalas', 'Kristen', 'Laki-laki', '087796772129', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `kode_barang` varchar(12) NOT NULL,
  `kategori_brg` varchar(15) NOT NULL,
  `status_brg` varchar(30) DEFAULT 'tersedia',
  `harga_barang` int(11) NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `harga_vip` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `kode_barang`, `kategori_brg`, `status_brg`, `harga_barang`, `harga_sewa`, `harga_vip`, `foto`) VALUES
(12, 'Yamaha Gitar Akustik Elektrik FX400', 'YAM-001', 'Perlengkapan', 'tersedia', 2500000, 100000, 150000, 'Gitar yamaha akuistik.webp'),
(14, 'HF Speaker Bluetooth Portable Karaoke Microphone 3', 'HF -001', 'Elektronik', 'tersedia', 330000, 15000, 25000, 'speaker-bluetooth-portable-karaoke-microphone-3000.png'),
(15, 'Topi Hitam Pria', 'TOP-001', 'Pakaian', 'tersedia', 50000, 5000, 7000, 'topi1.jpg'),
(18, 'cajon coklat custom kajon kahon drum box jazzie pr', 'CAJ-001', 'Perlengkapan', 'tersedia', 3000000, 50000, 15000000, 'cajon.jpg'),
(19, 'Kabel Audio AUX 1 to 1 Jack 3.5mm (Male to Male) u', 'KAB-001', '', 'tersedia', 10000, 12000, 10000, 'kabel-audio-aux-1-to-1-jack-35mm-male-to-male-untuk-smartphone-spea.jpg'),
(20, 'asus vivobook', 'ASU-001', 'Elektronik', 'tersedia', 200000, 100000, 15000, 'Screenshot 2025-04-21 101058.png');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id` int(11) NOT NULL,
  `nama` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `roles` varchar(15) NOT NULL,
  `saldo` int(11) DEFAULT NULL,
  `is_member` tinyint(1) DEFAULT 0,
  `mulai_member` date DEFAULT NULL,
  `akhir_member` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `pass`, `roles`, `saldo`, `is_member`, `mulai_member`, `akhir_member`) VALUES
(1, 'admin', '$2y$10$4u/9TzWP7gbpuaBtuDsCou1Tj0lfe819Y6trQ/vf9dTwza/iwMBE2', 'admin', 370000, 0, NULL, NULL),
(2, 'mikael123', '$2y$10$QK618q9Irpqmw9sR.LPucuLzW7UStqws9/mPqum/CN9wqqLyy8jNy', 'user', 80000, 1, NULL, NULL),
(3, 'johan123', '$2y$10$bVbcwnx8Scu3pftgRUV59u1ktnf.oRUmfdTAZkqvoxN9bpVoMOP5m', 'user', 50000, 0, NULL, NULL),
(4, 'jojo123', '$2y$10$mL15a6D.8YW6eBonaXXSk.tJiBfpzoiQovGdF/6wslS6t.tc7MiOi', 'user', 50000, 0, NULL, NULL),
(5, 'ridwan123', '$2y$10$mU0BOcaKNmew1x0/xl1vjedlu5OwhCK9rYtnjCWoRFAc7i3fl91nK', 'user', 0, 1, NULL, NULL),
(6, 'jokowi', '$2y$10$pOlzO34QV8CAwSIXaHq7Se3w0RWsEzeUl7hDuTIMhKgt8zB8f2QK.', 'user', 35000, 0, NULL, NULL),
(7, 'farizi', '$2y$10$oAT1p5PzxotuhQIxVZHyce/TSA0L4ULEb9hwzcNhmWo52VQApVBnm', 'user', 20000, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tanggal_ajuan` date NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgal_kembali` date NOT NULL,
  `harga_harian` int(11) NOT NULL,
  `jmlh_hari_pinjam` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `ket` text NOT NULL,
  `catatan` text NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `denda` int(11) NOT NULL,
  `status_denda` enum('belum','lunas') DEFAULT 'lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_login`, `id_barang`, `tanggal_ajuan`, `tgl_peminjaman`, `tgal_kembali`, `harga_harian`, `jmlh_hari_pinjam`, `total`, `ket`, `catatan`, `kondisi`, `denda`, `status_denda`) VALUES
(36, 2, 18, '2025-04-29', '2025-05-29', '2025-05-31', 50000, 2, 100000, 'Dikembalikan', '', 'Rusak Berat', 0, 'lunas'),
(37, 2, 12, '2025-04-29', '2025-04-30', '2025-05-06', 100000, 6, 600000, 'Dikembalikan', '', 'Baik', 0, 'lunas'),
(38, 2, 19, '2025-04-29', '2025-04-29', '2025-05-06', 12000, 7, 84000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(39, 2, 15, '2025-04-29', '2025-04-30', '2025-05-06', 5000, 6, 30000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(40, 2, 15, '2025-04-29', '2025-04-29', '2025-05-06', 5000, 7, 35000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(41, 2, 19, '2025-04-29', '2025-04-29', '2025-05-01', 12000, 2, 24000, 'Dikembalikan', '', 'Baik', 0, 'lunas'),
(42, 7, 15, '2025-04-29', '2025-04-29', '2025-05-06', 5000, 7, 35000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(43, 2, 15, '2025-04-29', '2025-04-30', '2025-05-01', 5000, 1, 5000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(44, 2, 14, '2025-04-29', '2025-04-29', '2025-05-06', 15000, 7, 105000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(45, 2, 14, '2025-04-29', '2025-04-30', '2025-05-02', 15000, 2, 30000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(46, 2, 15, '2025-04-29', '2025-04-30', '2025-04-30', 5000, 0, 0, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(47, 2, 15, '2025-04-29', '2025-04-29', '2025-04-30', 5000, 1, 5000, 'Dikembalikan', '', 'Baik', 0, 'lunas'),
(49, 2, 19, '2025-04-29', '2025-04-30', '2025-05-01', 12000, 1, 12000, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(50, 2, 15, '2025-04-30', '2025-04-29', '2025-04-29', 5000, 0, 0, 'Dikembalikan', '', 'Rusak Ringan', 0, 'lunas'),
(51, 2, 15, '2025-04-30', '2025-04-29', '2025-04-30', 5000, 1, 5000, 'Dikembalikan', '', 'Baik', 0, 'lunas'),
(52, 2, 14, '2025-04-30', '2025-04-29', '2025-04-30', 15000, 1, 15000, 'Ditolak', '', '', 0, 'lunas'),
(53, 2, 18, '2025-04-30', '2025-04-29', '2025-04-30', 50000, 1, 50000, 'Ditolak', '', '', 0, 'lunas'),
(54, 2, 14, '2025-04-30', '2025-04-30', '2025-05-01', 12000, 1, 12000, 'Ditolak', '', '', 0, 'lunas'),
(55, 2, 15, '2025-04-30', '2025-04-30', '2025-05-01', 4000, 1, 4000, 'Dikembalikan', '', 'Baik', 0, 'lunas'),
(56, 2, 15, '2025-04-30', '2025-04-30', '2025-05-01', 4000, 1, 4000, 'Ditolak', '', '', 0, 'lunas'),
(57, 2, 15, '2025-04-30', '2025-04-30', '2025-05-01', 4000, 1, 4000, 'Ditolak', '', '', 0, 'lunas');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_saldo`
--

CREATE TABLE `riwayat_saldo` (
  `id` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tipe_transaksi` enum('masuk','keluar') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_saldo`
--

INSERT INTO `riwayat_saldo` (`id`, `id_login`, `tanggal`, `keterangan`, `nominal`, `tipe_transaksi`) VALUES
(28, 2, '2025-04-29 00:00:00', 'Top Up Saldo', 10000, 'masuk'),
(31, 2, '2025-04-29 00:00:00', 'Top Up Saldo', 15000, 'masuk'),
(33, 2, '2025-04-29 00:00:00', 'Top Up Saldo', 30000, 'masuk'),
(34, 2, '2025-04-29 00:00:00', 'Peminjaman Barang', 12000, 'keluar'),
(35, 2, '2025-04-29 00:00:00', 'Pembayaran Denda', 12000, 'keluar'),
(37, 2, '2025-04-30 00:00:00', 'Top Up Saldo', 30000, 'masuk'),
(39, 2, '2025-04-30 00:00:00', 'Top Up Saldo', 10000, 'masuk'),
(40, 2, '2025-04-30 00:00:00', 'Top Up Saldo', 50000, 'masuk'),
(41, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 0, 'keluar'),
(42, 2, '2025-04-30 00:00:00', 'Pembayaran Denda', 1000, 'keluar'),
(43, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 5000, 'keluar'),
(44, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 15000, 'keluar'),
(45, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 50000, 'keluar'),
(46, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 12000, 'keluar'),
(47, 2, '2025-04-30 00:00:00', 'Top Up Saldo', 50000, 'masuk'),
(48, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 4000, 'keluar'),
(49, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 4000, 'keluar'),
(50, 2, '2025-04-30 00:00:00', 'Peminjaman Barang', 4000, 'keluar');

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `metode_bayar` varchar(20) NOT NULL,
  `kode_bayar` varchar(10) NOT NULL,
  `bkt_pembayaran` text NOT NULL,
  `tgal_topup` date NOT NULL,
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id`, `id_login`, `nominal`, `metode_bayar`, `kode_bayar`, `bkt_pembayaran`, `tgal_topup`, `status`) VALUES
(9, 2, 20000, 'gopay', '179311', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(10, 2, 20000, 'dana', '387422', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(11, 2, 18000, 'dana', '544216', 'buktitf2.jpg', '2025-04-22', 'diterima'),
(12, 2, 15000, 'gopay', '496681', 'buktitf2.jpg', '2025-04-22', 'diterima'),
(13, 2, 50000, 'gopay', '620470', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(14, 2, 40000, 'dana', '718656', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(15, 2, 30000, 'gopay', '252322', 'buktitf2.jpg', '2025-04-22', 'diterima'),
(25, 2, 20000, 'gopay', '402857', 'buktitf2.jpg', '2025-04-22', 'diterima'),
(26, 2, 30000, 'dana', '835547', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(27, 3, 100000, 'gopay', '931947', 'bukti tf 1.jpg', '2025-04-22', 'diterima'),
(28, 4, 100000, 'dana', '629067', 'Screenshot 2025-04-23 104120.png', '2025-04-23', 'diterima'),
(29, 2, 200000, 'gopay', '459757', 'bukti tf 1.jpg', '2025-04-23', 'diterima'),
(30, 5, 500000, 'gopay', '751033', 'buktitf2.jpg', '2025-04-23', 'diterima'),
(31, 6, 50000, 'gopay', '389038', 'buktitf2.jpg', '2025-04-23', 'diterima'),
(32, 2, 1000000, 'gopay', '820719', 'bukti tf 1.jpg', '2025-04-24', 'diterima'),
(33, 2, 300000, '', '515389', 'Screenshot 2025-04-24 142951.png', '2025-04-29', 'diterima'),
(34, 2, 200000, 'ovo', '411466', 'bangke.png', '2025-04-29', 'diterima'),
(35, 2, 100000, 'ovo', '441948', 'bangke.png', '2025-04-29', 'diterima'),
(36, 2, 10000, 'dana', '65893', 'biseksi.jpg', '2025-04-29', 'diterima'),
(37, 7, 100000, 'ovo', '830317', 'bangke.png', '2025-04-29', 'diterima'),
(38, 2, 100000, 'ovo', '155352', 'bangke.png', '2025-04-29', 'diterima'),
(51, 2, 10000, 'gopay', '410408', 'cajon.jpg', '2025-04-29', 'diterima'),
(54, 2, 15000, 'dana', '403177', 'bukti tf 1.jpg', '2025-04-29', 'diterima'),
(56, 2, 30000, 'dana', '921825', 'buktitf2.jpg', '2025-04-29', 'diterima'),
(58, 2, 30000, 'gopay', '438402', 'buktitf2.jpg', '2025-04-29', 'diterima'),
(59, 2, 0, '', '962618', 'buktitf2.jpg', '2025-04-29', 'diterima'),
(60, 2, 10000, 'gopay', '930152', 'buktitf2.jpg', '2025-04-29', 'diterima'),
(61, 2, 50000, 'dana', '654306', 'buktitf2.jpg', '2025-04-29', 'diterima'),
(62, 2, 50000, 'dana', '314700', 'buktitf2.jpg', '2025-04-29', 'diterima');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_login` (`id_login`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `f_id_login` (`id_login`);

--
-- Indexes for table `riwayat_saldo`
--
ALTER TABLE `riwayat_saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_login_fk` (`id_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `riwayat_saldo`
--
ALTER TABLE `riwayat_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `fk_id_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `f_id_login` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`);

--
-- Constraints for table `riwayat_saldo`
--
ALTER TABLE `riwayat_saldo`
  ADD CONSTRAINT `riwayat_saldo_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saldo`
--
ALTER TABLE `saldo`
  ADD CONSTRAINT `id_login_fk` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
