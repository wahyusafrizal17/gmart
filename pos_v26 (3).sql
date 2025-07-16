-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 06 Jul 2022 pada 03.13
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pos_v26`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_delete`
--

CREATE TABLE IF NOT EXISTS `activity_delete` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data untuk tabel `activity_delete`
--

INSERT INTO `activity_delete` (`id`, `url`, `oleh`, `datetime`) VALUES
(1, 'http://localhost/posv26/dashboard/welcome.php?page=delete/hapus&id_photo=7&img=261e955462fd66.jpeg', 2, '2022-01-27 03:38:42'),
(2, 'http://localhost/posv26/dashboard/welcome.php?page=delete/hapus&id_photo=8&img=261f213b397b7b.png', 2, '2022-01-27 03:38:46'),
(3, 'http://localhost/kasirfix/dashboard/welcome.php?page=barcode/delete&id_barcode=1', 1, '2022-05-21 14:29:06'),
(4, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=42', 2, '2022-05-21 15:11:55'),
(5, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=41', 2, '2022-05-21 15:16:03'),
(6, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=99', 2, '2022-05-21 15:16:21'),
(7, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=44', 2, '2022-05-21 15:19:50'),
(8, 'http://localhost/kasirfix/dashboard/welcome.php?page=delete/hapus&id_photo=5&img=26031b740bdbe9.jpg', 2, '2022-05-21 22:30:28'),
(9, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=10', 2, '2022-05-22 09:51:35'),
(10, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=11', 2, '2022-05-22 09:51:37'),
(11, 'http://localhost/kasirfix/dashboard/welcome.php?page=barcode/delete&id_barcode=2', 2, '2022-05-22 11:17:49'),
(12, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=50', 2, '2022-05-24 12:01:24'),
(13, 'http://localhost/kasirfix/dashboard/welcome.php?page=scan/delete&id=9', 2, '2022-05-25 08:08:23'),
(14, 'http://localhost/kasirfix/dashboard/welcome.php?page=pengeluaran/delete&id=1', 1, '2022-06-28 13:41:16'),
(15, 'http://localhost/kasirfix/dashboard/welcome.php?page=pengeluaran/delete&id=2', 2, '2022-06-28 13:46:31'),
(16, 'http://localhost/kasirfix/dashboard/welcome.php?page=pengeluaran/delete&id=3', 2, '2022-06-28 13:47:18'),
(17, 'http://localhost/kasirfix/dashboard/welcome.php?page=delete/hapus&id_photo=6&img=2628967fb70d3e.png', 2, '2022-06-29 00:47:25'),
(18, 'http://localhost/kasirfix/dashboard/welcome.php?page=delete/hapus&id_photo=9&img=262bba126071c9.png', 2, '2022-06-29 00:47:48'),
(19, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=113', 2, '2022-06-29 00:48:24'),
(20, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=2', 2, '2022-06-29 00:48:29'),
(21, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=101', 2, '2022-06-29 00:48:31'),
(22, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=3', 2, '2022-06-29 00:48:34'),
(23, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=103', 2, '2022-06-29 00:48:36'),
(24, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=102', 2, '2022-06-29 00:48:42'),
(25, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=105', 2, '2022-06-29 00:48:45'),
(26, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=104', 2, '2022-06-29 00:48:47'),
(27, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=106', 2, '2022-06-29 00:48:49'),
(28, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=107', 2, '2022-06-29 00:48:51'),
(29, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=109', 2, '2022-06-29 00:48:53'),
(30, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=108', 2, '2022-06-29 00:48:55'),
(31, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=112', 2, '2022-06-29 00:48:57'),
(32, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=114', 2, '2022-06-29 00:48:59'),
(33, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=115', 2, '2022-06-29 00:49:01'),
(34, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=116', 2, '2022-06-29 00:49:02'),
(35, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=117', 2, '2022-06-29 00:49:03'),
(36, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=118', 2, '2022-06-29 00:49:05'),
(37, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=119', 2, '2022-06-29 00:49:06'),
(38, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=120', 2, '2022-06-29 00:49:07'),
(39, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=121', 2, '2022-06-29 00:49:09'),
(40, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=122', 2, '2022-06-29 00:49:11'),
(41, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=123', 2, '2022-06-29 00:49:13'),
(42, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=124', 2, '2022-06-29 00:49:14'),
(43, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=125', 2, '2022-06-29 00:49:16'),
(44, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=126', 2, '2022-06-29 00:49:18'),
(45, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=127', 2, '2022-06-29 00:49:19'),
(46, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=128', 2, '2022-06-29 00:49:20'),
(47, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=129', 2, '2022-06-29 00:49:22'),
(48, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=130', 2, '2022-06-29 00:49:23'),
(49, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=131', 2, '2022-06-29 00:49:25'),
(50, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=110', 2, '2022-06-29 00:49:28'),
(51, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=111', 2, '2022-06-29 00:49:30'),
(52, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/delete&id_kategori=5', 2, '2022-07-02 09:16:57'),
(53, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=67', 2, '2022-07-03 08:21:19'),
(54, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=102', 2, '2022-07-03 09:58:02'),
(55, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/delete&id_produk=117', 2, '2022-07-03 10:32:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_update`
--

CREATE TABLE IF NOT EXISTS `activity_update` (
`id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `oleh` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data untuk tabel `activity_update`
--

INSERT INTO `activity_update` (`id`, `url`, `oleh`, `datetime`) VALUES
(1, 'http://localhost/posv26/dashboard/welcome.php?page=kategori/update&id_kategori=2', 2, '2022-01-27 03:42:23'),
(2, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-21 14:50:48'),
(3, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=99', 2, '2022-05-21 14:54:21'),
(4, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=99', 2, '2022-05-21 14:54:29'),
(5, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=4', 2, '2022-05-21 14:54:39'),
(6, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=42', 2, '2022-05-21 14:54:57'),
(7, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=4', 2, '2022-05-21 15:14:00'),
(8, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=5', 2, '2022-05-21 15:14:36'),
(9, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=2', 2, '2022-05-21 15:14:46'),
(10, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=3', 2, '2022-05-21 15:14:59'),
(11, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=43', 2, '2022-05-21 15:16:01'),
(12, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-25 10:03:59'),
(13, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=12', 2, '2022-05-25 10:04:10'),
(14, 'http://localhost/kasirfix/dashboard/welcome.php?page=kassa/update&id_kassa=8', 2, '2022-05-25 10:07:52'),
(15, 'http://localhost/kasirfix/dashboard/welcome.php?page=update/profile', 2, '2022-06-28 23:41:08'),
(16, 'http://localhost/kasirfix/dashboard/welcome.php?page=kategori/update&id_kategori=4', 2, '2022-07-02 09:16:52'),
(17, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=59', 2, '2022-07-02 12:33:28'),
(18, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=58', 2, '2022-07-02 12:33:36'),
(19, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=57', 2, '2022-07-02 12:33:44'),
(20, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=56', 2, '2022-07-02 12:33:51'),
(21, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=53', 2, '2022-07-03 08:02:02'),
(22, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=63', 2, '2022-07-03 08:02:32'),
(23, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=62', 2, '2022-07-03 08:02:53'),
(24, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=54', 2, '2022-07-03 08:03:43'),
(25, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=58', 2, '2022-07-03 08:04:11'),
(26, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=59', 2, '2022-07-03 08:04:18'),
(27, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=55', 2, '2022-07-03 08:05:14'),
(28, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=57', 2, '2022-07-03 08:06:02'),
(29, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=61', 2, '2022-07-03 08:08:02'),
(30, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=59', 2, '2022-07-03 08:08:47'),
(31, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=56', 2, '2022-07-03 08:09:33'),
(32, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=60', 2, '2022-07-03 08:10:01'),
(33, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=67', 2, '2022-07-03 08:20:49'),
(34, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=67', 2, '2022-07-03 08:21:08'),
(35, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=78', 2, '2022-07-03 08:42:33'),
(36, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=82', 2, '2022-07-03 08:55:52'),
(37, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=81', 2, '2022-07-03 08:57:31'),
(38, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=80', 2, '2022-07-03 08:57:42'),
(39, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=69', 2, '2022-07-03 08:58:38'),
(40, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=102', 2, '2022-07-03 09:57:09'),
(41, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=119', 2, '2022-07-03 10:31:50'),
(42, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=118', 2, '2022-07-03 10:32:05'),
(43, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=127', 2, '2022-07-04 05:15:46'),
(44, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=140', 2, '2022-07-04 05:40:40'),
(45, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=206', 2, '2022-07-04 07:13:26'),
(46, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=215', 2, '2022-07-04 07:16:54'),
(47, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=177', 2, '2022-07-04 07:20:52'),
(48, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=203', 2, '2022-07-04 15:51:14'),
(49, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=171', 2, '2022-07-05 00:14:55'),
(50, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=171', 2, '2022-07-05 00:15:35'),
(51, 'http://localhost/kasirfix/dashboard/welcome.php?page=produk/update&id_produk=135', 2, '2022-07-05 00:18:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
`id_barcode` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `qtybarcode` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faktur`
--

CREATE TABLE IF NOT EXISTS `faktur` (
`idfaktur` int(11) NOT NULL,
  `tglfaktur` date NOT NULL,
  `kodefaktur` varchar(11) NOT NULL,
  `jenisbayar` enum('CASH','TRANSFER','SHOPEEPAY','MERCHANT','LAINNYA') NOT NULL DEFAULT 'CASH',
  `addedfaktur` int(11) NOT NULL,
  `addbyfaktur` int(11) NOT NULL,
  `periode` varchar(5) NOT NULL,
  `datetimefaktur` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kembalian` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `totalbayar` double DEFAULT NULL,
  `namapelanggan` varchar(100) DEFAULT NULL COMMENT 'fitur 20 Januari dari topoci',
  `nohp` varchar(22) DEFAULT NULL,
  `statusfaktur` enum('Y','N') NOT NULL DEFAULT 'N',
  `qtyprint` int(11) NOT NULL,
  `printby` int(11) NOT NULL,
  `adminfaktur` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Trigger `faktur`
--
DELIMITER //
CREATE TRIGGER `hapus_detailfaktur` BEFORE DELETE ON `faktur`
 FOR EACH ROW BEGIN
	DELETE FROM transaksidetail
    WHERE transaksidetail.faktur = OLD.kodefaktur;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga`
--

CREATE TABLE IF NOT EXISTS `harga` (
`idharga` int(11) NOT NULL,
  `kodeproduk` varchar(15) NOT NULL,
  `hargajual` double NOT NULL,
  `hargabaru` double NOT NULL,
  `hargadasar` double NOT NULL,
  `namaprodukOld` varchar(100) NOT NULL,
  `namaprodukBaru` varchar(100) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data untuk tabel `harga`
--

INSERT INTO `harga` (`idharga`, `kodeproduk`, `hargajual`, `hargabaru`, `hargadasar`, `namaprodukOld`, `namaprodukBaru`, `added`, `addby`, `tercatat`) VALUES
(1, '8999999528942', 13000, 13000, 12000, 'Citra Bengkoang Pearly Glow UV 230 ML', 'Citra Pearly Glow UV 230 ML', 1656765208, 2, '2022-07-02 12:33:28'),
(2, '8999999528935', 13000, 13000, 12000, 'Citra Bengkoang Natural Glow UV 120 ML', 'Citra Bengkoang Natural Glow UV 120 ML', 1656765216, 2, '2022-07-02 12:33:36'),
(3, '8999999528805', 24000, 24000, 22700, 'Citra Bengkoang Pearly Glow UV 230 ML', 'Citra Pearly Glow UV 230 ML', 1656765224, 2, '2022-07-02 12:33:44'),
(4, '8999999528904', 24000, 24000, 22700, 'Citra Bengkoang Sakura Glow UV 230 ML', 'Citra Sakura Glow UV 230 ML', 1656765231, 2, '2022-07-02 12:33:51'),
(5, '8998009020520', 3500, 4000, 3150, 'Buavita Mini 125ML', 'Buavita Mini 125ML', 1656835322, 2, '2022-07-03 08:02:02'),
(6, '8999999528843', 8000, 8000, 7042, 'Citra Pearly Glow UV 60ML', 'Citra Pearly Glow UV 60ML', 1656835352, 2, '2022-07-03 08:02:32'),
(7, '8999999528850', 8000, 8000, 7042, 'Citra Bengkoang Natural Glow UV 60 ML', 'Citra Bengkoang Natural Glow UV 60 ML', 1656835373, 2, '2022-07-03 08:02:53'),
(8, '8999999528881', 23000, 23000, 21002, 'Citra Bengkoang Natural Glow UV 230 ML', 'Citra Bengkoang Natural Glow UV 230 ML', 1656835423, 2, '2022-07-03 08:03:43'),
(9, '8999999528935', 13000, 13000, 12001, 'Citra Bengkoang Natural Glow UV 120 ML', 'Citra Bengkoang Natural Glow UV 120 ML', 1656835451, 2, '2022-07-03 08:04:11'),
(10, '8999999528942', 13000, 13000, 12001, 'Citra Pearly Glow UV 230 ML', 'Citra Pearly Glow UV 230 ML', 1656835458, 2, '2022-07-03 08:04:18'),
(11, '8999999528928', 24000, 24000, 22587, 'Citra Bengkoang Nurshing Glow UV 230 ML', 'Citra Bengkoang Nurshing Glow UV 230 ML', 1656835514, 2, '2022-07-03 08:05:14'),
(12, '8999999528805', 24000, 23000, 21509, 'Citra Pearly Glow UV 230 ML', 'Citra Pearly Glow UV 230 ML', 1656835562, 2, '2022-07-03 08:06:02'),
(13, '8999999528836', 14000, 14000, 12964, 'Citra Nourshing Glow UV 230 ML', 'Citra Nourshing Glow UV 120 ML', 1656835682, 2, '2022-07-03 08:08:02'),
(14, '8999999528942', 13000, 13000, 12001, 'Citra Pearly Glow UV 230 ML', 'Citra Pearly Glow UV 120 ML', 1656835727, 2, '2022-07-03 08:08:47'),
(15, '8999999528904', 24000, 24000, 22587, 'Citra Sakura Glow UV 230 ML', 'Citra Sakura Glow UV 230 ML', 1656835773, 2, '2022-07-03 08:09:33'),
(16, '8999999528829', 14000, 14000, 12964, 'Citra Sakura Glow UV 120 ML', 'Citra Sakura Glow UV 120 ML', 1656835801, 2, '2022-07-03 08:10:01'),
(19, '8999999560775', 16500, 15500, 14266, 'CLOSE UP WHITE ATTRACTION', 'CLOSE UP ACAI BERRY', 1656837753, 2, '2022-07-03 08:42:33'),
(20, '8999999576622', 25500, 26000, 24009, 'SAMPO DOVE ANTI KETOMBE MENTOL', 'SAMPO DOVE ANTI KETOMBE MENTOL', 1656838552, 2, '2022-07-03 08:55:52'),
(21, '8999999707859', 18000, 18500, 16417, 'CLOSE UP BESAR 160G', 'CLOSE UP BESAR 160G', 1656838651, 2, '2022-07-03 08:57:31'),
(22, '8999999707842', 14000, 14500, 12454, 'CLOSE UP SEDANG 110G', 'CLOSE UP SEDANG 110G', 1656838662, 2, '2022-07-03 08:57:42'),
(23, '8999999529604', 34000, 34500, 32967, 'SHAMPO CLEAR COMPLETE CARE MEN', 'SHAMPO CLEAR COMPLETE CARE MEN', 1656838718, 2, '2022-07-03 08:58:38'),
(25, '8999999059309', 4500, 4000, 3490, 'SABUN LIFEBUOY TOTAL10 70G', 'SABUN LIFEBUOY TOTAL10 70G', 1656844310, 2, '2022-07-03 10:31:50'),
(26, '8999999059316', 4500, 4000, 3490, 'SABUN LIFEBUOY MILDCARE 70G', 'SABUN LIFEBUOY MILDCARE 70G', 1656844325, 2, '2022-07-03 10:32:05'),
(27, '8999999564438', 8000, 8000, 6161, 'PEPSODENT MULTI PERFECTION 65G', 'PEPSODENT MULTI PROTECTION 65G', 1656911746, 2, '2022-07-04 05:15:46'),
(28, '8999999534844', 32500, 32500, 31003, 'PONDS TONE UP', 'PONDS TONE UP', 1656913240, 2, '2022-07-04 05:40:40'),
(29, '8992694247507', 24500, 24500, 23000, 'ZWITSAL RICH HONEY', 'ZWITSAL RICH HONEY 200ML', 1656918806, 2, '2022-07-04 07:13:26'),
(30, '8992694246166', 24000, 24000, 22600, 'SABUN & SAMPO ZWITSAL 100ML', 'PERAWATAN RAMBUT ZWITSAL 100ML', 1656919014, 2, '2022-07-04 07:16:54'),
(31, '8999999050009', 2500, 2000, 1750, 'SUNLIGHT JERUK NIPIS 90 ML', 'SUNLIGHT JERUK NIPIS 90 ML', 1656919252, 2, '2022-07-04 07:20:52'),
(32, '8999999034481', 15500, 22000, 20900, 'BABYPOWDER ZWITSAL ALOE VERA', 'BABYPOWDER ZWITSAL ALOE VERA', 1656949874, 2, '2022-07-04 15:51:14'),
(33, '8999999016128', 30000, 29500, 27695, 'RINSO ANTI NODA 750ML', 'RINSO ANTI NODA 750ML', 1656980095, 2, '2022-07-05 00:14:55'),
(34, '8999999016128', 29500, 29500, 27965, 'RINSO ANTI NODA 750ML', 'RINSO ANTI NODA 750ML', 1656980135, 2, '2022-07-05 00:15:35'),
(35, '8999999037765', 15000, 15000, 13425, 'PEPSODENT WHITE  225G', 'PEPSODENT WHITE  225G', 1656980329, 2, '2022-07-05 00:18:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kassa`
--

CREATE TABLE IF NOT EXISTS `kassa` (
`id_kassa` int(11) NOT NULL,
  `user_kassa` varchar(10) NOT NULL,
  `pwd_kassa` varchar(50) NOT NULL,
  `nama_kassa` varchar(60) NOT NULL,
  `alamat_kassa` varchar(255) NOT NULL,
  `telp_kassa` varchar(25) NOT NULL,
  `level_kassa` int(11) NOT NULL DEFAULT '3',
  `status_kassa` enum('Y','N') NOT NULL DEFAULT 'Y',
  `added_kassa` int(11) NOT NULL,
  `updated_kassa` int(11) NOT NULL,
  `addby_kassa` int(11) NOT NULL,
  `key_kassa` varchar(20) NOT NULL DEFAULT 'viewpr4t4m4'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `kassa`
--

INSERT INTO `kassa` (`id_kassa`, `user_kassa`, `pwd_kassa`, `nama_kassa`, `alamat_kassa`, `telp_kassa`, `level_kassa`, `status_kassa`, `added_kassa`, `updated_kassa`, `addby_kassa`, `key_kassa`) VALUES
(8, 'kasir', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Kasir', 'Bolai Guguak', '082284980398', 3, 'Y', 1642681857, 1653473272, 2, 'viewpr4t4m4'),
(12, 'sudir', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'Sudir Kasir', 'Jl Karasak cupak\r\n', '082283751455', 3, 'Y', 1653142481, 1653473050, 1, 'viewpr4t4m4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
`idkategori` int(11) NOT NULL,
  `namakategori` varchar(30) NOT NULL,
  `ketkategori` varchar(100) DEFAULT NULL,
  `addedkategori` int(11) NOT NULL DEFAULT '123',
  `updatedkategori` int(11) NOT NULL,
  `addbykategori` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `ketkategori`, `addedkategori`, `updatedkategori`, `addbykategori`) VALUES
(4, 'UNILEVER', 'SALES :082384192262', 1642685201, 1656753412, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE IF NOT EXISTS `pengeluaran` (
`id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `judul` varchar(255) NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `oleh` varchar(100) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nominal` double unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
`idperiode` int(11) NOT NULL,
  `kodeperiode` varchar(5) NOT NULL,
  `ketperiode` varchar(30) NOT NULL,
  `sttperiode` enum('Y','N') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`idperiode`, `kodeperiode`, `ketperiode`, `sttperiode`) VALUES
(1, '2022', 'Periode 2022', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
`idproduk` int(11) NOT NULL,
  `namaproduk` varchar(100) NOT NULL,
  `kategori` int(11) NOT NULL,
  `deskproduk` varchar(200) DEFAULT NULL,
  `hargadasar` double NOT NULL,
  `hargajual` double NOT NULL,
  `kodeproduk` varchar(15) NOT NULL,
  `satuan` varchar(15) NOT NULL COMMENT 'di distinct',
  `stok` int(11) NOT NULL,
  `minProduk` int(11) DEFAULT NULL COMMENT 'Alert Minimal',
  `statusproduk` enum('Y','N') NOT NULL DEFAULT 'Y',
  `addedproduk` int(11) NOT NULL DEFAULT '123',
  `updatedproduk` int(11) NOT NULL,
  `addbyproduk` int(11) NOT NULL,
  `alertproduk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `satuan`, `stok`, `minProduk`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`) VALUES
(53, 'Buavita Mini 125ML', 4, 'Expired : 13 April 2023', 3150, 4000, '8998009020520', 'PCS', 12, NULL, 'Y', 1656764622, 1656835322, 2, NULL),
(54, 'Citra Bengkoang Natural Glow UV 230 ML', 4, 'Expired : 04 April 2024', 21002, 23000, '8999999528881', 'PCS', 3, NULL, 'Y', 1656764783, 1656835423, 2, NULL),
(55, 'Citra Bengkoang Nurshing Glow UV 230 ML', 4, 'Expired : 07 April 2024', 22587, 24000, '8999999528928', 'PCS', 3, NULL, 'Y', 1656764859, 1656835514, 2, NULL),
(56, 'Citra Sakura Glow UV 230 ML', 4, 'Expired : 04 Maret 2024', 22587, 24000, '8999999528904', 'PCS', 3, NULL, 'Y', 1656764932, 1656835773, 2, NULL),
(57, 'Citra Pearly Glow UV 230 ML', 4, 'Expired : 10 Mei 2024', 21509, 23000, '8999999528805', 'PCS', 3, NULL, 'Y', 1656764964, 1656835562, 2, NULL),
(58, 'Citra Bengkoang Natural Glow UV 120 ML', 4, 'Expired : 19 Februari 2024', 12001, 13000, '8999999528935', 'PCS', 3, NULL, 'Y', 1656765089, 1656835451, 2, NULL),
(59, 'Citra Pearly Glow UV 120 ML', 4, 'Expired : 25 April 2024', 12001, 13000, '8999999528942', 'PCS', 3, NULL, 'Y', 1656765175, 1656835727, 2, NULL),
(60, 'Citra Sakura Glow UV 120 ML', 4, 'Expired : 29 April 2024', 12964, 14000, '8999999528829', 'PCS', 3, NULL, 'Y', 1656765327, 1656835801, 2, NULL),
(61, 'Citra Nourshing Glow UV 120 ML', 4, 'Expired : 21 April 2024', 12964, 14000, '8999999528836', 'PCS', 3, NULL, 'Y', 1656765438, 1656835682, 2, NULL),
(62, 'Citra Bengkoang Natural Glow UV 60 ML', 4, 'Expired : 12 April 2024', 7042, 8000, '8999999528850', 'PCS', 3, NULL, 'Y', 1656765550, 1656835373, 2, NULL),
(63, 'Citra Pearly Glow UV 60ML', 4, 'Expired : 25 April 2024', 7042, 8000, '8999999528843', 'PCS', 3, NULL, 'Y', 1656765606, 1656835352, 2, NULL),
(64, 'Sabun Citra Pearly Glow', 4, 'Expired : 28 Agustus 2024', 2965, 3500, '8999999533724', 'PCS', 6, NULL, 'Y', 1656835987, 0, 2, NULL),
(65, 'Sabun Citra Fresh Glow', 4, 'Expired : 05 July 2024', 2965, 3500, '8999999533717', 'PCS', 6, NULL, 'Y', 1656836043, 0, 2, NULL),
(66, 'CLEAR 3IN1 Active Clean', 4, 'Expired : 16 Februari 2024', 29471, 31500, '8999999555931', 'PCS', 3, NULL, 'Y', 1656836290, 0, 2, NULL),
(68, 'SHAMPO CLEAR SOFT CARE', 4, 'EXP : 21 OKT 20204', 29471, 31500, '8999999529628', 'PCS', 3, NULL, 'Y', 1656836534, 0, 2, NULL),
(69, 'SHAMPO CLEAR COMPLETE CARE MEN', 4, 'EXP : 13 JUN 20204', 32967, 34500, '8999999529604', 'PCS', 3, NULL, 'Y', 1656836609, 1656838718, 2, NULL),
(70, 'SHAMPO CLEAR COOL SPORT MEN', 4, 'EXP : 21 OKT 2024', 29471, 31500, '8999999529710', 'PCS', 3, NULL, 'Y', 1656836673, 0, 2, NULL),
(71, 'SHAMPO CLEAR COMPLETE CARE KECIL', 4, 'EXP : 11 OKT 2024', 14319, 15500, '8999999529550', 'PCS', 3, NULL, 'Y', 1656836863, 0, 2, NULL),
(72, 'SHAMPO CLEAR COOL SPORT MEN KECIL', 4, 'EXP : 09 OKT 2024', 14153, 15500, '8999999529703', 'PCS', 3, NULL, 'Y', 1656836967, 0, 2, NULL),
(73, 'SHAMPO CLEAR ICE MENTOL KECIL', 4, 'EXP : 09 OKT 2024', 14319, 15500, '8999999529673', 'PCS', 3, NULL, 'Y', 1656837029, 0, 2, NULL),
(74, 'SAMPO CLEAR SUPERFRESH APPLE', 4, 'EXP : 18 OKT 2024', 29471, 31500, '8999999529901', 'PCS', 3, NULL, 'Y', 1656837145, 0, 2, NULL),
(75, 'SAMPO CLEAR FRESH LEMON', 4, 'EXP : 19 OKT 2024', 29471, 31500, '8999999537142', 'PCS', 3, NULL, 'Y', 1656837206, 0, 2, NULL),
(76, 'SAMPO CLEAR SUPERFRESH APPLE KECIL', 4, 'EXP : 04 FEB 2024', 14319, 15500, '8999999529918', 'PCS', 3, NULL, 'Y', 1656837280, 0, 2, NULL),
(77, 'SAMPO CLEAR ICE MENTOL', 4, 'EXP : 26 OKT 2024', 29417, 31500, '8999999529734', 'PCS', 3, NULL, 'Y', 1656837331, 0, 2, NULL),
(78, 'CLOSE UP ACAI BERRY', 4, 'EXP : 09 MAR 2025', 14266, 15500, '8999999560775', 'PCS', 3, NULL, 'Y', 1656837660, 1656837753, 2, NULL),
(79, 'CLOSE UP WHITE ATTRACTION', 4, 'EXP : 26 MAR 2025', 15171, 16500, '8999999519957', 'PCS', 3, NULL, 'Y', 1656837803, 0, 2, NULL),
(80, 'CLOSE UP SEDANG 110G', 4, 'EXP : 24 MEI 2025', 12454, 14500, '8999999707842', 'PCS', 6, NULL, 'Y', 1656837907, 1656838661, 2, NULL),
(81, 'CLOSE UP BESAR 160G', 4, 'EXP : 23 JAN 2025', 16417, 18500, '8999999707859', 'PCS', 6, NULL, 'Y', 1656837977, 1656838651, 2, NULL),
(82, 'SAMPO DOVE ANTI KETOMBE MENTOL', 4, 'EXP : 21 AGUS 2024', 24009, 26000, '8999999576622', 'PCS', 3, NULL, 'Y', 1656838439, 1656838552, 2, NULL),
(83, 'SAMPO DOVE PERAWATAN RAMBUT RONTOK', 4, 'EXP : 21 MAR 2024', 24009, 26000, '8999999576615', 'PCS', 3, NULL, 'Y', 1656838540, 0, 2, NULL),
(84, 'DEODORANT DOVE SENSITIVE', 4, 'EXP : 24 JUN 2023', 18426, 20500, '8999999538583', 'PCS', 3, NULL, 'Y', 1656838913, 0, 2, NULL),
(85, 'DEODORANT DOVE GO FRESH', 4, 'EXP : 07 FEB 2024', 18426, 20500, '8999999519865', 'PCS', 3, NULL, 'Y', 1656838965, 0, 2, NULL),
(86, 'DEODORANT DOVE INVISIBLE DRY', 4, 'EXP : 17 FEB 2024', 18426, 20500, '8999999521028', 'PCS', 3, NULL, 'Y', 1656839047, 0, 2, NULL),
(87, 'DEODORANT DOVE GO FRESH MERAH', 4, 'EXP : 31 MAR 2024', 18426, 20500, '8999999519872', 'PCS', 3, NULL, 'Y', 1656839113, 0, 2, NULL),
(88, 'DOVE SERUM SAMPO ANTI KETOMBE', 4, 'EXP : 28 SEPT 2024', 22320, 24500, '8999999573102', 'PCS', 3, NULL, 'Y', 1656839360, 0, 2, NULL),
(89, 'DOVE SERUM SAMPO RAMBUT RONTOK', 4, 'EXP : 01 SEPT 2024', 22320, 24500, '8999999573089', 'PCS', 3, NULL, 'Y', 1656839404, 0, 2, NULL),
(90, 'Dove Shampo Perawatan Rambut Rusak ', 4, 'EXP : 25 APRIL 2024', 22320, 24500, '8999999573072', 'PCS', 3, NULL, 'Y', 1656839461, 0, 2, NULL),
(91, 'FAIR & LOVELY GLOW 23G', 4, 'EXP : -', 17689, 19000, '8999999007782', 'PCS', 3, NULL, 'Y', 1656839898, 0, 2, NULL),
(92, 'FAIR & LOVELY GLOW 100G', 4, 'EXP : 12 APRIL 2025', 23806, 26000, '8999999055776', 'PCS', 3, NULL, 'Y', 1656839960, 0, 2, NULL),
(93, 'FAIR & LOVELY GLOW 50G', 4, 'EXP : 18 APRIL 2025', 14568, 16500, '8999999055769', 'PCS', 3, NULL, 'Y', 1656840184, 0, 2, NULL),
(94, 'LIFEBUOY BW CHARCOALMINT', 4, 'EXP : 10 MAR 2024', 29465, 32500, '8999999530259', 'PCS', 3, NULL, 'Y', 1656840743, 0, 2, NULL),
(95, 'LIFEBUOY BW COOL FRESH 400ML', 4, 'EXP : 04 OKTOBER 2024', 26220, 28000, '8999999001179', 'PCS', 3, NULL, 'Y', 1656840898, 0, 2, NULL),
(96, 'LIFEBUOY BW HONEYHABBATUS 450ML', 4, 'EXP : 07 OKTOBER 2024', 29465, 32500, '8999999538200', 'PCS', 3, NULL, 'Y', 1656840943, 0, 2, NULL),
(97, 'LIFEBUOY BW LEMON FRESH 400ML', 4, 'EXP : 14 OKTOBER 2024', 26220, 28000, '8999999027261', 'PCS', 3, NULL, 'Y', 1656840989, 0, 2, NULL),
(98, 'LIFEBUOY BW LEMON FRESH 250 ML', 4, 'EXP : 08 SEPTEMBER 2024', 21015, 23000, '8999999027278', 'PCS', 3, NULL, 'Y', 1656841052, 0, 2, NULL),
(99, 'LIFEBUOY BW MILD CARE 400ML', 4, 'EXP : 05 OKTOBER 2024', 26220, 28000, '8999999001209', 'PCS', 3, NULL, 'Y', 1656841113, 0, 2, NULL),
(100, 'LIFEBUOY BW MILD CARE 250ML', 4, 'EXP : 11 NOV 2024', 21015, 23000, '8999999001124', 'PCS', 3, NULL, 'Y', 1656841172, 0, 2, NULL),
(101, 'LIFEBUOY BW SHISO & MINERAL 250 ML', 4, 'EXP : 15 AGUSTUS 2024', 23590, 25500, '8999999574932', 'PCS', 3, NULL, 'Y', 1656841357, 0, 2, NULL),
(103, 'LIFEBUOY BW SANDALWOOD 250 ML', 4, 'EXP : 07 OKTOBER 2024', 23590, 25500, '8999999574949', 'PCS', 3, NULL, 'Y', 1656841539, 0, 2, NULL),
(104, 'LIFEBUOY BW SANDALWOOD 450 ML', 4, 'EXP : 29 JULY 2024', 29465, 31500, '8999999574970', 'PCS', 3, NULL, 'Y', 1656841599, 0, 2, NULL),
(105, 'LIFEBUOY BW TOTAL10 250ML', 4, 'EXP : 25 SEPTEMBER 2024', 21015, 23000, '8999999001117', 'PCS', 3, NULL, 'Y', 1656841680, 0, 2, NULL),
(106, 'LIFEBUOY BW TOTAL 10 450ML', 4, 'EXP : 13 OKTOBER 2024', 26220, 28000, '8999999001193', 'PCS', 3, NULL, 'Y', 1656841726, 0, 2, NULL),
(107, 'LIFEBUOY BW YOGHURT CARE 450ML', 4, 'EXP : 23 NOV 2024', 29465, 31500, '8999999559526', 'PCS', 3, NULL, 'Y', 1656841798, 0, 2, NULL),
(108, 'LIFEBUOY BW SHISO&MINERAL 450ML', 4, 'EXP : 04 OKTOBER 2024', 29465, 31500, '8999999574963', 'PCS', 3, NULL, 'Y', 1656842311, 0, 2, NULL),
(109, 'SAMPO LIFEBUOY ANTI KETOMBE 170ML', 4, 'EXP : 07 SEPTEMBER 2024', 23004, 25000, '8999999033217', 'PCS', 3, NULL, 'Y', 1656842535, 0, 2, NULL),
(110, 'SAMPO LIFEBUOY ANTI KETOMBE 70ML', 4, 'EXP : 23 OKT 2024', 11518, 13000, '8999999033200', 'PCS', 3, NULL, 'Y', 1656842582, 0, 2, NULL),
(111, 'SAMPO LIFEBUOY KUAT & BERKILAU 170ML', 4, 'EXP : 21 OKT 2023', 23004, 25000, '8999999033170', 'PCS', 3, NULL, 'Y', 1656842650, 0, 2, NULL),
(112, 'SAMPO LIFEBUOY KUAT & BERKILAU 70ML', 4, 'EXP : 27 NOVEMBER 2024', 11518, 13500, '8999999033163', 'PCS', 3, NULL, 'Y', 1656842697, 0, 2, NULL),
(113, 'SAMPO LIFEBUOY RAMBUT RONTOK 170ML', 4, 'EXP : 23 OKT 2024', 23004, 25000, '8999999033132', 'PCS', 3, NULL, 'Y', 1656842762, 0, 2, NULL),
(114, 'SAMPO LIFEBUOY RAMBUT RONTOK 70ML', 4, 'EXP : 17 OKT 2024', 11518, 13500, '8999999033125', 'PCS', 3, NULL, 'Y', 1656842799, 0, 2, NULL),
(115, 'SABUN LIFEBUOY MATCHA 70G', 4, 'EXP : 09 OKT 2024', 3490, 4500, '8999999530662', 'PCS', 12, NULL, 'Y', 1656843041, 0, 2, NULL),
(116, 'SABUN LIFEBUOY COOLFRESH 70G', 4, 'EXP : 09 OKT 2024', 3490, 4500, '8999999059347', 'PCS', 12, NULL, 'Y', 1656843071, 0, 2, NULL),
(118, 'SABUN LIFEBUOY MILDCARE 70G', 4, 'EXP : 09 OKT 2024', 3490, 4000, '8999999059316', 'PCS', 12, NULL, 'Y', 1656843201, 1656844325, 2, NULL),
(119, 'SABUN LIFEBUOY TOTAL10 70G', 4, 'EXP : 09 OKT 2024', 3490, 4000, '8999999059309', 'PCS', 12, NULL, 'Y', 1656843245, 1656844310, 2, NULL),
(120, 'SABUN LUX MAGICAL ORCHID', 4, 'EXP : 12 JUNI 2024', 3930, 4500, '8999999036690', 'PCS', 6, NULL, 'Y', 1656843569, 0, 2, NULL),
(121, 'SABUN LUX SOFT ROSE', 4, 'EXP : 12 JUNI 2024', 3930, 4500, '8999999036607', 'PCS', 6, NULL, 'Y', 1656843604, 0, 2, NULL),
(122, 'SABUN LUX LYLY FRESH', 4, 'EXP : 12 JUNI 2024', 3930, 4500, '8999999031107', 'PCS', 6, NULL, 'Y', 1656843631, 0, 2, NULL),
(123, 'SABUN LUX BLUE PEONY', 4, 'EXP : 12 JUNI 2024', 3930, 4500, '8999999036676', 'PCS', 6, NULL, 'Y', 1656843668, 0, 2, NULL),
(124, 'SABUN LUX VELVET JASMINE', 4, 'EXP : 12 JUNI 2024', 3930, 4500, '8999999036638', 'PCS', 6, NULL, 'Y', 1656843696, 0, 2, NULL),
(125, 'SABUN LIFEBUOY LEMON 70G', 4, 'EXP : 12 JUNI 2024', 3490, 4000, '8999999059323', 'PCS', 12, NULL, 'Y', 1656844377, 0, 2, NULL),
(126, 'PEPSODENT ACTION HERBAL 75G', 4, 'EXP : 25 FEB 2025', 7642, 9000, '8999999710880', 'PCS', 6, NULL, 'Y', 1656911300, 0, 2, NULL),
(127, 'PEPSODENT MULTI PROTECTION 65G', 4, 'EXP : 01 MAR 2025', 6161, 8000, '8999999564438', 'PCS', 6, NULL, 'Y', 1656911378, 1656911746, 2, NULL),
(128, 'PEPSODENT PLUS WHITENING 190+20G', 4, 'EXP : 25 FEB 2025', 19513, 21500, '8999999707781', 'PCS', 6, NULL, 'Y', 1656911648, 0, 2, NULL),
(129, 'PEPSODENT MULTI PROTECTION 150G', 4, 'EXP : 21 JAN 2025', 14074, 15500, '8999999564421', 'PCS', 6, NULL, 'Y', 1656911735, 0, 2, NULL),
(130, 'PEPSODENT FRESH COOL MINT 190G', 4, 'EXP : 12 FEB 2025', 11466, 13500, '8999999028701', 'PCS', 6, NULL, 'Y', 1656911855, 0, 2, NULL),
(131, 'PEPSODENT SENSITIVE MINERAL 100G', 4, 'EXP : 21 JAN 2025', 28928, 31000, '8999999035563', 'PCS', 6, NULL, 'Y', 1656911912, 0, 2, NULL),
(132, 'PEPSODENT WHITE  120G', 4, 'EXP : 22 FEB 2025', 7662, 9000, '8999999706173', 'PCS', 12, NULL, 'Y', 1656912052, 0, 2, NULL),
(133, 'PEPSODENT WHITE  190G', 4, 'EXP : 25 FEB 2025', 11466, 13500, '8999999706180', 'PCS', 6, NULL, 'Y', 1656912119, 0, 2, NULL),
(134, 'PEPSODENT WHITE  75G', 4, 'EXP : 07 APRIL 2025', 4240, 6000, '8999999706081', 'PCS', 12, NULL, 'Y', 1656912220, 0, 2, NULL),
(135, 'PEPSODENT WHITE  225G', 4, 'EXP : 24 APRIL 2025', 13425, 15000, '8999999037765', 'PCS', 6, NULL, 'Y', 1656912287, 1656980329, 2, NULL),
(136, 'SIKAT GIGI PEPSODENT FAMILI', 4, 'EXP : 25 FEB 2025', 1998, 3000, '8999999520151', 'PCS', 12, NULL, 'Y', 1656912657, 0, 2, NULL),
(137, 'SIKAT GIGI TB BRILIAN ', 4, 'EXP : 25 FEB 2025', 3053, 4000, '8999999574802', 'PCS', 12, NULL, 'Y', 1656912751, 0, 2, NULL),
(138, 'SIKAT GIGI TB BRILIAN ISI 3', 4, 'EXP : 25 FEB 2025', 7715, 10000, '8999999574819', 'PCS', 6, NULL, 'Y', 1656912842, 0, 2, NULL),
(139, 'PONDS BRIGHT BEAUTY WHIP', 4, 'EXP : 07 FEB 2025', 26331, 29300, '8999999562182', 'PCS', 3, NULL, 'Y', 1656913112, 0, 2, NULL),
(140, 'PONDS TONE UP', 4, 'EXP : 28 JUN 2025', 31003, 32500, '8999999534844', 'PCS', 3, NULL, 'Y', 1656913169, 1656913240, 2, NULL),
(141, 'PONDS PURE BRIGHT', 4, 'EXP : 15 MARET 2025', 30032, 31500, '8999999053048', 'PCS', 3, NULL, 'Y', 1656913220, 0, 2, NULL),
(142, 'REXONA ADVENCED BRIGHTENING', 4, 'EXP : 17 MAR 2024', 18593, 20000, '8999999049447', 'PCS', 3, NULL, 'Y', 1656913550, 0, 2, NULL),
(143, 'REXONA FREE SPIRIT', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999049454', 'PCS', 3, NULL, 'Y', 1656913594, 0, 2, NULL),
(144, 'REXONA MEN ACTIV BRIGHT', 4, 'EXP :10 MEI 2024', 18593, 20000, '8999999580797', 'PCS', 3, NULL, 'Y', 1656913630, 0, 2, NULL),
(145, 'REXONA MEN ICE COOL', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999580735', 'PCS', 3, NULL, 'Y', 1656913652, 0, 2, NULL),
(146, 'REXONA MEN ANTIBACTERIAL', 4, 'EXP :10 MEI 2024', 18593, 20000, '8999999580780', 'PCS', 3, NULL, 'Y', 1656913701, 0, 2, NULL),
(147, 'REXONA MEN LIME FRESH', 4, 'EXP :10 MEI 2024', 18593, 20000, '8999999580810', 'PCS', 3, NULL, 'Y', 1656913750, 0, 2, NULL),
(148, 'REXONA MEN INVISIBLE DRY', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999580773', 'PCS', 3, NULL, 'Y', 1656913783, 0, 2, NULL),
(149, 'REXONA MEN CHARCOAL', 4, 'EXP :10 MEI 2024', 18593, 20000, '8999999580803', 'PCS', 3, NULL, 'Y', 1656913843, 0, 2, NULL),
(150, 'REXONA MEN SPORT DEFENSE', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999580742', 'PCS', 3, NULL, 'Y', 1656913872, 0, 2, NULL),
(151, 'REXONA MEN ADVENTURE', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999580759', 'PCS', 3, NULL, 'Y', 1656913992, 0, 2, NULL),
(152, 'REXONA MEN ULTRA RECHARE', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999580766', 'PCS', 3, NULL, 'Y', 1656914075, 0, 2, NULL),
(153, 'REXONA PASSION FRESH', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999049485', 'PCS', 3, NULL, 'Y', 1656914111, 0, 2, NULL),
(154, 'REXONA POWDER DRY', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999049492', 'PCS', 3, NULL, 'Y', 1656914146, 0, 2, NULL),
(155, 'REXONA DREAMY BRIGHT', 4, 'EXP :10 MEI 2024', 13265, 15000, '8999999534660', 'PCS', 3, NULL, 'Y', 1656914182, 0, 2, NULL),
(156, 'REXONA GLOWING + SOFT GLOW', 4, 'EXP :10 MEI 2024', 13265, 15500, '8999999534677', 'PCS', 3, NULL, 'Y', 1656914210, 0, 2, NULL),
(157, 'REXONA SHOWER CLEAN', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999049508', 'PCS', 3, NULL, 'Y', 1656914243, 0, 2, NULL),
(158, 'REXONA WOMEN ANTIBACTERIAL', 4, 'EXP :10 MEI 2024\r\n', 18593, 20000, '8999999520175', 'PCS', 3, NULL, 'Y', 1656914288, 0, 2, NULL),
(159, 'REXONA WOMEN DRY FRESH', 4, 'EXP :10 MEI 2024', 16317, 18000, '8999999049461', 'PCS', 3, NULL, 'Y', 1656914334, 0, 2, NULL),
(160, 'RINSO MOLTO ROSE 770G', 4, 'EXP :10 MEI 2024', 30585, 32000, '8999999045265', 'PCS', 3, NULL, 'Y', 1656914621, 0, 2, NULL),
(161, 'RINSO CLASSIC 770G', 4, 'EXP :10 MEI 2024', 30585, 32000, '8999999401238', 'PCS', 3, NULL, 'Y', 1656914711, 0, 2, NULL),
(162, 'RINSO ROYAL GOLD 770G', 4, 'EXP :10 MEI 2024', 30585, 32000, '8999999526887', 'PCS', 3, NULL, 'Y', 1656914753, 0, 2, NULL),
(163, 'RINSO PARFUMEESSENCE 770G', 4, 'EXP :10 MEI 2024', 30585, 32000, '8999999518998', 'PCS', 3, NULL, 'Y', 1656914798, 0, 2, NULL),
(164, 'RINSO ROSE FRESH 440G', 4, 'EXP :10 MEI 2024', 8415, 10000, '8999999570804', 'PCS', 3, NULL, 'Y', 1656914841, 0, 2, NULL),
(165, 'RINSO CLASSIC FRESH 440G', 4, 'EXP :10 MEI 2024', 8415, 10000, '8999999572921', 'PCS', 3, NULL, 'Y', 1656914876, 0, 2, NULL),
(166, 'RINSO ROSE FRESH 215G', 4, 'EXP :10 MEI 2024', 4250, 5000, '8999999500641', 'PCS', 3, NULL, 'Y', 1656914934, 0, 2, NULL),
(167, 'RINSO PARFUME ESSENCE 215G', 4, 'EXP :10 MEI 2024', 4250, 5000, '8999999520106', 'PCS', 3, NULL, 'Y', 1656915093, 0, 2, NULL),
(168, 'RINSO MOLTO ROSE 200ML', 4, 'EXP :10 MEI 2024', 4250, 5000, '8999999514495', 'PCS', 3, NULL, 'Y', 1656915125, 0, 2, NULL),
(169, 'RINSO ANTI NODA 200ML', 4, 'EXP :10 MEI 2024\r\n', 4250, 5000, '8999999514518', 'PCS', 3, NULL, 'Y', 1656915160, 0, 2, NULL),
(170, 'RINSO PARFUMEESSENCE 750ML', 4, 'EXP :10 MEI 2024', 27965, 30000, '8999999042608', 'PCS', 3, NULL, 'Y', 1656915234, 0, 2, NULL),
(171, 'RINSO ANTI NODA 750ML', 4, 'EXP :10 MEI 2024\r\n', 27965, 29500, '8999999016128', 'PCS', 3, NULL, 'Y', 1656915263, 1656980135, 2, NULL),
(172, 'SUNLIGHT EXTRA ANTI BAU', 4, 'EXP :10 MEI 2024', 22200, 24000, '8999999524838', 'PCS', 3, NULL, 'Y', 1656915582, 0, 2, NULL),
(173, 'SUNLIGHT EXTRA HIGENIS', 4, 'EXP :10 MEI 2024', 22200, 24000, '8999999524807', 'PCS', 3, NULL, 'Y', 1656915610, 0, 2, NULL),
(174, 'SUNLIGHT JERUK NIPIS 755 ML', 4, 'EXP :10 MEI 2024', 22200, 24000, '8999999390198', 'PCS', 6, NULL, 'Y', 1656915674, 0, 2, NULL),
(175, 'SUNLIGHT JERUK NIPIS 210 ML', 4, 'EXP :10 MEI 2024', 4510, 5000, '8999999059781', 'PCS', 12, NULL, 'Y', 1656915777, 0, 2, NULL),
(176, 'SUNLIGHT JERUK NIPIS 370 ML', 4, 'EXP :10 MEI 2024', 7290, 8500, '8999999585297', 'PCS', 12, NULL, 'Y', 1656915887, 0, 2, NULL),
(177, 'SUNLIGHT JERUK NIPIS 90 ML', 4, 'EXP :10 MEI 2024', 1750, 2000, '8999999050009', 'PCS', 12, NULL, 'Y', 1656915974, 1656919252, 2, NULL),
(178, 'SUNLIGHT JERUK NIPIS 750 ML', 4, 'EXP :10 MEI 2024', 36464, 38500, '8999999036355', 'PCS', 3, NULL, 'Y', 1656916152, 0, 2, NULL),
(179, 'SUNLIGHT JERUK NIPIS 400 ML', 4, 'EXP :10 MEI 2024', 20036, 21500, '8999999036348', 'PCS', 3, NULL, 'Y', 1656916211, 0, 2, NULL),
(180, 'ROYCO AYAM 94 G', 4, 'EXP :10 MEI 2024', 4350, 5000, '8999999192150', 'PCS', 6, NULL, 'Y', 1656916337, 0, 2, NULL),
(181, 'ROYCO AYAM 230 G', 4, 'EXP :10 MEI 2024', 8500, 10000, '8999999516208', 'PCS', 6, NULL, 'Y', 1656916413, 0, 2, NULL),
(182, 'ROYCO SAPI 230 G', 4, 'EXP :10 MEI 2024', 8500, 10000, '8999999516215', 'PCS', 6, NULL, 'Y', 1656916448, 0, 2, NULL),
(183, 'SUNSILK BLACK SHINE 160 ML', 4, 'EXP :10 MEI 2024', 22850, 24500, '8999999048181', 'PCS', 3, NULL, 'Y', 1656916632, 0, 2, NULL),
(184, 'SUNSILK BLACK SHINE 70 ML', 4, 'EXP :10 MEI 2024', 12050, 13500, '8999999048174', 'PCS', 3, NULL, 'Y', 1656916668, 0, 2, NULL),
(185, 'SUNSILK HIJAB ANTIDANDRUFF', 4, 'EXP :10 MEI 2024', 22850, 24500, '8999999048501', 'PCS', 3, NULL, 'Y', 1656916754, 0, 2, NULL),
(186, 'SUNSILK SHAMPOO SOFT 160ML', 4, 'EXP :10 MEI 2024', 22850, 24500, '8999999048266', 'PCS', 3, NULL, 'Y', 1656916788, 0, 2, NULL),
(187, 'SUNSILK SHAMPOO SOFT 70ML', 4, NULL, 12050, 13500, '8999999048259', 'PCS', 3, NULL, 'Y', 1656916836, 0, 2, NULL),
(188, 'SUNSILK HELLO LEMBUT 160 ML', 4, NULL, 22850, 24500, '8999999565473', 'PCS', 3, NULL, 'Y', 1656916871, 0, 2, NULL),
(189, 'TRESemme ANTI KETOMBE 170 ML', 4, 'EXP :10 MEI 2024', 31580, 33500, '8999999526467', 'PCS', 3, NULL, 'Y', 1656917060, 0, 2, NULL),
(190, 'TRESemme KERATIN SMOOTH 170 ML', 4, 'EXP :10 MEI 2024', 33324, 35000, '8999999526382', 'PCS', 3, NULL, 'Y', 1656917087, 0, 2, NULL),
(191, 'SUPERPELL PINK 770 ML', 4, 'EXP :10 MEI 2024', 15929, 17500, '8999999057022', 'PCS', 3, NULL, 'Y', 1656917165, 0, 2, NULL),
(192, 'SUPERPELL APPLE 770 ML', 4, 'EXP :10 MEI 2024', 15929, 17500, '8999999406929', 'PCS', 3, NULL, 'Y', 1656917193, 0, 2, NULL),
(193, 'SUPERPELL ROSE 770 ML', 4, 'EXP :10 MEI 2024', 15929, 17500, '8999999406912', 'PCS', 3, NULL, 'Y', 1656917227, 0, 2, NULL),
(194, 'SUPERPELL LEMON 770 ML', 4, 'EXP :10 MEI 2024', 15929, 17500, '8999999406943', 'PCS', 3, NULL, 'Y', 1656917260, 0, 2, NULL),
(195, 'SUPERPELL ANTI-BAC 500 ML', 4, 'EXP :10 MEI 2024', 8121, 10000, '8999999581985', 'PCS', 3, NULL, 'Y', 1656917293, 0, 2, NULL),
(196, 'WIPOL BOTOL 750 ML', 4, 'EXP :10 MEI 2024', 29915, 31500, '8999999006204', 'PCS', 3, NULL, 'Y', 1656917468, 0, 2, NULL),
(197, 'WIPOL BOTOL 450 ML', 4, 'EXP :10 MEI 2024', 19647, 22000, '8999999407896', 'PCS', 3, NULL, 'Y', 1656917522, 0, 2, NULL),
(198, 'WIPOL KARBOL CEMARA 750ML', 4, 'EXP :10 MEI 2024', 20702, 22500, '8999999407919', 'PCS', 3, NULL, 'Y', 1656917560, 0, 2, NULL),
(199, 'WIPOL KARBOL LEMON 750ML', 4, 'EXP :10 MEI 2024', 20702, 22500, '8999999407858', 'PCS', 3, NULL, 'Y', 1656917608, 0, 2, NULL),
(200, 'WIPOL SEREH & JERUK 750ML', 4, 'EXP :10 MEI 2024', 20702, 22500, '8999999529307', 'PCS', 3, NULL, 'Y', 1656917660, 0, 2, NULL),
(201, 'WIPOL KARBOL EUCALYPTUS 450ML', 4, 'EXP :10 MEI 2024', 8118, 10000, '8999999581312', 'PCS', 3, NULL, 'Y', 1656917704, 0, 2, NULL),
(202, 'WIPOL BIOSHIELD 450 ML', 4, 'EXP :10 MEI 2024', 8118, 10000, '8999999581992', 'PCS', 3, NULL, 'Y', 1656917736, 0, 2, NULL),
(203, 'BABYPOWDER ZWITSAL ALOE VERA', 4, 'EXP :10 MEI 2024', 20900, 22000, '8999999034481', 'PCS', 2, NULL, 'Y', 1656918004, 1656949874, 2, NULL),
(204, 'BABYPOWDER ZWITSAL RICH HONEY', 4, NULL, 19350, 21500, '8992694244513', 'PCS', 2, NULL, 'Y', 1656918047, 0, 2, NULL),
(205, 'MINYAK TELON ZWITSAL PLUS', 4, 'EXP :10 MEI 2024', 31900, 33000, '8999999537326', 'PCS', 3, NULL, 'Y', 1656918168, 0, 2, NULL),
(206, 'ZWITSAL RICH HONEY 200ML', 4, 'EXP :10 MEI 2024', 23000, 24500, '8992694247507', 'PCS', 3, NULL, 'Y', 1656918496, 1656918806, 2, NULL),
(207, 'ZWITSAL ALOE VERA 200ML', 4, 'EXP :10 MEI 2024', 23000, 24500, '8992694247255', 'PCS', 3, NULL, 'Y', 1656918533, 0, 2, NULL),
(208, 'SAMPO ZWITSAL NATURAL&NOURISHING 180ML', 4, 'EXP :10 MEI 2024', 16200, 18000, '8999999552480', 'PCS', 3, NULL, 'Y', 1656918593, 0, 2, NULL),
(209, 'SAMPO ZWITSAL CLEAN&FRESH 180ML', 4, 'EXP :10 MEI 2024', 16200, 18000, '8999999552497', 'PCS', 3, NULL, 'Y', 1656918622, 0, 2, NULL),
(210, 'SAMPO ZWITSAL SOFT 180ML', 4, 'EXP :10 MEI 2024', 16200, 18000, '8999999552503', 'PCS', 3, NULL, 'Y', 1656918649, 0, 2, NULL),
(211, 'SABUN ZWITSAL ALOE VERA 450 ML', 4, 'EXP :10 MEI 2024', 33350, 35000, '8999999044206', 'PCS', 3, NULL, 'Y', 1656918741, 0, 2, NULL),
(212, 'ZWITSAL RICH HONEY 450 ML', 4, 'EXP :10 MEI 2024', 35550, 37000, '8999999044190', 'PCS', 3, NULL, 'Y', 1656918790, 0, 2, NULL),
(213, 'SAMPO ZWITSAL ALOE VERA 100ML', 4, NULL, 12900, 14500, '8992694246340', 'PCS', 3, NULL, 'Y', 1656918891, 0, 2, NULL),
(214, 'SABUN ZWITSAL ALOE VERA 300 ML', 4, 'EXP :10 MEI 2024', 29700, 31000, '8999999034061', 'PCS', 3, NULL, 'Y', 1656918918, 0, 2, NULL),
(215, 'PERAWATAN RAMBUT ZWITSAL 100ML', 4, 'EXP :10 MEI 2024', 22600, 24000, '8992694246166', 'PCS', 3, NULL, 'Y', 1656918969, 1656919014, 2, NULL),
(216, 'COLOGNE ZWITSAL 100ML', 4, 'EXP :10 MEI 2024', 20000, 21500, '8992694242113', 'PCS', 3, NULL, 'Y', 1656919063, 0, 2, NULL),
(217, 'SAMPO & SABUN ZWITSAL 100ML', 4, NULL, 12200, 14000, '8999999032128', 'PCS', 3, NULL, 'Y', 1656919102, 0, 2, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `returnproduk`
--

CREATE TABLE IF NOT EXISTS `returnproduk` (
`id_return` int(11) NOT NULL,
  `asalfaktur` varchar(11) NOT NULL,
  `produkreturn` varchar(15) NOT NULL,
  `qtyreturn` int(11) NOT NULL,
  `ketreturn` varchar(255) NOT NULL,
  `addedreturn` int(11) NOT NULL,
  `addbyreturn` int(11) NOT NULL,
  `tercatatreturn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `namareturn` varchar(50) DEFAULT NULL,
  `hargadasar` double DEFAULT NULL,
  `hargajual` double DEFAULT NULL,
  `periode` varchar(5) NOT NULL,
  `tglreturn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE IF NOT EXISTS `stok` (
`id_stok` int(11) NOT NULL,
  `status` enum('T','K') NOT NULL,
  `qty` int(11) NOT NULL,
  `produkID` int(11) NOT NULL,
  `oldStok` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `namaproduk` varchar(100) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `tastok` varchar(5) NOT NULL DEFAULT '2021',
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `tercatat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Mencatat Perubahan Stok Barang' AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id_stok`, `status`, `qty`, `produkID`, `oldStok`, `barcode`, `namaproduk`, `ket`, `tastok`, `added`, `addby`, `tercatat`) VALUES
(1, 'T', 9, 116, 3, '8999999059347', 'SABUN LIFEBUOY COOLFRESH 70G', NULL, '2022', 1656843148, 2, '2022-07-03 10:12:28'),
(2, 'K', 2, 203, 3, '8999999034481', 'BABYPOWDER ZWITSAL ALOE VERA', NULL, '2022', 1656918065, 2, '2022-07-04 07:01:05'),
(3, 'T', 1, 203, 1, '8999999034481', 'BABYPOWDER ZWITSAL ALOE VERA', NULL, '2022', 1656918083, 2, '2022-07-04 07:01:23'),
(4, 'K', 3, 69, 6, '8999999529604', 'SHAMPO CLEAR COMPLETE CARE MEN', NULL, '2022', 1656950211, 2, '2022-07-04 15:56:51'),
(5, 'K', 3, 141, 6, '8999999053048', 'PONDS PURE BRIGHT', NULL, '2022', 1656950445, 2, '2022-07-04 16:00:45'),
(6, 'K', 3, 70, 6, '8999999529710', 'SHAMPO CLEAR COOL SPORT MEN', NULL, '2022', 1656950723, 2, '2022-07-04 16:05:23'),
(7, 'K', 3, 68, 6, '8999999529628', 'SHAMPO CLEAR SOFT CARE', NULL, '2022', 1656950740, 2, '2022-07-04 16:05:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE IF NOT EXISTS `tb_admin` (
`id_admin` int(11) NOT NULL,
  `Login` varchar(10) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `gender_admin` enum('L','P') NOT NULL,
  `address_admin` varchar(255) DEFAULT NULL,
  `email_admin` varchar(100) NOT NULL,
  `hp_admin` varchar(12) NOT NULL,
  `photo_admin` varchar(100) DEFAULT NULL,
  `Level` int(11) NOT NULL,
  `active_admin` enum('Y','N') NOT NULL,
  `waktuawal_admin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `key_admin` varchar(50) DEFAULT NULL,
  `cabang_id` int(11) NOT NULL COMMENT 'Agar mudah proses perubahan daripada Kode'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `Login`, `Password`, `nama_admin`, `gender_admin`, `address_admin`, `email_admin`, `hp_admin`, `photo_admin`, `Level`, `active_admin`, `waktuawal_admin`, `key_admin`, `cabang_id`) VALUES
(2, 'admin', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'G Mart', 'L', 'JL.Raya Sungai Rotan Cupak (GUDAN)', 'ghalihmandaveqia24@gmail.com', '082283751455', '262bba13a80502.png', 2, 'Y', '2021-02-17 08:19:10', 'admin123', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_config`
--

CREATE TABLE IF NOT EXISTS `tb_config` (
`id_config` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `header` varchar(50) DEFAULT NULL,
  `footer` varchar(100) DEFAULT NULL,
  `text1` varchar(255) DEFAULT NULL,
  `text2` text,
  `text3` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_config`
--

INSERT INTO `tb_config` (`id_config`, `title`, `deskripsi`, `header`, `footer`, `text1`, `text2`, `text3`) VALUES
(1, 'G Mart', 'www.instagram.com/ghalihmahdaveqia/', 'KASIR', 'G Mart', 'Jl. Raya Sungai Rotan Cupak (GUDAN)<br>No. HP: 082283751455', 'Terima Kasih telah belanja di <br>G-Mart -', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_master`
--

CREATE TABLE IF NOT EXISTS `tb_master` (
`id_master` int(11) NOT NULL,
  `Login` varchar(10) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `nama_master` varchar(50) NOT NULL,
  `photo_master` varchar(100) DEFAULT NULL,
  `key_master` varchar(25) NOT NULL,
  `Level` int(11) NOT NULL,
  `active_master` enum('Y','N') NOT NULL,
  `cabang_id` int(11) NOT NULL COMMENT '26 Desember'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_master`
--

INSERT INTO `tb_master` (`id_master`, `Login`, `Password`, `nama_master`, `photo_master`, `key_master`, `Level`, `active_master`, `cabang_id`) VALUES
(1, 'ghalihinz', '*DAC9B1342D5405EBD61C82FF7BC93323F87F1D43', 'GHALIH MASTER', '15fe69de13253c.png', 'codeegoc', 1, 'Y', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_menu`
--

CREATE TABLE IF NOT EXISTS `tb_menu` (
`id_menu` int(11) NOT NULL,
  `nourut_menu` int(11) DEFAULT NULL,
  `link_menu` varchar(50) DEFAULT NULL,
  `icon_menu` varchar(30) DEFAULT NULL,
  `text_menu` varchar(30) DEFAULT NULL,
  `color_menu` varchar(15) DEFAULT NULL,
  `label_menu` varchar(30) DEFAULT NULL,
  `level_menu` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data untuk tabel `tb_menu`
--

INSERT INTO `tb_menu` (`id_menu`, `nourut_menu`, `link_menu`, `icon_menu`, `text_menu`, `color_menu`, `label_menu`, `level_menu`) VALUES
(1, 1, '?page=update/profile', 'fa  fa-user', 'PROFILE', 'bg-green', 'new ', 12345),
(2, 2, '?page=update/password', 'fa  fa-key', 'CHANGE PASSWORD', 'bg-blue', 'new', 12345),
(3, 3, '?page=insert/menu ', 'fa  fa-firefox', 'SETTING MENU ', 'bg-blue', 'new', 1),
(4, 4, '?page=update/ta   ', 'fa fa-balance-scale', 'SETTING PERIODE', 'bg-blue', 'new', 12),
(6, 5, '?page=insert/config', 'fa fa-registered', 'SET WEBSITE', 'bg-yellow', 'new', 12),
(7, 99, '../keluar.php    ', 'fa fa-sign-out', 'LOGOUT', 'bg-green', 'out', 12345),
(8, 6, '?page=insert/photo', 'fa fa-commenting', 'UPLOAD PHOTO', 'bg-blue', 'new', 12345),
(9, 7, '?page=insert/admin', 'fa fa-500px', 'ADD ADMINISTRATOR', 'bg-yellow', 'new', 1),
(11, 9, '?page=informasi/view', 'fa fa-comment', 'INFORMASI', 'bg-blue', 'new', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_photo`
--

CREATE TABLE IF NOT EXISTS `tb_photo` (
`id_photo` int(11) NOT NULL,
  `pemilik_photo` int(11) NOT NULL,
  `images_photo` varchar(60) NOT NULL,
  `waktuawal_photo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tanggal_photo` date NOT NULL,
  `ct_photo` datetime NOT NULL,
  `ut_photo` datetime NOT NULL,
  `rt_photo` datetime NOT NULL,
  `cb_photo` int(11) NOT NULL,
  `ub_photo` int(11) NOT NULL,
  `rb_photo` int(11) NOT NULL,
  `active_photo` enum('Y','N') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `tb_photo`
--

INSERT INTO `tb_photo` (`id_photo`, `pemilik_photo`, `images_photo`, `waktuawal_photo`, `tanggal_photo`, `ct_photo`, `ut_photo`, `rt_photo`, `cb_photo`, `ub_photo`, `rb_photo`, `active_photo`) VALUES
(1, 14, '145f7193cd38f7f.png', '2020-09-27 17:42:05', '2020-09-28', '2020-09-28 14:42:05', '2020-09-28 14:42:05', '2020-09-28 14:42:05', 14, 0, 0, 'Y'),
(7, 2, '262bb91b417097.png', '2022-06-28 23:41:40', '2022-06-29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 0, 'Y'),
(8, 2, '262bba11288ca4.png', '2022-06-29 00:47:14', '2022-06-29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 0, 'Y'),
(10, 2, '262bba13a80502.png', '2022-06-29 00:47:54', '2022-06-29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 0, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_riwayat_login`
--

CREATE TABLE IF NOT EXISTS `tb_riwayat_login` (
`id_login` int(11) NOT NULL,
  `username_login` varchar(10) NOT NULL,
  `password_login` varchar(10) NOT NULL,
  `status_login` enum('Y','N') NOT NULL,
  `added_login` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=190 ;

--
-- Dumping data untuk tabel `tb_riwayat_login`
--

INSERT INTO `tb_riwayat_login` (`id_login`, `username_login`, `password_login`, `status_login`, `added_login`) VALUES
(122, 'admin', '123123*', 'Y', 1643254519),
(123, 'admin', '123123*', 'Y', 1643258713),
(124, 'admin', '123123*', 'Y', 1653142006),
(125, 'codeego', '12345123*', 'Y', 1653142298),
(126, 'ghalihinz', '12345123*', 'Y', 1653142392),
(127, 'admin', '123123*', 'Y', 1653144609),
(128, 'ghalihinz', '12345123*', 'Y', 1653144691),
(129, 'admin', '123123*', 'Y', 1653144749),
(130, 'admin', '123123*', 'Y', 1653145050),
(131, 'admin', '123123*', 'Y', 1653172135),
(132, 'sudir', '1234527911', 'N', 1653172792),
(133, 'sudir', '1234523738', 'N', 1653172797),
(134, 'kasir', '123123*', 'Y', 1653172802),
(135, 'ghalihinz', 'akun111115', 'N', 1653172851),
(136, 'admin', '123123*', 'Y', 1653172861),
(137, 'admin', '123123*', 'Y', 1653178222),
(138, 'admin', '123123*', 'Y', 1653179488),
(139, 'admin', '123123*', 'Y', 1653180276),
(140, 'admin', '123123*', 'Y', 1653209235),
(141, 'admin', '123123*', 'Y', 1653217753),
(142, 'admin', '123123*', 'Y', 1653267809),
(143, 'admin', '123123*', 'Y', 1653287538),
(144, 'admin', '123123*', 'Y', 1653305295),
(145, 'admin', '123123*', 'Y', 1653393664),
(146, 'admin', '123123*', 'Y', 1653455970),
(147, 'admin', '123123*', 'Y', 1653465336),
(148, 'ghalihinz', 'akun111163', 'N', 1653472990),
(149, 'ghalihinz', '12345123*', 'Y', 1653472996),
(150, 'sudir', '1234515984', 'N', 1653473016),
(151, 'admin', '123123*', 'Y', 1653473025),
(152, 'sudir', '123123*', 'Y', 1653473057),
(153, 'sudir', '123123*', 'Y', 1653473064),
(154, 'kasir', '123123*', 'Y', 1653473248),
(155, 'kasir', '123123*', 'Y', 1653473258),
(156, 'admin', '123123*', 'Y', 1653473261),
(157, 'kasir', '12345123*', 'Y', 1653473281),
(158, 'kasir', '12345123*', 'Y', 1653473299),
(159, 'admin', '123123*', 'Y', 1653473349),
(160, 'admin', '123123*', 'Y', 1653519821),
(161, 'Admin', '123123*', 'Y', 1653519846),
(162, 'admin', '123123*', 'Y', 1653571513),
(163, 'ghalihinz', 'akun111114', 'N', 1653575591),
(164, 'ghalihinz', '1111123*', 'Y', 1653575616),
(165, 'admin', '123123*', 'Y', 1653709994),
(166, 'admin', '123123*', 'Y', 1653911608),
(167, 'admin', '123123*', 'Y', 1653912045),
(168, 'admin', '123123*', 'Y', 1653912295),
(169, 'admin', '123123*', 'Y', 1656415754),
(170, 'ghalihinz', '1234529063', 'N', 1656415938),
(171, 'admin', '123123*', 'Y', 1656415942),
(172, 'ghalihinz', 'akun111112', 'Y', 1656416056),
(173, 'admin', '123123*', 'Y', 1656423984),
(174, 'kasir', '12310420', 'N', 1656424377),
(175, 'kasir', '123123*', 'Y', 1656424418),
(176, 'kasir', '123123*', 'Y', 1656424432),
(177, 'admin', '123123*', 'Y', 1656424674),
(178, 'admin', '123123*', 'Y', 1656459612),
(179, 'admin', '123123*', 'Y', 1656459727),
(180, 'admin', '123123*', 'Y', 1656637307),
(181, 'admin', '123123*', 'Y', 1656753375),
(182, 'admin', '123123*', 'Y', 1656762863),
(183, 'admin', '123123*', 'Y', 1656763508),
(184, 'admin', '123123*', 'Y', 1656764513),
(185, 'admin', '123123*', 'Y', 1656835278),
(186, 'admin', '123123*', 'Y', 1656911214),
(187, 'admin', '123123*', 'Y', 1656927377),
(188, 'admin', '123123*', 'Y', 1656949727),
(189, 'admin', '123123*', 'Y', 1657061688);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ta`
--

CREATE TABLE IF NOT EXISTS `tb_ta` (
`id_ta` int(11) NOT NULL,
  `kode_ta` varchar(5) NOT NULL,
  `nama_ta` varchar(25) NOT NULL,
  `ket_ta` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `tb_ta`
--

INSERT INTO `tb_ta` (`id_ta`, `kode_ta`, `nama_ta`, `ket_ta`) VALUES
(1, '2022', 'TA. 2022', 'TAHUN PERIODE 2022');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksidetail`
--

CREATE TABLE IF NOT EXISTS `transaksidetail` (
`id` int(11) NOT NULL,
  `faktur` varchar(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) DEFAULT NULL COMMENT 'Mencatat Nama Produk sebelumnya',
  `harga` double NOT NULL,
  `hargadasar` double NOT NULL,
  `diskon` double unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `stt` enum('Y','N') NOT NULL,
  `periode` varchar(5) NOT NULL,
  `admintd` varchar(30) DEFAULT NULL COMMENT 'Mencatat Nama Admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksitemp`
--

CREATE TABLE IF NOT EXISTS `transaksitemp` (
`id` int(11) NOT NULL,
  `faktur` varchar(30) NOT NULL,
  `tanggal` date NOT NULL,
  `kode` varchar(15) NOT NULL,
  `nama` varchar(100) DEFAULT NULL COMMENT 'Mencatat Nama Produk sebelumnya',
  `harga` double NOT NULL,
  `hargadasar` double NOT NULL,
  `diskon` double unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `addby` int(11) NOT NULL,
  `admintt` varchar(30) DEFAULT NULL,
  `stt` enum('Y','N') NOT NULL,
  `periode` varchar(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `transaksitemp`
--

INSERT INTO `transaksitemp` (`id`, `faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`, `qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES
(1, '575506', '2022-05-26', '2391852988492', 'empeng lily', 35000, 25000, 0, 1, 1653575510, 2, 'GNSTORE', 'Y', '2022');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_asset`
--
CREATE TABLE IF NOT EXISTS `view_asset` (
`total_produk` decimal(32,0)
,`modal` double
,`laba` double
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `view_potongan`
--
CREATE TABLE IF NOT EXISTS `view_potongan` (
`potongan` double
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_login`
--
CREATE TABLE IF NOT EXISTS `vw_login` (
`ID` int(11)
,`Login` varchar(10)
,`Password` varchar(50)
,`Level` int(11)
,`Nama` varchar(60)
,`Key` varchar(50)
);
-- --------------------------------------------------------

--
-- Struktur untuk view `view_asset`
--
DROP TABLE IF EXISTS `view_asset`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_asset` AS select sum(`produk`.`stok`) AS `total_produk`,(`produk`.`hargadasar` * `produk`.`stok`) AS `modal`,((`produk`.`hargajual` - `produk`.`hargadasar`) * `produk`.`stok`) AS `laba` from `produk` group by `produk`.`idproduk`;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_potongan`
--
DROP TABLE IF EXISTS `view_potongan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_potongan` AS select sum(`transaksidetail`.`diskon`) AS `potongan` from `transaksidetail` group by `transaksidetail`.`id`;

-- --------------------------------------------------------

--
-- Struktur untuk view `vw_login`
--
DROP TABLE IF EXISTS `vw_login`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_login` AS select `tb_admin`.`id_admin` AS `ID`,`tb_admin`.`Login` AS `Login`,`tb_admin`.`Password` AS `Password`,`tb_admin`.`Level` AS `Level`,`tb_admin`.`nama_admin` AS `Nama`,`tb_admin`.`key_admin` AS `Key` from `tb_admin` where (`tb_admin`.`active_admin` = 'Y') union all select `tb_master`.`id_master` AS `ID`,`tb_master`.`Login` AS `Login`,`tb_master`.`Password` AS `Password`,`tb_master`.`Level` AS `Level`,`tb_master`.`nama_master` AS `Nama`,`tb_master`.`key_master` AS `Key` from `tb_master` where (`tb_master`.`active_master` = 'Y') union all select `kassa`.`id_kassa` AS `ID`,`kassa`.`user_kassa` AS `Login`,`kassa`.`pwd_kassa` AS `Password`,`kassa`.`level_kassa` AS `Level`,`kassa`.`nama_kassa` AS `Nama`,`kassa`.`key_kassa` AS `Key` from `kassa` where (`kassa`.`status_kassa` = 'Y') order by `Login`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_delete`
--
ALTER TABLE `activity_delete`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_update`
--
ALTER TABLE `activity_update`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
 ADD PRIMARY KEY (`id_barcode`), ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
 ADD PRIMARY KEY (`idfaktur`), ADD UNIQUE KEY `kodefaktur` (`kodefaktur`);

--
-- Indexes for table `harga`
--
ALTER TABLE `harga`
 ADD PRIMARY KEY (`idharga`), ADD KEY `kodeproduk` (`kodeproduk`);

--
-- Indexes for table `kassa`
--
ALTER TABLE `kassa`
 ADD PRIMARY KEY (`id_kassa`), ADD UNIQUE KEY `user_kassa` (`user_kassa`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
 ADD PRIMARY KEY (`idkategori`), ADD UNIQUE KEY `namakategori` (`namakategori`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
 ADD PRIMARY KEY (`idperiode`), ADD UNIQUE KEY `kodeperiode` (`kodeperiode`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
 ADD PRIMARY KEY (`idproduk`), ADD UNIQUE KEY `kodeproduk` (`kodeproduk`), ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `returnproduk`
--
ALTER TABLE `returnproduk`
 ADD PRIMARY KEY (`id_return`), ADD KEY `asalfaktur` (`asalfaktur`), ADD KEY `produkreturn` (`produkreturn`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
 ADD PRIMARY KEY (`id_stok`), ADD KEY `produkID` (`produkID`), ADD KEY `barcode` (`barcode`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
 ADD PRIMARY KEY (`id_admin`), ADD UNIQUE KEY `user_admin` (`Login`,`key_admin`), ADD KEY `cabang_id` (`cabang_id`);

--
-- Indexes for table `tb_config`
--
ALTER TABLE `tb_config`
 ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `tb_master`
--
ALTER TABLE `tb_master`
 ADD PRIMARY KEY (`id_master`), ADD UNIQUE KEY `user_master` (`Login`,`key_master`), ADD KEY `cabang_id` (`cabang_id`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
 ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tb_photo`
--
ALTER TABLE `tb_photo`
 ADD PRIMARY KEY (`id_photo`);

--
-- Indexes for table `tb_riwayat_login`
--
ALTER TABLE `tb_riwayat_login`
 ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `tb_ta`
--
ALTER TABLE `tb_ta`
 ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
 ADD PRIMARY KEY (`id`), ADD KEY `kode` (`kode`), ADD KEY `faktur` (`faktur`), ADD KEY `addby` (`addby`);

--
-- Indexes for table `transaksitemp`
--
ALTER TABLE `transaksitemp`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_delete`
--
ALTER TABLE `activity_delete`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `activity_update`
--
ALTER TABLE `activity_update`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
MODIFY `id_barcode` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faktur`
--
ALTER TABLE `faktur`
MODIFY `idfaktur` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `harga`
--
ALTER TABLE `harga`
MODIFY `idharga` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `kassa`
--
ALTER TABLE `kassa`
MODIFY `id_kassa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
MODIFY `idperiode` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=218;
--
-- AUTO_INCREMENT for table `returnproduk`
--
ALTER TABLE `returnproduk`
MODIFY `id_return` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_config`
--
ALTER TABLE `tb_config`
MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_master`
--
ALTER TABLE `tb_master`
MODIFY `id_master` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tb_riwayat_login`
--
ALTER TABLE `tb_riwayat_login`
MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=190;
--
-- AUTO_INCREMENT for table `tb_ta`
--
ALTER TABLE `tb_ta`
MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaksidetail`
--
ALTER TABLE `transaksidetail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaksitemp`
--
ALTER TABLE `transaksitemp`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `harga`
--
ALTER TABLE `harga`
ADD CONSTRAINT `harga_ibfk_1` FOREIGN KEY (`kodeproduk`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `returnproduk`
--
ALTER TABLE `returnproduk`
ADD CONSTRAINT `returnproduk_ibfk_1` FOREIGN KEY (`produkreturn`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`barcode`) REFERENCES `produk` (`kodeproduk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksidetail`
--
ALTER TABLE `transaksidetail`
ADD CONSTRAINT `transaksidetail_ibfk_1` FOREIGN KEY (`faktur`) REFERENCES `faktur` (`kodefaktur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
